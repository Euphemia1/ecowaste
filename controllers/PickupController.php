<?php
/**
 * Pickup Controller for EcoWaste Application
 */

require_once 'BaseController.php';

class PickupController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->requireAuth();
    }

    /**
     * Display pickup scheduling form
     */
    public function schedule() {
        // Get user addresses
        $addresses = $this->getUserAddresses();
        $wasteCategories = $this->getWasteCategories();

        $data = [
            'title' => 'Schedule Pickup - EcoWaste',
            'addresses' => $addresses,
            'waste_categories' => $wasteCategories,
            'time_slots' => TIME_SLOTS,
            'layout' => 'main'
        ];

        $this->render('pickup/schedule', $data);
    }

    /**
     * Process pickup scheduling
     */
    public function processSchedule() {
        if (!$this->isPost()) {
            Helpers::redirect('/schedule-pickup');
        }

        $this->validateCSRF();

        // Get form data
        $data = $this->getPostData([
            'address_id' => 'int',
            'pickup_date' => 'string',
            'time_slot' => 'string',
            'special_instructions' => 'string',
            'waste_items' => 'string' // JSON string of waste items
        ]);

        // Validate required fields
        $errors = Helpers::validateRequired($data, ['address_id', 'pickup_date', 'time_slot']);

        // Validate pickup date
        $pickupDate = strtotime($data['pickup_date']);
        if (!$pickupDate || $pickupDate < strtotime('+1 day')) {
            $errors['pickup_date'] = 'Pickup date must be at least 1 day in advance';
        }

        // Validate time slot
        if (!array_key_exists($data['time_slot'], TIME_SLOTS)) {
            $errors['time_slot'] = 'Invalid time slot selected';
        }

        // Validate waste items
        $wasteItems = json_decode($data['waste_items'], true);
        if (empty($wasteItems) || !is_array($wasteItems)) {
            $errors['waste_items'] = 'Please select at least one waste type';
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                Helpers::setFlashMessage('error', $error);
            }
            Helpers::redirect('/schedule-pickup');
        }

        try {
            $this->db->beginTransaction();

            // Generate request number
            $requestNumber = Helpers::generateRequestNumber();

            // Calculate estimated weight and fee
            $totalEstimatedWeight = 0;
            foreach ($wasteItems as $item) {
                $totalEstimatedWeight += (float)$item['weight'];
            }

            $pickupFee = $totalEstimatedWeight * 2.50; // $2.50 per kg

            // Create pickup request
            $stmt = $this->db->prepare("
                INSERT INTO pickup_requests (
                    user_id, address_id, request_number, pickup_date, time_slot,
                    special_instructions, estimated_weight, pickup_fee, status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
            ");

            $stmt->execute([
                $this->user['id'],
                $data['address_id'],
                $requestNumber,
                $data['pickup_date'],
                $data['time_slot'],
                $data['special_instructions'] ?: null,
                $totalEstimatedWeight,
                $pickupFee
            ]);

            $pickupRequestId = $this->db->lastInsertId();

            // Add waste items
            foreach ($wasteItems as $item) {
                $stmt = $this->db->prepare("
                    INSERT INTO pickup_request_items (
                        pickup_request_id, waste_category_id, estimated_weight, description
                    ) VALUES (?, ?, ?, ?)
                ");

                $stmt->execute([
                    $pickupRequestId,
                    $item['category_id'],
                    $item['weight'],
                    $item['description'] ?: null
                ]);
            }

            $this->db->commit();

            // Send confirmation email (implement email service)
            $this->sendPickupConfirmationEmail($requestNumber, $data['pickup_date'], $data['time_slot']);

            Helpers::setFlashMessage('success', "Pickup scheduled successfully! Your request number is {$requestNumber}.");
            Helpers::redirect('/pickup-history');

        } catch (PDOException $e) {
            $this->db->rollback();
            error_log("Pickup scheduling error: " . $e->getMessage());
            Helpers::setFlashMessage('error', 'An error occurred while scheduling your pickup. Please try again.');
            Helpers::redirect('/schedule-pickup');
        }
    }

    /**
     * Display pickup history
     */
    public function history() {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = ITEMS_PER_PAGE;
        $offset = ($page - 1) * $limit;

        try {
            // Get total count
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM pickup_requests WHERE user_id = ?");
            $stmt->execute([$this->user['id']]);
            $totalItems = $stmt->fetchColumn();

            // Get pickups
            $stmt = $this->db->prepare("
                SELECT pr.*, ua.address_line_1, ua.city, ua.state
                FROM pickup_requests pr
                JOIN user_addresses ua ON pr.address_id = ua.id
                WHERE pr.user_id = ?
                ORDER BY pr.created_at DESC
                LIMIT ? OFFSET ?
            ");
            $stmt->execute([$this->user['id'], $limit, $offset]);
            $pickups = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $pagination = Helpers::paginate($page, $totalItems, $limit);

            $data = [
                'title' => 'Pickup History - EcoWaste',
                'pickups' => $pickups,
                'pagination' => $pagination,
                'layout' => 'main'
            ];

            $this->render('pickup/history', $data);

        } catch (PDOException $e) {
            error_log("Error fetching pickup history: " . $e->getMessage());
            Helpers::setFlashMessage('error', 'Unable to load pickup history.');
            Helpers::redirect('/dashboard');
        }
    }

    /**
     * Display pickup details
     */
    public function details() {
        $id = (int)($_GET['id'] ?? 0);

        if (!$id) {
            Helpers::setFlashMessage('error', 'Invalid pickup request.');
            Helpers::redirect('/pickup-history');
        }

        try {
            // Get pickup details
            $stmt = $this->db->prepare("
                SELECT pr.*, ua.*
                FROM pickup_requests pr
                JOIN user_addresses ua ON pr.address_id = ua.id
                WHERE pr.id = ? AND pr.user_id = ?
            ");
            $stmt->execute([$id, $this->user['id']]);
            $pickup = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$pickup) {
                Helpers::setFlashMessage('error', 'Pickup request not found.');
                Helpers::redirect('/pickup-history');
            }

            // Get waste items
            $stmt = $this->db->prepare("
                SELECT pri.*, wc.name as category_name, wc.slug as category_slug
                FROM pickup_request_items pri
                JOIN waste_categories wc ON pri.waste_category_id = wc.id
                WHERE pri.pickup_request_id = ?
                ORDER BY wc.name
            ");
            $stmt->execute([$id]);
            $wasteItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $data = [
                'title' => 'Pickup Details - EcoWaste',
                'pickup' => $pickup,
                'waste_items' => $wasteItems,
                'time_slots' => TIME_SLOTS,
                'layout' => 'main'
            ];

            $this->render('pickup/details', $data);

        } catch (PDOException $e) {
            error_log("Error fetching pickup details: " . $e->getMessage());
            Helpers::setFlashMessage('error', 'Unable to load pickup details.');
            Helpers::redirect('/pickup-history');
        }
    }

    /**
     * Cancel pickup request
     */
    public function cancel() {
        if (!$this->isPost()) {
            Helpers::redirect('/pickup-history');
        }

        $this->validateCSRF();

        $id = (int)($_POST['pickup_id'] ?? 0);

        if (!$id) {
            $this->json(['error' => 'Invalid pickup request'], 400);
        }

        try {
            // Check if pickup can be cancelled
            $stmt = $this->db->prepare("
                SELECT id, status, pickup_date 
                FROM pickup_requests 
                WHERE id = ? AND user_id = ?
            ");
            $stmt->execute([$id, $this->user['id']]);
            $pickup = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$pickup) {
                $this->json(['error' => 'Pickup request not found'], 404);
            }

            if ($pickup['status'] !== 'pending') {
                $this->json(['error' => 'Cannot cancel pickup request in current status'], 400);
            }

            // Check if pickup date is more than 24 hours away
            $pickupTime = strtotime($pickup['pickup_date']);
            if ($pickupTime < strtotime('+1 day')) {
                $this->json(['error' => 'Cannot cancel pickup within 24 hours of scheduled date'], 400);
            }

            // Cancel the pickup
            $stmt = $this->db->prepare("
                UPDATE pickup_requests 
                SET status = 'cancelled', updated_at = NOW() 
                WHERE id = ?
            ");
            $stmt->execute([$id]);

            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Pickup cancelled successfully']);
            } else {
                Helpers::setFlashMessage('success', 'Pickup cancelled successfully.');
                Helpers::redirect('/pickup-history');
            }

        } catch (PDOException $e) {
            error_log("Error cancelling pickup: " . $e->getMessage());
            
            if ($this->isAjax()) {
                $this->json(['error' => 'An error occurred while cancelling pickup'], 500);
            } else {
                Helpers::setFlashMessage('error', 'Unable to cancel pickup. Please try again.');
                Helpers::redirect('/pickup-history');
            }
        }
    }

    /**
     * Get user addresses
     */
    private function getUserAddresses() {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM user_addresses 
                WHERE user_id = ? 
                ORDER BY is_default DESC, created_at ASC
            ");
            $stmt->execute([$this->user['id']]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching user addresses: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get waste categories
     */
    private function getWasteCategories() {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM waste_categories 
                WHERE is_active = 1 
                ORDER BY name ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching waste categories: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Send pickup confirmation email
     */
    private function sendPickupConfirmationEmail($requestNumber, $pickupDate, $timeSlot) {
        // Implement email sending logic
        $timeSlotLabel = TIME_SLOTS[$timeSlot] ?? $timeSlot;
        $confirmationDetails = [
            'request_number' => $requestNumber,
            'pickup_date' => Helpers::formatDate($pickupDate),
            'time_slot' => $timeSlotLabel,
            'user_name' => $this->user['first_name']
        ];
        
        error_log("Pickup confirmation email for {$this->user['email']}: " . json_encode($confirmationDetails));
    }
}
?>