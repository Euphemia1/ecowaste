<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-green-600 to-blue-600 overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="relative max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Sustainable</span>
                        <span class="block text-green-200 xl:inline">Waste Management</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-200 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Track your environmental impact, schedule eco-friendly pickups, and learn proper recycling techniques. 
                        Join thousands of users making a difference for our planet.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <?php if ($user): ?>
                                <a href="/dashboard" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 md:py-4 md:text-lg md:px-10 transition-colors">
                                    Go to Dashboard
                                </a>
                            <?php else: ?>
                                <a href="/register" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 md:py-4 md:text-lg md:px-10 transition-colors">
                                    Get Started
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="/recycling-guide" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-green-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10 transition-colors">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <div class="h-56 w-full bg-gradient-to-br from-green-400 to-blue-500 opacity-90 sm:h-72 md:h-96 lg:w-full lg:h-full flex items-center justify-center">
            <div class="text-center text-white">
                <i class="fas fa-recycle text-8xl mb-4 opacity-80"></i>
                <p class="text-xl font-semibold">Making Recycling Easy</p>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base text-green-600 font-semibold tracking-wide uppercase">Our Impact</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Making a Real Difference
            </p>
        </div>

        <div class="mt-10">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Total Users -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white mx-auto">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <dt class="mt-5 text-lg leading-6 font-medium text-gray-900">Active Users</dt>
                    <dd class="mt-2 text-base text-gray-500">
                        <span class="text-3xl font-extrabold text-green-600">
                            <?php echo number_format($stats['total_users']); ?>
                        </span>
                    </dd>
                </div>

                <!-- Total Waste Recycled -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                        <i class="fas fa-weight text-xl"></i>
                    </div>
                    <dt class="mt-5 text-lg leading-6 font-medium text-gray-900">Waste Recycled</dt>
                    <dd class="mt-2 text-base text-gray-500">
                        <span class="text-3xl font-extrabold text-blue-600">
                            <?php echo Helpers::formatWeight($stats['total_waste_recycled']); ?>
                        </span>
                    </dd>
                </div>

                <!-- CO2 Saved -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-purple-500 text-white mx-auto">
                        <i class="fas fa-cloud text-xl"></i>
                    </div>
                    <dt class="mt-5 text-lg leading-6 font-medium text-gray-900">CO₂ Reduced</dt>
                    <dd class="mt-2 text-base text-gray-500">
                        <span class="text-3xl font-extrabold text-purple-600">
                            <?php echo number_format($stats['co2_saved'], 1); ?><span class="text-base font-normal"> kg</span>
                        </span>
                    </dd>
                </div>

                <!-- Trees Saved -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-600 text-white mx-auto">
                        <i class="fas fa-tree text-xl"></i>
                    </div>
                    <dt class="mt-5 text-lg leading-6 font-medium text-gray-900">Trees Saved</dt>
                    <dd class="mt-2 text-base text-gray-500">
                        <span class="text-3xl font-extrabold text-green-700">
                            <?php echo number_format($stats['trees_saved'], 0); ?>
                        </span>
                    </dd>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center">
            <h2 class="text-base text-green-600 font-semibold tracking-wide uppercase">Features</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Everything you need for sustainable waste management
            </p>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                Our platform provides comprehensive tools to help you track, manage, and reduce your environmental impact.
            </p>
        </div>

        <div class="mt-10">
            <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                <!-- Impact Dashboard -->
                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Impact Dashboard</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        Track your environmental impact with detailed analytics. Monitor recycling rates, carbon footprint reduction, and resource savings with interactive charts and real-time metrics.
                    </dd>
                </div>

                <!-- Schedule Pickup -->
                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                            <i class="fas fa-calendar-check text-xl"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Easy Pickup Scheduling</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        Schedule waste pickups with our multi-step wizard. Support for recyclables, electronics, organic waste, hazardous materials, and bulky items with flexible time slots.
                    </dd>
                </div>

                <!-- Recycling Guide -->
                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-purple-500 text-white">
                            <i class="fas fa-book-open text-xl"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Comprehensive Guides</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        Learn proper recycling techniques with detailed guidelines for different materials, recycling codes explanations, and best practices for waste preparation.
                    </dd>
                </div>

                <!-- Secure Authentication -->
                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <i class="fas fa-shield-alt text-xl"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Secure & Private</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        Your data is protected with industry-standard security measures. Secure authentication, encrypted data transmission, and privacy-focused design.
                    </dd>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Recycling Guides -->
<?php if (!empty($featured_guides)): ?>
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base text-green-600 font-semibold tracking-wide uppercase">Learn & Explore</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Featured Recycling Guides
            </p>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                Discover the best practices for recycling different materials and reducing waste.
            </p>
        </div>

        <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($featured_guides as $guide): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <?php if ($guide['image_url']): ?>
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <img src="<?php echo Security::escape($guide['image_url']); ?>" alt="<?php echo Security::escape($guide['title']); ?>" class="w-full h-full object-cover">
                </div>
                <?php else: ?>
                <div class="h-48 bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center">
                    <i class="fas fa-recycle text-4xl text-white"></i>
                </div>
                <?php endif; ?>
                <div class="p-6">
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <?php echo Security::escape($guide['category']); ?>
                        </span>
                    </div>
                    <h3 class="mt-2 text-xl font-semibold text-gray-900">
                        <a href="/recycling-guide/article?slug=<?php echo Security::escape($guide['slug']); ?>" class="hover:text-green-600 transition-colors">
                            <?php echo Security::escape($guide['title']); ?>
                        </a>
                    </h3>
                    <p class="mt-3 text-base text-gray-500">
                        <?php echo Helpers::truncateText(strip_tags($guide['content']), 120); ?>
                    </p>
                    <div class="mt-4">
                        <a href="/recycling-guide/article?slug=<?php echo Security::escape($guide['slug']); ?>" class="text-green-600 hover:text-green-700 font-medium">
                            Read More <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-10 text-center">
            <a href="/recycling-guide" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition-colors">
                View All Guides
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- CTA Section -->
<div class="bg-green-600">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
        <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
            <span class="block">Ready to make a difference?</span>
            <span class="block text-green-200">Start your sustainable journey today.</span>
        </h2>
        <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
            <div class="inline-flex rounded-md shadow">
                <?php if ($user): ?>
                    <a href="/schedule-pickup" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-green-600 bg-white hover:bg-gray-50 transition-colors">
                        Schedule Pickup
                    </a>
                <?php else: ?>
                    <a href="/register" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-green-600 bg-white hover:bg-gray-50 transition-colors">
                        Join EcoWaste
                    </a>
                <?php endif; ?>
            </div>
            <div class="ml-3 inline-flex rounded-md shadow">
                <a href="/recycling-guide" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-700 hover:bg-green-800 transition-colors">
                    Learn More
                </a>
            </div>
        </div>
    </div>
</div>