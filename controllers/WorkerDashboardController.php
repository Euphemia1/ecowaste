<?php
/**
 * Worker Dashboard Controller for EcoWaste Application
 */

require_once 'BaseController.php';

class WorkerDashboardController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->requireAuth();
        $this->requireWorkerRole();
    }

    /**
     * Display worker dashboard
     */
    public function index() {
        $workerId = $this->getWorkerId();
        
        // Get worker statistics
        $stats = $this->getWorkerStats($workerId);
        
        // Get available pickups
        $availablePickups = $this->getAvailablePickupsData($workerId);
        
        // Get current pickup
        $currentPickup = $this->getCurrentPickup($workerId);
        
        // Get today's schedule
        $todaySchedule = $this->getTodaySchedule($workerId);
        
        // Get earnings summary
        $earnings = $this->getEarningsSummary($workerId);

        $data = [
            'title' => 'Worker Dashboard - EcoWaste',
            'stats' => $stats,
            'available_pickups' => $availablePickups,
            'current_pickup' => $currentPickup,
            'today_schedule' => $todaySchedule,
            'earnings' => $earnings,
            'layout' => 'main'
        ];

        $this->render('worker/dashboard', $data);
    }

    /**
     * Toggle worker availability
     */
    public function toggleAvailability() {
        if (!$this->isPost()) {
            Helpers::redirect('/worker/dashboard');
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $available = $input['available'] ?? false;

        $workerId = $this->getWorkerId();
        $stmt = $this->db->prepare("UPDATE worker_profiles SET status = ? WHERE id = ?");
        $stmt->execute([$available ? 'active' : 'inactive', $workerId]);

        $this->jsonResponse(['success' => true]);
    }

    /**
     * API endpoint to get available pickups
     */
    public function apiGetAvailablePickups() {
        $workerId = $this->getWorkerId();
        $pickups = $this->getAvailablePickupsData($workerId);

        $this->jsonResponse(['success' => true, 'pickups' => $pickups]);
    }

    /**
     * Accept pickup
     */
    public function acceptPickup() {
        if (!$this->isPost()) {
            Helpers::redirect('/worker/dashboard');
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $pickupId = $input['pickup_id'] ?? null;

        if (!$pickupId) {
            $this->jsonResponse(['success' => false, 'message' => 'Pickup ID is required']);
        }

        try {
            $this->db->beginTransaction();

            $workerId = $this->getWorkerId();

            // Check if pickup is still available
            $checkQuery = "
                SELECT pr.*, pa.id as assignment_id 
                FROM pickup_requests pr
                LEFT JOIN pickup_assignments pa ON pr.id = pa.pickup_request_id
                WHERE pr.id = ? AND pr.status = 'confirmed' AND pa.id IS NULL
            ";
            $checkStmt = $this->db->prepare($checkQuery);
            $checkStmt->execute([$pickupId]);
            $pickup = $checkStmt->fetch();

            if (!$pickup) {
                $this->jsonResponse(['success' => false, 'message' => 'Pickup is no longer available']);
            }

            // Create assignment
            $assignQuery = "
                INSERT INTO pickup_assignments (pickup_request_id, worker_id, status, assigned_at)
                VALUES (?, ?, 'assigned', CURRENT_TIMESTAMP)
            ";
            $assignStmt = $this->db->prepare($assignQuery);
            $assignStmt->execute([$pickupId, $workerId]);

            // Update pickup status
            $updateQuery = "UPDATE pickup_requests SET status = 'in_progress' WHERE id = ?";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->execute([$pickupId]);

            $this->db->commit();
            $this->jsonResponse(['success' => true, 'message' => 'Pickup accepted successfully']);

        } catch (Exception $e) {
            $this->db->rollback();
            $this->jsonResponse(['success' => false, 'message' => 'Error accepting pickup']);
        }
    }

    /**
     * Get pickup details
     */
    public function getPickupDetails() {
        $pickupId = $_GET['id'] ?? null;

        if (!$pickupId) {
            echo 'Pickup ID is required';
            return;
        }

        $query = "
            SELECT pr.*, u.first_name, u.last_name, u.phone as customer_phone,
                   ua.address_line_1, ua.address_line_2, ua.city, ua.district, ua.province
            FROM pickup_requests pr
            JOIN users u ON pr.user_id = u.id
            JOIN user_addresses ua ON pr.address_id = ua.id
            WHERE pr.id = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$pickupId]);
        $pickup = $stmt->fetch();

        if (!$pickup) {
            echo 'Pickup not found';
            return;
        }

        // Get waste items
        $itemsQuery = "
            SELECT pri.*, wc.name, wc.icon, wc.color
            FROM pickup_request_items pri
            JOIN waste_categories wc ON pri.waste_category_id = wc.id
            WHERE pri.pickup_request_id = ?
        ";
        $itemsStmt = $this->db->prepare($itemsQuery);
        $itemsStmt->execute([$pickupId]);
        $pickup['items'] = $itemsStmt->fetchAll();

        // Calculate distance (simplified - in real app, use geolocation)
        $pickup['distance_km'] = rand(1, 15);
        $pickup['priority'] = $pickup['estimated_weight'] > 50 ? 'high' : 'normal';
        $pickup['estimated_earnings'] = 50 + ($pickup['estimated_weight'] * 3);

        include '../views/worker/pickup_details.php';
    }

    /**
     * Complete pickup
     */
    public function completePickup() {
        if (!$this->isPost()) {
            Helpers::redirect('/worker/dashboard');
        }

        $data = $this->getPostData([
            'pickup_id' => 'int',
            'actual_weight' => 'float',
            'completion_notes' => 'string'
        ]);

        if (empty($data['pickup_id']) || empty($data['actual_weight'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Pickup ID and actual weight are required']);
        }

        try {
            $this->db->beginTransaction();

            $workerId = $this->getWorkerId();

            // Update pickup
            $updateQuery = "
                UPDATE pickup_requests 
                SET status = 'completed', total_weight = ?, updated_at = CURRENT_TIMESTAMP
                WHERE id = ? AND status = 'in_progress'
            ";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->execute([$data['actual_weight'], $data['pickup_id']]);

            // Update assignment
            $assignQuery = "
                UPDATE pickup_assignments 
                SET status = 'completed', completed_at = CURRENT_TIMESTAMP, notes = ?
                WHERE pickup_request_id = ? AND worker_id = ?
            ";
            $assignStmt = $this->db->prepare($assignQuery);
            $assignStmt->execute([$data['completion_notes'] ?? null, $data['pickup_id'], $workerId]);

            // Calculate earnings
            $baseEarnings = 50;
            $weightEarnings = $data['actual_weight'] * 3;
            $totalEarnings = $baseEarnings + $weightEarnings;

            // Record earnings
            $earningsQuery = "
                INSERT INTO worker_earnings (worker_id, pickup_request_id, base_earnings, total_earnings)
                VALUES (?, ?, ?, ?)
            ";
            $earningsStmt = $this->db->prepare($earningsQuery);
            $earningsStmt->execute([$workerId, $data['pickup_id'], $baseEarnings, $totalEarnings]);

            // Update worker stats
            $statsQuery = "
                UPDATE worker_profiles 
                SET total_pickups = total_pickups + 1 
                WHERE id = ?
            ";
            $statsStmt = $this->db->prepare($statsQuery);
            $statsStmt->execute([$workerId]);

            $this->db->commit();
            $this->jsonResponse(['success' => true, 'message' => 'Pickup completed successfully']);

        } catch (Exception $e) {
            $this->db->rollback();
            $this->jsonResponse(['success' => false, 'message' => 'Error completing pickup']);
        }
    }

    /**
     * Get worker statistics
     */
    private function getWorkerStats($workerId) {
        $query = "
            SELECT 
                COUNT(CASE WHEN DATE(pr.created_at) = CURDATE() THEN 1 END) as today_pickups,
                COUNT(CASE WHEN DATE(pr.created_at) = CURDATE() AND pr.status = 'completed' THEN 1 END) as today_completed,
                COALESCE(SUM(CASE WHEN WEEK(pr.created_at) = WEEK(CURDATE()) THEN we.total_earnings END), 0) as weekly_earnings,
                COUNT(CASE WHEN WEEK(pr.created_at) = WEEK(CURDATE()) THEN 1 END) as weekly_pickups,
                COALESCE(AVG(pr.rating), 0) as average_rating,
                COUNT(pr.rating) as total_ratings,
                COUNT(pr.id) as total_pickups
            FROM worker_profiles wp
            LEFT JOIN pickup_assignments pa ON wp.id = pa.worker_id
            LEFT JOIN pickup_requests pr ON pa.pickup_request_id = pr.id
            LEFT JOIN worker_earnings we ON pa.pickup_request_id = we.pickup_request_id
            WHERE wp.id = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$workerId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get available pickups for worker
     */
    private function getAvailablePickupsData($workerId) {
        // Get worker service areas (simplified)
        $query = "
            SELECT pr.*, u.first_name, u.last_name,
                   ua.address_line_1, ua.district, ua.city,
                   COUNT(pri.id) as waste_types_count
            FROM pickup_requests pr
            JOIN users u ON pr.user_id = u.id
            JOIN user_addresses ua ON pr.address_id = ua.id
            LEFT JOIN pickup_request_items pri ON pr.id = pri.pickup_request_id
            WHERE pr.status = 'confirmed'
            GROUP BY pr.id
            ORDER BY pr.pickup_date ASC, pr.time_slot ASC
            LIMIT 10
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $pickups = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Add calculated fields
        foreach ($pickups as &$pickup) {
            $pickup['distance_km'] = rand(1, 20);
            $pickup['priority'] = $pickup['estimated_weight'] > 50 ? 'high' : 'normal';
            $pickup['estimated_earnings'] = 50 + ($pickup['estimated_weight'] * 3);
            $pickup['waste_types'] = []; // Would be populated with actual waste types
        }

        return $pickups;
    }

    /**
     * Get current pickup for worker
     */
    private function getCurrentPickup($workerId) {
        $query = "
            SELECT pr.*, u.first_name, u.last_name, u.phone as customer_phone,
                   ua.address_line_1, ua.address_line_2, ua.district, ua.city
            FROM pickup_requests pr
            JOIN pickup_assignments pa ON pr.id = pa.pickup_request_id
            JOIN users u ON pr.user_id = u.id
            JOIN user_addresses ua ON pr.address_id = ua.id
            WHERE pa.worker_id = ? AND pr.status = 'in_progress'
            LIMIT 1
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$workerId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get today's schedule for worker
     */
    private function getTodaySchedule($workerId) {
        $query = "
            SELECT pr.*, pa.status as assignment_status
            FROM pickup_requests pr
            JOIN pickup_assignments pa ON pr.id = pa.pickup_request_id
            WHERE pa.worker_id = ? AND DATE(pr.pickup_date) = CURDATE()
            ORDER BY pr.time_slot ASC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$workerId]);
        $schedule = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Add district info
        foreach ($schedule as &$item) {
            $districtQuery = "SELECT district FROM user_addresses WHERE id = ?";
            $districtStmt = $this->db->prepare($districtQuery);
            $districtStmt->execute([$item['address_id']]);
            $district = $districtStmt->fetch();
            $item['district'] = $district['district'] ?? 'Unknown';
        }

        return $schedule;
    }

    /**
     * Get earnings summary for worker
     */
    private function getEarningsSummary($workerId) {
        $query = "
            SELECT 
                COALESCE(SUM(CASE WHEN DATE(we.created_at) = CURDATE() THEN we.total_earnings END), 0) as today,
                COALESCE(SUM(CASE WHEN WEEK(we.created_at) = WEEK(CURDATE()) THEN we.total_earnings END), 0) as week,
                COALESCE(SUM(CASE WHEN MONTH(we.created_at) = MONTH(CURDATE()) THEN we.total_earnings END), 0) as month,
                COALESCE(SUM(CASE WHEN we.payout_status = 'pending' THEN we.total_earnings END), 0) as pending
            FROM worker_earnings we
            WHERE we.worker_id = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$workerId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get worker ID from user
     */
    private function getWorkerId() {
        $stmt = $this->db->prepare("SELECT id FROM worker_profiles WHERE user_id = ?");
        $stmt->execute([$this->user['id']]);
        $result = $stmt->fetch();

        if (!$result) {
            Helpers::setFlashMessage('error', 'Worker profile not found');
            Helpers::redirect('/dashboard');
        }

        return $result['id'];
    }

    /**
     * Require worker role
     */
    private function requireWorkerRole() {
        $stmt = $this->db->prepare("SELECT id FROM worker_profiles WHERE user_id = ?");
        $stmt->execute([$this->user['id']]);
        
        if (!$stmt->fetch()) {
            Helpers::setFlashMessage('error', 'Access denied. Worker account required.');
            Helpers::redirect('/dashboard');
        }
    }
}
