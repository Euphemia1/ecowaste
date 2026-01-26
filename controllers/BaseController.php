<?php
/**
 * Base Controller for EcoWaste Application
 */

require_once '../config/database.php';
require_once '../includes/Security.php';
require_once '../includes/Helpers.php';

class BaseController {
    protected $db;
    protected $user = null;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->loadUser();
    }

    /**
     * Load current user from session
     */
    protected function loadUser() {
        if ($this->db && Security::isAuthenticated()) {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ? AND status = 'active'");
            $stmt->execute([$_SESSION['user_id']]);
            $this->user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$this->user) {
                // User not found or inactive, logout
                $this->logout();
            }
        }
    }

    /**
     * Require authentication
     */
    protected function requireAuth() {
        if (!$this->user) {
            Helpers::setFlashMessage('error', 'Please login to access this page.');
            Helpers::redirect('/login');
        }
    }

    /**
     * Logout user
     */
    protected function logout() {
        session_unset();
        session_destroy();
        Helpers::redirect('/login');
    }

    /**
     * Render view
     */
    protected function render($view, $data = []) {
        $data['user'] = $this->user;
        $data['flash_messages'] = Helpers::getFlashMessages();
        $data['csrf_token'] = Security::generateCSRFToken();
        
        // Extract variables for use in view
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        $viewFile = '../views/' . $view . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new Exception("View file not found: " . $viewFile);
        }
        
        // Get the content
        $content = ob_get_clean();
        
        // Include layout if specified
        if (isset($data['layout']) && $data['layout']) {
            $layoutFile = '../views/layouts/' . $data['layout'] . '.php';
            if (file_exists($layoutFile)) {
                include $layoutFile;
            } else {
                echo $content;
            }
        } else {
            echo $content;
        }
    }

    /**
     * Render JSON response
     */
    protected function json($data, $status_code = 200) {
        Helpers::jsonResponse($data, $status_code);
    }

    /**
     * Validate CSRF token
     */
    protected function validateCSRF() {
        $token = $_POST['csrf_token'] ?? '';
        if (!Security::verifyCSRFToken($token)) {
            $this->json(['error' => 'Invalid CSRF token'], 400);
        }
    }

    /**
     * Get POST data with sanitization
     */
    protected function getPostData($fields) {
        $data = [];
        foreach ($fields as $field => $type) {
            if (is_numeric($field)) {
                $field = $type;
                $type = 'string';
            }
            $data[$field] = Security::sanitizeInput($_POST[$field] ?? '', $type);
        }
        return $data;
    }

    /**
     * Get GET data with sanitization
     */
    protected function getGetData($fields) {
        $data = [];
        foreach ($fields as $field => $type) {
            if (is_numeric($field)) {
                $field = $type;
                $type = 'string';
            }
            $data[$field] = Security::sanitizeInput($_GET[$field] ?? '', $type);
        }
        return $data;
    }

    /**
     * Check if request is POST
     */
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Check if request is AJAX
     */
    protected function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Redirect with flash message
     */
    protected function redirectWithMessage($url, $type, $message) {
        Helpers::setFlashMessage($type, $message);
        Helpers::redirect($url);
    }

    /**
     * Calculate environmental impact
     */
    protected function calculateEnvironmentalImpact($weightKg) {
        return Helpers::calculateImpact($weightKg);
    }

    /**
     * Update user environmental impact
     */
    protected function updateUserImpact($userId, $weightKg, $month = null, $year = null) {
        if (!$this->db) return false;
        
        if (!$month) $month = date('n');
        if (!$year) $year = date('Y');
        
        $impact = $this->calculateEnvironmentalImpact($weightKg);
        
        $stmt = $this->db->prepare("
            INSERT INTO user_environmental_impact 
            (user_id, month, year, total_recycled_weight, co2_saved, trees_saved, water_saved)
            VALUES (?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            total_recycled_weight = total_recycled_weight + VALUES(total_recycled_weight),
            co2_saved = co2_saved + VALUES(co2_saved),
            trees_saved = trees_saved + VALUES(trees_saved),
            water_saved = water_saved + VALUES(water_saved)
        ");
        
        return $stmt->execute([
            $userId,
            $month,
            $year,
            $weightKg,
            $impact['co2_saved'],
            $impact['trees_saved'],
            $impact['water_saved']
        ]);
    }
}
?>