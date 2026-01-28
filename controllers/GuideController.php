<?php
/**
 * Guide Controller for EcoWaste Application
 */

require_once 'BaseController.php';

class GuideController extends BaseController {

    /**
     * Display main guide page
     */
    public function index() {
        $data = [
            'title' => 'Recycling Guide',
            'layout' => 'main'
        ];

        // Fetch categories
        $data['categories'] = $this->getCategories();
        
        // Fetch featured/recent guides
        $data['recent_guides'] = $this->getRecentGuides();

        $this->render('guide/index', $data);
    }

    /**
     * Display category page
     */
    public function category() {
        $slug = $this->getGetData(['slug'])['slug'] ?? '';
        
        if (!$slug) {
            Helpers::redirect('/recycling-guide');
        }

        $category = $this->getCategoryBySlug($slug);
        
        if (!$category) {
            Helpers::redirect('/recycling-guide'); // Or 404
        }

        $data = [
            'title' => $category . ' Recycling',
            'category' => $category,
            'guides' => $this->getGuidesByCategory($category),
            'layout' => 'main'
        ];

        $this->render('guide/category', $data);
    }

    /**
     * Display specific article
     */
    public function article() {
        $slug = $this->getGetData(['slug'])['slug'] ?? '';
        
        if (!$slug) {
            Helpers::redirect('/recycling-guide');
        }

        $guide = $this->getGuideBySlug($slug);
        
        if (!$guide) {
            // Handle 404
            Helpers::redirect('/recycling-guide');
        }

        // Increment view count
        $this->incrementViews($guide['id']);

        $data = [
            'title' => $guide['title'],
            'guide' => $guide,
            'related_guides' => $this->getRelatedGuides($guide['category'], $guide['id']),
            'layout' => 'main'
        ];

        $this->render('guide/article', $data);
    }

    // Helper methods

    private function getCategories() {
        // Since categories are just strings in the schema currently, we can fetch distinct categories
        if (!$this->db) return [];
        try {
            $stmt = $this->db->query("SELECT DISTINCT category FROM recycling_guides ORDER BY category");
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("Error fetching categories: " . $e->getMessage());
            return [];
        }
    }

    private function getRecentGuides() {
        if (!$this->db) return [];
        try {
            $stmt = $this->db->query("SELECT * FROM recycling_guides ORDER BY created_at DESC LIMIT 6");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching recent guides: " . $e->getMessage());
            return [];
        }
    }

    private function getCategoryBySlug($slug) {
        // This is a bit tricky if slug is not 1:1 with category name. 
        // For MVP assuming category param is the category name itself for now or we map it.
        // Let's decode the slug back to name if possible or just use LIKE.
        // Actually, the route uses ?category=Paper probably.
        // The router passes 'slug' if query param.
        return ucfirst(str_replace('-', ' ', $slug)); 
    }

    private function getGuidesByCategory($category) {
        if (!$this->db) return [];
        try {
            $stmt = $this->db->prepare("SELECT * FROM recycling_guides WHERE category = ? ORDER BY title");
            $stmt->execute([$category]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching guides by category: " . $e->getMessage());
            return [];
        }
    }

    private function getGuideBySlug($slug) {
        if (!$this->db) return null;
        try {
            $stmt = $this->db->prepare("SELECT * FROM recycling_guides WHERE slug = ?");
            $stmt->execute([$slug]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching guide: " . $e->getMessage());
            return null;
        }
    }

    private function incrementViews($id) {
        if (!$this->db) return;
        try {
            $stmt = $this->db->prepare("UPDATE recycling_guides SET views_count = views_count + 1 WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            // Ignore error
        }
    }

    private function getRelatedGuides($category, $excludeId) {
        if (!$this->db) return [];
        try {
            $stmt = $this->db->prepare("SELECT id, title, slug, image_url FROM recycling_guides WHERE category = ? AND id != ? LIMIT 3");
            $stmt->execute([$category, $excludeId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>
