<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? Security::escape($title) : 'EcoWaste'; ?></title>
    <meta name="description" content="EcoWaste - Sustainable waste management platform">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/auth.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-green-50 to-green-100 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-32 w-80 h-80 bg-green-100 rounded-full opacity-50"></div>
        <div class="absolute -bottom-40 -left-32 w-80 h-80 bg-green-200 rounded-full opacity-50"></div>
    </div>
    
    <!-- Main Container -->
    <div class="relative max-w-md w-full space-y-8">
        
        <!-- Header -->
        <div class="text-center">
            <a href="/" class="inline-flex items-center mb-6">
                <i class="fas fa-leaf text-green-600 text-3xl mr-3"></i>
                <span class="text-2xl font-bold text-gray-800">EcoWaste</span>
            </a>
        </div>

        <!-- Flash Messages -->
        <?php if (!empty($flash_messages)): ?>
            <div class="space-y-3">
                <?php foreach ($flash_messages as $message): ?>
                    <div class="alert alert-<?php echo $message['type']; ?>">
                        <div class="p-4 rounded-lg <?php echo $message['type'] === 'success' ? 'bg-green-100 border border-green-200' : 'bg-red-100 border border-red-200'; ?>">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <?php if ($message['type'] === 'success'): ?>
                                        <i class="fas fa-check-circle text-green-600"></i>
                                    <?php else: ?>
                                        <i class="fas fa-exclamation-circle text-red-600"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm <?php echo $message['type'] === 'success' ? 'text-green-800' : 'text-red-800'; ?>">
                                        <?php echo Security::escape($message['message']); ?>
                                    </p>
                                </div>
                                <button type="button" class="ml-auto -mx-1.5 -my-1.5 <?php echo $message['type'] === 'success' ? 'text-green-500 hover:text-green-600' : 'text-red-500 hover:text-red-600'; ?> rounded-lg p-1.5" onclick="this.parentElement.parentElement.parentElement.style.display='none'">
                                    <i class="fas fa-times text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <?php echo $content; ?>
        </div>

        <!-- Footer Links -->
        <div class="text-center text-sm text-gray-600">
            <div class="space-x-4">
                <a href="/recycling-guide" class="hover:text-green-600 transition-colors">Recycling Guide</a>
                <span>•</span>
                <a href="#" class="hover:text-green-600 transition-colors">Privacy Policy</a>
                <span>•</span>
                <a href="#" class="hover:text-green-600 transition-colors">Contact</a>
            </div>
            <p class="mt-2 text-xs text-gray-500">
                &copy; <?php echo date('Y'); ?> EcoWaste. All rights reserved.
            </p>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="/assets/js/auth.js"></script>
</body>
</html>