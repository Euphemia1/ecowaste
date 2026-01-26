<?php

// Start session
session_start();

// Include configuration files
require_once '../config/config.php';
require_once '../config/database.php';

// Include core classes
require_once '../includes/Router.php';
require_once '../includes/Security.php';
require_once '../includes/Helpers.php';

// Initialize security
Security::init();

// Create router instance
$router = new Router();

// Define routes
$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');

// Authentication routes
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@processLogin');
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@processRegister');
$router->get('/logout', 'AuthController@logout');
$router->get('/forgot-password', 'AuthController@forgotPassword');
$router->post('/forgot-password', 'AuthController@processForgotPassword');
$router->get('/reset-password', 'AuthController@resetPassword');
$router->post('/reset-password', 'AuthController@processResetPassword');

// Dashboard routes (protected)
$router->get('/dashboard', 'DashboardController@index');
$router->get('/profile', 'UserController@profile');
$router->post('/profile', 'UserController@updateProfile');

// Impact tracking routes
$router->get('/impact', 'ImpactController@index');
$router->get('/impact/monthly', 'ImpactController@monthlyData');
$router->get('/impact/charts', 'ImpactController@chartData');

// Pickup service routes
$router->get('/schedule-pickup', 'PickupController@schedule');
$router->post('/schedule-pickup', 'PickupController@processSchedule');
$router->get('/pickup-history', 'PickupController@history');
$router->get('/pickup-details', 'PickupController@details');
$router->post('/cancel-pickup', 'PickupController@cancel');

// Recycling guide routes
$router->get('/recycling-guide', 'GuideController@index');
$router->get('/recycling-guide/category', 'GuideController@category');
$router->get('/recycling-guide/article', 'GuideController@article');

// API routes
$router->get('/api/waste-categories', 'ApiController@wasteCategories');
$router->get('/api/impact-data', 'ApiController@impactData');
$router->post('/api/calculate-impact', 'ApiController@calculateImpact');

// New static/semi-static pages
$router->get('/about', 'HomeController@about');
$router->get('/pricing', 'HomeController@pricing');
$router->get('/pilot-plan', 'HomeController@pilotPlan');
$router->get('/food-waste-program', 'HomeController@foodWaste');
$router->get('/partnerships', 'HomeController@partnerships');
$router->get('/faq', 'HomeController@faq');
$router->get('/contact', 'HomeController@contact');
$router->get('/commercial-partnership', 'HomeController@commercialInquiry');
$router->get('/worker-application', 'WorkerController@application');
$router->get('/privacy', 'LegalController@privacy');
$router->get('/terms', 'LegalController@terms');

// Handle the request
try {
    $router->dispatch();
} catch (Exception $e) {
    if (ENVIRONMENT === 'development') {
        echo "Error: " . $e->getMessage();
    } else {
        // Log error and show generic error page
        error_log($e->getMessage());
        header('HTTP/1.1 500 Internal Server Error');
        require_once '../views/errors/500.php';
    }
}
?>

