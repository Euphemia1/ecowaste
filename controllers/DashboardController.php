<?php
/**
 * Dashboard Controller for EcoWaste Application
 */

require_once 'BaseController.php';

class DashboardController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->requireAuth();
    }

    /**
     * Display dashboard
     */
    public function index() {
        // Get user's recent activity
        $recentPickups = $this->getRecentPickups();
        $impactStats = $this->getUserImpactStats();
        $upcomingPickups = $this->getUpcomingPickups();
        $monthlyProgress = $this->getMonthlyProgress();

        $data = [
            'title' => 'Dashboard - EcoWaste',
            'recent_pickups' => $recentPickups,
            'impact_stats' => $impactStats,
            'upcoming_pickups' => $upcomingPickups,
            'monthly_progress' => $monthlyProgress,
            'layout' => 'main'
        ];

        $this->render('dashboard/index', $data);
    }

    /**
     * Get recent pickups for the user
     */
    private function getRecentPickups() {
        try {
            $stmt = $this->db->prepare("
                SELECT pr.*, ua.address_line_1, ua.city, ua.state
                FROM pickup_requests pr
                JOIN user_addresses ua ON pr.address_id = ua.id
                WHERE pr.user_id = ?
                ORDER BY pr.created_at DESC
                LIMIT 5
            ");
            $stmt->execute([$this->user['id']]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching recent pickups: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get user's environmental impact statistics
     */
    private function getUserImpactStats() {
        try {
            // Get current month stats
            $stmt = $this->db->prepare("
                SELECT 
                    COALESCE(SUM(total_recycled_weight), 0) as total_weight,
                    COALESCE(SUM(co2_saved), 0) as co2_saved,
                    COALESCE(SUM(trees_saved), 0) as trees_saved,
                    COALESCE(SUM(water_saved), 0) as water_saved
                FROM user_environmental_impact
                WHERE user_id = ?
            ");
            $stmt->execute([$this->user['id']]);
            $totalStats = $stmt->fetch(PDO::FETCH_ASSOC);

            // Get current month stats
            $stmt = $this->db->prepare("
                SELECT 
                    COALESCE(total_recycled_weight, 0) as month_weight,
                    COALESCE(co2_saved, 0) as month_co2_saved,
                    COALESCE(trees_saved, 0) as month_trees_saved,
                    COALESCE(water_saved, 0) as month_water_saved,
                    COALESCE(recycling_rate, 0) as recycling_rate
                FROM user_environmental_impact
                WHERE user_id = ? AND month = ? AND year = ?
            ");
            $stmt->execute([$this->user['id'], date('n'), date('Y')]);
            $monthStats = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$monthStats) {
                $monthStats = [
                    'month_weight' => 0,
                    'month_co2_saved' => 0,
                    'month_trees_saved' => 0,
                    'month_water_saved' => 0,
                    'recycling_rate' => 0
                ];
            }

            return array_merge($totalStats ?: [], $monthStats);
        } catch (PDOException $e) {
            error_log("Error fetching impact stats: " . $e->getMessage());
            return [
                'total_weight' => 0,
                'co2_saved' => 0,
                'trees_saved' => 0,
                'water_saved' => 0,
                'month_weight' => 0,
                'month_co2_saved' => 0,
                'month_trees_saved' => 0,
                'month_water_saved' => 0,
                'recycling_rate' => 0
            ];
        }
    }

    /**
     * Get upcoming pickups
     */
    private function getUpcomingPickups() {
        try {
            $stmt = $this->db->prepare("
                SELECT pr.*, ua.address_line_1, ua.city, ua.state
                FROM pickup_requests pr
                JOIN user_addresses ua ON pr.address_id = ua.id
                WHERE pr.user_id = ? AND pr.pickup_date >= CURDATE() AND pr.status IN ('pending', 'confirmed')
                ORDER BY pr.pickup_date ASC, pr.time_slot ASC
                LIMIT 3
            ");
            $stmt->execute([$this->user['id']]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching upcoming pickups: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get monthly progress data for chart
     */
    private function getMonthlyProgress() {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    month,
                    year,
                    total_recycled_weight,
                    co2_saved
                FROM user_environmental_impact
                WHERE user_id = ? AND year >= ?
                ORDER BY year ASC, month ASC
                LIMIT 12
            ");
            $stmt->execute([$this->user['id'], date('Y') - 1]);
            
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Format for chart
            $chartData = [];
            foreach ($data as $row) {
                $chartData[] = [
                    'month' => date('M Y', mktime(0, 0, 0, $row['month'], 1, $row['year'])),
                    'weight' => (float)$row['total_recycled_weight'],
                    'co2_saved' => (float)$row['co2_saved']
                ];
            }
            
            return $chartData;
        } catch (PDOException $e) {
            error_log("Error fetching monthly progress: " . $e->getMessage());
            return [];
        }
    }
}
?>