<?php
/**
 * Home Controller for EcoWaste Application
 */

require_once 'BaseController.php';

class HomeController extends BaseController {

    /**
     * Display home page
     */
    public function index() {
        // Get some statistics for the homepage
        $stats = $this->getHomePageStats();
        
        // Get featured recycling guides
        $featuredGuides = $this->getFeaturedGuides();
        
        $data = [
            'title' => 'Sustainable Waste Management Platform',
            'stats' => $stats,
            'featured_guides' => $featuredGuides,
            'layout' => 'main'
        ];
        
        $this->render('home/index', $data);
    }

    /**
     * Get statistics for home page
     */
    private function getHomePageStats() {
        $stats = [
            'total_users' => 0,
            'total_waste_recycled' => 0,
            'co2_saved' => 0,
            'trees_saved' => 0
        ];

        try {
            // Total active users
            $stmt = $this->db->query("SELECT COUNT(*) FROM users WHERE status = 'active'");
            $stats['total_users'] = $stmt->fetchColumn();

            // Total waste recycled (from completed pickups)
            $stmt = $this->db->query("
                SELECT SUM(total_weight) 
                FROM pickup_requests 
                WHERE status = 'completed' AND total_weight > 0
            ");
            $stats['total_waste_recycled'] = $stmt->fetchColumn() ?: 0;

            // Total environmental impact
            $stmt = $this->db->query("
                SELECT 
                    SUM(co2_saved) as total_co2_saved,
                    SUM(trees_saved) as total_trees_saved,
                    SUM(water_saved) as total_water_saved
                FROM user_environmental_impact
            ");
            $impact = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($impact) {
                $stats['co2_saved'] = $impact['total_co2_saved'] ?: 0;
                $stats['trees_saved'] = $impact['total_trees_saved'] ?: 0;
                $stats['water_saved'] = $impact['total_water_saved'] ?: 0;
            }

        } catch (PDOException $e) {
            // Log error but don't break the page
            error_log("Error fetching homepage stats: " . $e->getMessage());
        }

        return $stats;
    }

    /**
     * Get featured recycling guides
     */
    private function getFeaturedGuides() {
        try {
            $stmt = $this->db->prepare("
                SELECT id, title, slug, category, content, image_url
                FROM recycling_guides 
                WHERE is_featured = 1 
                ORDER BY created_at DESC 
                LIMIT 3
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching featured guides: " . $e->getMessage());
            return [];
        }
    }
}
?>