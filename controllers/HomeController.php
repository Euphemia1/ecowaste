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
            'trees_saved' => 0,
            'water_saved' => 0,
            'green_jobs' => 0,
            'waste_to_wealth' => 0,
            'carbon_credits' => 0,
            'farmers_supported' => 0
        ];

        if (!$this->db) return $stats;

        try {
            // Total active users
            $stmt = $this->db->query("SELECT COUNT(*) FROM users WHERE status = 'active'");
            if ($stmt) {
                $stats['total_users'] = $stmt->fetchColumn();
            }

            // Total waste recycled (from completed pickups)
            $stmt = $this->db->query("
                SELECT SUM(total_weight) 
                FROM pickup_requests 
                WHERE status = 'completed' AND total_weight > 0
            ");
            if ($stmt) {
                $stats['total_waste_recycled'] = $stmt->fetchColumn() ?: 0;
            }

            // Total environmental impact
            $stmt = $this->db->query("
                SELECT 
                    SUM(co2_saved) as total_co2_saved,
                    SUM(trees_saved) as total_trees_saved,
                    SUM(water_saved) as total_water_saved
                FROM user_environmental_impact
            ");
            if ($stmt) {
                $impact = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($impact) {
                    $stats['co2_saved'] = $impact['total_co2_saved'] ?: 0;
                    $stats['trees_saved'] = $impact['total_trees_saved'] ?: 0;
                    $stats['water_saved'] = $impact['total_water_saved'] ?: 0;
                    
                    // Map to keys used in the view
                    $stats['carbon_credits'] = $stats['co2_saved'] / 1000; // Convert kg to tons
                }

                // Estimated/Calculated stats for the challenge
                $stats['green_jobs'] = floor($stats['total_users'] / 5) + 3; // Example calculation
                $stats['waste_to_wealth'] = $stats['total_waste_recycled'] * 2.5; // ZMW 2.50 per kg
                $stats['farmers_supported'] = floor($stats['total_waste_recycled'] / 50); // 1 farmer per 50kg compost
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
        if (!$this->db) return [];
        
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

    /**
     * Display about page
     */
    public function about() {
        $data = [
            'title' => 'About EcoWaste - Our Mission and Team',
            'layout' => 'main'
        ];
        $this->render('about/index', $data);
    }

    /**
     * Display pricing page
     */
    public function pricing() {
        $data = [
            'title' => 'Transparent Pricing for a Cleaner Zambia',
            'layout' => 'main'
        ];
        $this->render('pricing/index', $data);
    }

    /**
     * Display pilot plan page
     */
    public function pilotPlan() {
        $data = [
            'title' => 'Pilot Implementation Plan - Lusaka 2026',
            'layout' => 'main'
        ];
        $this->render('pilot-plan/index', $data);
    }

    /**
     * Display food waste program page
     */
    public function foodWaste() {
        $data = [
            'title' => 'Food Waste Recycling Program',
            'layout' => 'main'
        ];
        $this->render('programs/food-waste', $data);
    }

    /**
     * Display partnerships page
     */
    public function partnerships() {
        $data = [
            'title' => 'Our Partnerships - Building a Circular Economy',
            'layout' => 'main'
        ];
        $this->render('partnerships/index', $data);
    }

    /**
     * Display FAQ page
     */
    public function faq() {
        $data = [
            'title' => 'Frequently Asked Questions',
            'layout' => 'main'
        ];
        $this->render('faq/index', $data);
    }

    /**
     * Display general contact page
     */
    public function contact() {
        $data = [
            'title' => 'Contact Us',
            'layout' => 'main'
        ];
        $this->render('contact/index', $data);
    }

    /**
     * Display commercial partnership inquiry page
     */
    public function commercialInquiry() {
        $data = [
            'title' => 'Commercial Partnership Inquiry',
            'layout' => 'main'
        ];
        $this->render('contact/commercial', $data);
    }
}
?>