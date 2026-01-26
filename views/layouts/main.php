<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? Security::escape($title) : 'EcoWaste - Sustainable Waste Management'; ?></title>
    <meta name="description" content="EcoWaste - Sustainable waste management platform for tracking environmental impact and scheduling eco-friendly pickups.">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/main.css" rel="stylesheet">
    
    <!-- Additional page-specific styles -->
    <?php if (isset($additional_css)): ?>
        <?php foreach ($additional_css as $css): ?>
            <link href="<?php echo $css; ?>" rel="stylesheet">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="bg-gray-50 min-h-screen">
    
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 flex items-center">
                        <i class="fas fa-leaf text-green-600 text-2xl mr-2"></i>
                        <span class="text-xl font-bold text-gray-800">EcoWaste</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="<?php echo Helpers::isCurrentRoute('/') ? 'text-green-600' : 'text-gray-600'; ?> hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors">
                        Home
                    </a>
                    <?php if ($user): ?>
                        <a href="/dashboard" class="<?php echo Helpers::isCurrentRoute('/dashboard') ? 'text-green-600' : 'text-gray-600'; ?> hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors">
                            Dashboard
                        </a>
                        <a href="/schedule-pickup" class="<?php echo Helpers::isCurrentRoute('/schedule-pickup') ? 'text-green-600' : 'text-gray-600'; ?> hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors">
                            Schedule Pickup
                        </a>
                        <a href="/impact" class="<?php echo Helpers::isCurrentRoute('/impact') ? 'text-green-600' : 'text-gray-600'; ?> hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors">
                            My Impact
                        </a>
                    <?php endif; ?>
                    <a href="/recycling-guide" class="<?php echo Helpers::isCurrentRoute('/recycling-guide') ? 'text-green-600' : 'text-gray-600'; ?> hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors">
                        Recycling Guide
                    </a>
                    <a href="/pricing" class="<?php echo Helpers::isCurrentRoute('/pricing') ? 'text-green-600' : 'text-gray-600'; ?> hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors">
                        Pricing
                    </a>
                    <a href="/about" class="<?php echo Helpers::isCurrentRoute('/about') ? 'text-green-600' : 'text-gray-600'; ?> hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors">
                        About
                    </a>
                    
                    <?php if ($user): ?>
                        <!-- User Menu -->
                        <div class="relative ml-3" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open" class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <span class="sr-only">Open user menu</span>
                                    <div class="h-8 w-8 rounded-full bg-green-600 flex items-center justify-center">
                                        <span class="text-white font-medium text-sm">
                                            <?php echo substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1); ?>
                                        </span>
                                    </div>
                                </button>
                            </div>
                            
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-sm text-gray-700 font-medium"><?php echo Security::escape($user['first_name'] . ' ' . $user['last_name']); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo Security::escape($user['email']); ?></p>
                                </div>
                                <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                                <a href="/pickup-history" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pickup History</a>
                                <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/login" class="text-gray-600 hover:text-green-600 px-3 py-2 text-sm font-medium transition-colors">
                            Login
                        </a>
                        <a href="/register" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Sign Up
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" class="mobile-menu-button text-gray-600 hover:text-green-600 focus:outline-none focus:text-green-600" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="md:hidden mobile-menu hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
                <a href="/" class="<?php echo Helpers::isCurrentRoute('/') ? 'text-green-600 bg-green-50' : 'text-gray-600'; ?> block px-3 py-2 text-base font-medium hover:text-green-600 hover:bg-green-50">Home</a>
                <?php if ($user): ?>
                    <a href="/dashboard" class="<?php echo Helpers::isCurrentRoute('/dashboard') ? 'text-green-600 bg-green-50' : 'text-gray-600'; ?> block px-3 py-2 text-base font-medium hover:text-green-600 hover:bg-green-50">Dashboard</a>
                    <a href="/schedule-pickup" class="<?php echo Helpers::isCurrentRoute('/schedule-pickup') ? 'text-green-600 bg-green-50' : 'text-gray-600'; ?> block px-3 py-2 text-base font-medium hover:text-green-600 hover:bg-green-50">Schedule Pickup</a>
                    <a href="/impact" class="<?php echo Helpers::isCurrentRoute('/impact') ? 'text-green-600 bg-green-50' : 'text-gray-600'; ?> block px-3 py-2 text-base font-medium hover:text-green-600 hover:bg-green-50">My Impact</a>
                <?php endif; ?>
                <a href="/recycling-guide" class="<?php echo Helpers::isCurrentRoute('/recycling-guide') ? 'text-green-600 bg-green-50' : 'text-gray-600'; ?> block px-3 py-2 text-base font-medium hover:text-green-600 hover:bg-green-50">Recycling Guide</a>
                
                <?php if ($user): ?>
                    <div class="border-t border-gray-200 pt-4 pb-3">
                        <div class="flex items-center px-5">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-green-600 flex items-center justify-center">
                                    <span class="text-white font-medium">
                                        <?php echo substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800"><?php echo Security::escape($user['first_name'] . ' ' . $user['last_name']); ?></div>
                                <div class="text-sm font-medium text-gray-500"><?php echo Security::escape($user['email']); ?></div>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1 px-2">
                            <a href="/profile" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-green-600 hover:bg-green-50">Your Profile</a>
                            <a href="/pickup-history" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-green-600 hover:bg-green-50">Pickup History</a>
                            <a href="/logout" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-green-600 hover:bg-green-50">Sign out</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="border-t border-gray-200 pt-4 pb-3 space-y-1">
                        <a href="/login" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-green-600 hover:bg-green-50">Login</a>
                        <a href="/register" class="block px-3 py-2 text-base font-medium bg-green-600 text-white hover:bg-green-700 rounded-md mx-3">Sign Up</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php if (!empty($flash_messages)): ?>
        <div class="flash-messages">
            <?php foreach ($flash_messages as $message): ?>
                <div class="alert alert-<?php echo $message['type']; ?> max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
                    <div class="p-4 rounded-md <?php echo $message['type'] === 'success' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'; ?>">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <?php if ($message['type'] === 'success'): ?>
                                    <i class="fas fa-check-circle text-green-400"></i>
                                <?php else: ?>
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                <?php endif; ?>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm <?php echo $message['type'] === 'success' ? 'text-green-800' : 'text-red-800'; ?>">
                                    <?php echo Security::escape($message['message']); ?>
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="-mx-1.5 -my-1.5">
                                    <button type="button" class="inline-flex <?php echo $message['type'] === 'success' ? 'text-green-500 hover:text-green-600' : 'text-red-500 hover:text-red-600'; ?> rounded-md p-1.5 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.parentElement.style.display='none'">
                                        <span class="sr-only">Dismiss</span>
                                        <i class="fas fa-times text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main>
        <?php echo $content; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="space-y-8 xl:col-span-1">
                    <div class="flex items-center">
                        <i class="fas fa-leaf text-green-400 text-2xl mr-2"></i>
                        <span class="text-xl font-bold">EcoWaste</span>
                    </div>
                    <p class="text-gray-300 text-base">
                        Making waste management sustainable and accessible for everyone. Track your environmental impact and contribute to a greener future.
                    </p>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-300 hover:text-green-400 transition-colors">
                            <span class="sr-only">Facebook</span>
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-green-400 transition-colors">
                            <span class="sr-only">Twitter</span>
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-green-400 transition-colors">
                            <span class="sr-only">Instagram</span>
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>
                <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Services</h3>
                            <ul class="mt-4 space-y-4">
                                <li><a href="/schedule-pickup" class="text-base text-gray-300 hover:text-green-400 transition-colors">Schedule Pickup</a></li>
                                <li><a href="/recycling-guide" class="text-base text-gray-300 hover:text-green-400 transition-colors">Recycling Guide</a></li>
                                <li><a href="/food-waste-program" class="text-base text-gray-300 hover:text-green-400 transition-colors">Food Waste Program</a></li>
                                <li><a href="/partnerships" class="text-base text-gray-300 hover:text-green-400 transition-colors">Partnerships</a></li>
                            </ul>
                        </div>
                        <div class="mt-12 md:mt-0">
                            <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Company</h3>
                            <ul class="mt-4 space-y-4">
                                <li><a href="/about" class="text-base text-gray-300 hover:text-green-400 transition-colors">About Us</a></li>
                                <li><a href="/pricing" class="text-base text-gray-300 hover:text-green-400 transition-colors">Pricing</a></li>
                                <li><a href="/pilot-plan" class="text-base text-gray-300 hover:text-green-400 transition-colors">Pilot Plan</a></li>
                                <li><a href="/worker-application" class="text-base text-gray-300 hover:text-green-400 transition-colors">Become a Worker</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8">
                <p class="text-base text-gray-300 xl:text-center">
                    &copy; 2025 EcoWaste. All rights reserved. Together for a sustainable future.
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="/assets/js/main.js"></script>
    
    <!-- Additional page-specific scripts -->
    <?php if (isset($additional_js)): ?>
        <?php foreach ($additional_js as $js): ?>
            <script src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>