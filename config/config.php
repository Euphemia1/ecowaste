<?php
/**
 * Application Configuration
 * EcoWaste - Sustainable Waste Management Platform
 */

// Application settings
define('APP_NAME', 'EcoWaste');
define('APP_VERSION', '1.0.0');
define('APP_URL', getenv('APP_URL') ?: 'http://localhost/ecowaste');
define('BASE_PATH', dirname(__DIR__));
define('PUBLIC_PATH', BASE_PATH . '/public');

// Security settings
define('SESSION_TIMEOUT', 3600); // 1 hour
define('CSRF_TOKEN_LENGTH', 32);
define('PASSWORD_MIN_LENGTH', 8);

// Email settings
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-password');
define('FROM_EMAIL', 'noreply@ecowaste.com');
define('FROM_NAME', 'EcoWaste Team');

// File upload settings
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif']);
define('UPLOAD_PATH', BASE_PATH . '/uploads/');

// Pagination settings
define('ITEMS_PER_PAGE', 10);

// Environmental calculation factors
define('CO2_REDUCTION_PER_KG', 2.5); // kg CO2 saved per kg recycled
define('TREES_SAVED_PER_TON', 17); // trees saved per ton recycled
define('WATER_SAVED_PER_KG', 50); // liters saved per kg recycled

// Waste types
define('WASTE_TYPES', [
    'recyclables' => 'Recyclables',
    'electronics' => 'Electronics',
    'organic' => 'Organic Waste',
    'hazardous' => 'Hazardous Materials',
    'bulky' => 'Bulky Items'
]);

// Time slots for pickup
define('TIME_SLOTS', [
    'morning' => '8:00 AM - 12:00 PM',
    'afternoon' => '12:00 PM - 5:00 PM',
    'evening' => '5:00 PM - 8:00 PM'
]);

// Account types
define('ACCOUNT_TYPES', [
    'individual' => 'Individual',
    'business' => 'Business'
]);

// Environment setting
define('ENVIRONMENT', getenv('APP_ENV') ?: 'development'); // Change to 'production' for live site

// Error reporting
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Timezone
date_default_timezone_set('Africa/Lusaka');

?>