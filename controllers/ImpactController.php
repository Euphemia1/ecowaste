<?php
/**
 * Impact Controller for EcoWaste Application
 */

require_once 'BaseController.php';

class ImpactController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->requireAuth();
    }

    /**
     * Display user impact dashboard
     */
    public function index() {
        $period = $_GET['period'] ?? 'month';
        $userId = $this->user['id'];

        // Get impact data based on period
        $impact_data = $this->getImpactData($userId, $period);
        $monthly_data = $this->getMonthlyChartData($userId);
        $composition_data = $this->getWasteComposition($userId);
        $achievements = $this->getUserAchievements($userId);
        $community_stats = $this->getCommunityComparison($userId);

        $data = [
            'title' => 'Environmental Impact - EcoWaste',
            'impact_data' => $impact_data,
            'monthly_data' => $monthly_data,
            'composition_data' => $composition_data,
            'achievements' => $achievements,
            'community_stats' => $community_stats,
            'layout' => 'main'
        ];

        $this->render('impact/index', $data);
    }

    /**
     * Get user impact data for specified period
     */
    private function getImpactData($userId, $period) {
        $dateCondition = $this->getDateCondition($period);
        
        $query = "
            SELECT 
                COALESCE(SUM(pri.total_weight), 0) as total_weight,
                COALESCE(SUM(pri.total_weight * 0.8), 0) as co2_saved,
                COALESCE(SUM(pri.total_weight * 0.017), 0) as trees_saved,
                COALESCE(SUM(pri.total_weight * 100), 0) as water_saved,
                COALESCE(SUM(pri.total_weight * 2.5), 0) as energy_saved,
                COALESCE(SUM(pri.total_weight * 0.001), 0) as landfill_saved,
                CASE 
                    WHEN COALESCE(SUM(pri.total_weight), 0) > 0 THEN 
                        ROUND((COALESCE(SUM(pri.total_weight), 0) / (COALESCE(SUM(pri.total_weight), 0) + 50)) * 100, 0)
                    ELSE 0 
                END as recycling_rate
            FROM pickup_requests pri 
            WHERE pri.user_id = ? AND pri.status = 'completed' AND $dateCondition
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get month-specific data for comparison
        $monthQuery = "
            SELECT 
                COALESCE(SUM(total_weight), 0) as month_weight,
                COALESCE(SUM(total_weight * 0.8), 0) as month_co2_saved,
                COALESCE(SUM(total_weight * 0.017), 0) as month_trees_saved
            FROM pickup_requests 
            WHERE user_id = ? AND status = 'completed' AND MONTH(created_at) = MONTH(CURRENT_DATE) AND YEAR(created_at) = YEAR(CURRENT_DATE)
        ";

        $monthStmt = $this->db->prepare($monthQuery);
        $monthStmt->execute([$userId]);
        $monthData = $monthStmt->fetch(PDO::FETCH_ASSOC);

        return array_merge($data, $monthData);
    }

    /**
     * Get monthly chart data for the past 6 months
     */
    private function getMonthlyChartData($userId) {
        $query = "
            SELECT 
                DATE_FORMAT(created_at, '%b %Y') as label,
                MONTH(created_at) as month,
                YEAR(created_at) as year,
                COALESCE(SUM(total_weight), 0) as weight
            FROM pickup_requests 
            WHERE user_id = ? AND status = 'completed' 
                AND created_at >= DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH)
            GROUP BY YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b %Y')
            ORDER BY YEAR(created_at), MONTH(created_at)
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $labels = [];
        $weights = [];

        foreach ($results as $row) {
            $labels[] = $row['label'];
            $weights[] = (float) $row['weight'];
        }

        return [
            'labels' => $labels,
            'weights' => $weights
        ];
    }

    /**
     * Get waste composition data
     */
    private function getWasteComposition($userId) {
        $query = "
            SELECT 
                wc.name,
                COALESCE(SUM(pri.actual_weight), 0) as total_weight
            FROM pickup_request_items pri
            JOIN waste_categories wc ON pri.waste_category_id = wc.id
            JOIN pickup_requests pr ON pri.pickup_request_id = pr.id
            WHERE pr.user_id = ? AND pr.status = 'completed'
            GROUP BY wc.id, wc.name
            HAVING total_weight > 0
            ORDER BY total_weight DESC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $composition = [];
        foreach ($results as $row) {
            $composition[$row['name']] = (float) $row['total_weight'];
        }

        return $composition;
    }

    /**
     * Get user achievements
     */
    private function getUserAchievements($userId) {
        $achievements = [
            [
                'id' => 'first_pickup',
                'title' => 'First Pickup',
                'description' => 'Completed your first pickup',
                'icon' => 'recycle',
                'unlocked' => false
            ],
            [
                'id' => 'eco_warrior',
                'title' => 'Eco Warrior',
                'description' => 'Recycled 100kg total',
                'icon' => 'leaf',
                'unlocked' => false
            ],
            [
                'id' => 'tree_saver',
                'title' => 'Tree Saver',
                'description' => 'Saved the equivalent of 10 trees',
                'icon' => 'tree',
                'unlocked' => false
            ],
            [
                'id' => 'regular_recycler',
                'title' => 'Regular Recycler',
                'description' => '10 completed pickups',
                'icon' => 'calendar-check',
                'unlocked' => false
            ],
            [
                'id' => 'carbon_hero',
                'title' => 'Carbon Hero',
                'description' => 'Reduced 50kg CO2',
                'icon' => 'cloud',
                'unlocked' => false
            ],
            [
                'id' => 'waste_master',
                'title' => 'Waste Master',
                'description' => 'Recycled 5 different waste types',
                'icon' => 'award',
                'unlocked' => false
            ]
        ];

        // Check user stats against achievements
        $statsQuery = "
            SELECT 
                COUNT(*) as total_pickups,
                COALESCE(SUM(total_weight), 0) as total_weight,
                COALESCE(SUM(total_weight * 0.8), 0) as co2_saved,
                COALESCE(SUM(total_weight * 0.017), 0) as trees_saved,
                COUNT(DISTINCT pri.waste_category_id) as waste_types
            FROM pickup_requests pr
            LEFT JOIN pickup_request_items pri ON pr.id = pri.pickup_request_id
            WHERE pr.user_id = ? AND pr.status = 'completed'
        ";

        $stmt = $this->db->prepare($statsQuery);
        $stmt->execute([$userId]);
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);

        // Update achievement status
        foreach ($achievements as &$achievement) {
            switch ($achievement['id']) {
                case 'first_pickup':
                    $achievement['unlocked'] = $stats['total_pickups'] >= 1;
                    break;
                case 'eco_warrior':
                    $achievement['unlocked'] = $stats['total_weight'] >= 100;
                    break;
                case 'tree_saver':
                    $achievement['unlocked'] = $stats['trees_saved'] >= 10;
                    break;
                case 'regular_recycler':
                    $achievement['unlocked'] = $stats['total_pickups'] >= 10;
                    break;
                case 'carbon_hero':
                    $achievement['unlocked'] = $stats['co2_saved'] >= 50;
                    break;
                case 'waste_master':
                    $achievement['unlocked'] = $stats['waste_types'] >= 5;
                    break;
            }
        }

        return $achievements;
    }

    /**
     * Get community comparison stats
     */
    private function getCommunityComparison($userId) {
        // Get user stats
        $userStatsQuery = "
            SELECT 
                COALESCE(SUM(total_weight), 0) as user_total,
                COALESCE(AVG(total_weight), 0) as user_monthly_avg
            FROM pickup_requests 
            WHERE user_id = ? AND status = 'completed'
        ";

        $stmt = $this->db->prepare($userStatsQuery);
        $stmt->execute([$userId]);
        $userStats = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get community stats
        $communityStatsQuery = "
            SELECT 
                COUNT(DISTINCT user_id) as total_users,
                COALESCE(AVG(total_weight), 0) as community_monthly_avg,
                COALESCE(MAX(total_weight), 0) as top_performer
            FROM (
                SELECT 
                    user_id,
                    COALESCE(SUM(total_weight), 0) as total_weight
                FROM pickup_requests 
                WHERE status = 'completed' 
                    AND MONTH(created_at) = MONTH(CURRENT_DATE) 
                    AND YEAR(created_at) = YEAR(CURRENT_DATE)
                GROUP BY user_id
            ) monthly_stats
        ";

        $stmt = $this->db->prepare($communityStatsQuery);
        $stmt->execute();
        $communityStats = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get user ranking
        $rankingQuery = "
            SELECT 
                COUNT(*) + 1 as user_rank
            FROM (
                SELECT 
                    user_id,
                    COALESCE(SUM(total_weight), 0) as total_weight
                FROM pickup_requests 
                WHERE status = 'completed'
                GROUP BY user_id
                HAVING total_weight > ?
            ) ranked_users
        ";

        $stmt = $this->db->prepare($rankingQuery);
        $stmt->execute([$userStats['user_total']]);
        $ranking = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'user_rank' => $ranking['user_rank'],
            'total_users' => $communityStats['total_users'],
            'user_monthly_avg' => $userStats['user_monthly_avg'],
            'community_monthly_avg' => $communityStats['community_monthly_avg'],
            'top_performer' => $communityStats['top_performer']
        ];
    }

    /**
     * Get date condition based on period
     */
    private function getDateCondition($period) {
        switch ($period) {
            case 'month':
                return "MONTH(created_at) = MONTH(CURRENT_DATE) AND YEAR(created_at) = YEAR(CURRENT_DATE)";
            case 'quarter':
                return "QUARTER(created_at) = QUARTER(CURRENT_DATE) AND YEAR(created_at) = YEAR(CURRENT_DATE)";
            case 'year':
                return "YEAR(created_at) = YEAR(CURRENT_DATE)";
            case 'all':
            default:
                return "1=1";
        }
    }
}
