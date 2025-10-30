<?php


class Helpers {
    

    public static function redirect($url, $permanent = false) {
        if ($permanent) {
            header('HTTP/1.1 301 Moved Permanently');
        }
        header('Location: ' . $url);
        exit();
    }

   
    public static function formatDate($date, $format = 'M j, Y') {
        if ($date instanceof DateTime) {
            return $date->format($format);
        }
        return date($format, strtotime($date));
    }


    public static function timeAgo($datetime) {
        $time = time() - strtotime($datetime);
        
        if ($time < 60) return 'just now';
        if ($time < 3600) return floor($time/60) . ' minutes ago';
        if ($time < 86400) return floor($time/3600) . ' hours ago';
        if ($time < 2592000) return floor($time/86400) . ' days ago';
        if ($time < 31536000) return floor($time/2592000) . ' months ago';
        
        return floor($time/31536000) . ' years ago';
    }

    /**
     * Format file size
     */
    public static function formatFileSize($bytes) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Format weight for display
     */
    public static function formatWeight($kg) {
        if ($kg >= 1000) {
            return number_format($kg / 1000, 2) . ' tons';
        }
        return number_format($kg, 2) . ' kg';
    }

    /**
     * Generate slug from string
     */
    public static function createSlug($string) {
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
        $string = preg_replace('/[\s-]+/', '-', $string);
        return trim($string, '-');
    }

    /**
     * Truncate text
     */
    public static function truncateText($text, $length = 100, $suffix = '...') {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . $suffix;
    }

    /**
     * Calculate environmental impact
     */
    public static function calculateImpact($weightKg) {
        return [
            'co2_saved' => $weightKg * CO2_REDUCTION_PER_KG,
            'trees_saved' => ($weightKg / 1000) * TREES_SAVED_PER_TON,
            'water_saved' => $weightKg * WATER_SAVED_PER_KG
        ];
    }

    /**
     * Generate pagination links
     */
    public static function paginate($currentPage, $totalItems, $itemsPerPage = ITEMS_PER_PAGE) {
        $totalPages = ceil($totalItems / $itemsPerPage);
        $pagination = [];
        
        $pagination['current_page'] = $currentPage;
        $pagination['total_pages'] = $totalPages;
        $pagination['total_items'] = $totalItems;
        $pagination['items_per_page'] = $itemsPerPage;
        $pagination['has_previous'] = $currentPage > 1;
        $pagination['has_next'] = $currentPage < $totalPages;
        $pagination['previous_page'] = $currentPage - 1;
        $pagination['next_page'] = $currentPage + 1;
        
        // Generate page links
        $pagination['links'] = [];
        $start = max(1, $currentPage - 2);
        $end = min($totalPages, $currentPage + 2);
        
        for ($i = $start; $i <= $end; $i++) {
            $pagination['links'][] = [
                'page' => $i,
                'is_current' => $i === $currentPage
            ];
        }
        
        return $pagination;
    }

    /**
     * Flash message system
     */
    public static function setFlashMessage($type, $message) {
        $_SESSION['flash_messages'][] = [
            'type' => $type,
            'message' => $message
        ];
    }

    /**
     * Get flash messages
     */
    public static function getFlashMessages() {
        $messages = $_SESSION['flash_messages'] ?? [];
        unset($_SESSION['flash_messages']);
        return $messages;
    }

    /**
     * Validate required fields
     */
    public static function validateRequired($data, $required_fields) {
        $errors = [];
        
        foreach ($required_fields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' is required';
            }
        }
        
        return $errors;
    }

    /**
     * Generate request number
     */
    public static function generateRequestNumber($prefix = 'ECO') {
        return $prefix . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

    /**
     * Format currency
     */
    public static function formatCurrency($amount, $currency = 'USD') {
        return '$' . number_format($amount, 2);
    }

    /**
     * Check if current route matches
     */
    public static function isCurrentRoute($route) {
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $currentPath = str_replace('/public', '', $currentPath);
        return $currentPath === $route;
    }

    /**
     * Get current URL
     */
    public static function getCurrentUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    /**
     * Debug helper
     */
    public static function debug($data, $die = false) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        if ($die) {
            die();
        }
    }

    /**
     * Send JSON response
     */
    public static function jsonResponse($data, $status_code = 200) {
        http_response_code($status_code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    /**
     * Validate phone number
     */
    public static function validatePhone($phone) {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        return strlen($phone) >= 10;
    }

    /**
     * Format phone number
     */
    public static function formatPhone($phone) {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($phone) === 10) {
            return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6);
        }
        return $phone;
    }
}
?>