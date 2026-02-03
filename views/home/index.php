<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-green-600 to-blue-600 overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="relative max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <div class="inline-flex items-center px-3 py-1 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-white text-xs font-semibold mb-4">
                        <i class="fas fa-award mr-2"></i>
                        F6 Innovation Challenge: Green Driving Green Growth in Zambia
                    </div>
                    <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Driving Green Growth</span>
                        <span class="block text-green-200 xl:inline"> Through Waste Innovation</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-200 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Revolutionary waste-to-wealth platform powering Zambia's circular economy. Transform waste into green jobs, 
                        sustainable agriculture, and carbon credits while building Lusaka's smart city infrastructure.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <?php if ($user): ?>
                                <a href="/dashboard" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 md:py-4 md:text-lg md:px-10 transition-colors">
                                    Go to Dashboard
                                </a>
                            <?php else: ?>
                                <a href="/register" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 md:py-4 md:text-lg md:px-10 transition-colors">
                                    Get Started - ZMW 50/pickup
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="/pilot-plan" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-green-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10 transition-colors">
                                View Pilot Plan
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
                <p class="text-xl font-semibold">Waste → Compost → Agriculture</p>
                <p class="text-sm text-green-100 mt-2">Full Circular Economy</p>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base text-green-600 font-semibold tracking-wide uppercase">Green Innovation Impact</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Driving Zambia's Circular Economy Revolution
            </p>
        </div>

        <div class="mt-10">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Green Jobs Created -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white mx-auto">
                        <i class="fas fa-briefcase text-xl"></i>
                    </div>
                    <dt class="mt-5 text-lg leading-6 font-medium text-gray-900">Green Jobs Created</dt>
                    <dd class="mt-2 text-base text-gray-500">
                        <span class="text-3xl font-extrabold text-green-600">
                            <?php echo number_format($stats['green_jobs']); ?>
                        </span>
                    </dd>
                </div>

                <!-- Waste to Wealth -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                        <i class="fas fa-coins text-xl"></i>
                    </div>
                    <dt class="mt-5 text-lg leading-6 font-medium text-gray-900">Waste to Wealth (ZMW)</dt>
                    <dd class="mt-2 text-base text-gray-500">
                        <span class="text-3xl font-extrabold text-blue-600">
                            <?php echo number_format($stats['waste_to_wealth'], 0); ?>
                        </span>
                    </dd>
                </div>

                <!-- Carbon Credits -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-purple-500 text-white mx-auto">
                        <i class="fas fa-certificate text-xl"></i>
                    </div>
                    <dt class="mt-5 text-lg leading-6 font-medium text-gray-900">Carbon Credits Generated</dt>
                    <dd class="mt-2 text-base text-gray-500">
                        <span class="text-3xl font-extrabold text-purple-600">
                            <?php echo number_format($stats['carbon_credits'], 1); ?><span class="text-base font-normal"> tons</span>
                        </span>
                    </dd>
                </div>

                <!-- Farmers Supported -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-600 text-white mx-auto">
                        <i class="fas fa-seedling text-xl"></i>
                    </div>
                    <dt class="mt-5 text-lg leading-6 font-medium text-gray-900">Farmers Supported</dt>
                    <dd class="mt-2 text-base text-gray-500">
                        <span class="text-3xl font-extrabold text-green-700">
                            <?php echo number_format($stats['farmers_supported'], 0); ?>
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
            <h2 class="text-base text-green-600 font-semibold tracking-wide uppercase">Green Innovation Features</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Building Zambia's Sustainable Future
            </p>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                Revolutionary platform transforming waste into economic opportunities while driving environmental sustainability and green job creation across Zambia.
            </p>
        </div>

        <div class="mt-10">
            <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                <!-- Circular Economy -->
                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white">
                            <i class="fas fa-sync-alt text-xl"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Circular Economy Engine</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        Transform waste into valuable resources through our innovative circular economy model, creating sustainable value chains and reducing environmental impact.
                    </dd>
                </div>

                <!-- Green Jobs -->
                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                            <i class="fas fa-hard-hat text-xl"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Green Job Creation</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        Generate employment opportunities for Zambian youth through waste collection, sorting, and processing, building a skilled green workforce.
                    </dd>
                </div>

                <!-- Carbon Credits -->
                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-purple-500 text-white">
                            <i class="fas fa-certificate text-xl"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Carbon Credit Generation</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        Monetize environmental impact through carbon credit trading, creating new revenue streams for sustainable waste management practices.
                    </dd>
                </div>

                <!-- Smart City Integration -->
                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <i class="fas fa-city text-xl"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Smart City Infrastructure</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        Power Lusaka's transformation into a smart city with IoT-enabled waste tracking, data analytics, and optimized collection routes.
                    </dd>
                </div>
                <!-- Agricultural Support -->
                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-orange-500 text-white">
                            <i class="fas fa-seedling text-xl"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Agricultural Innovation</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        Convert organic waste into nutrient-rich compost for Zambian farmers, enhancing food security and promoting sustainable agriculture.
                    </dd>
                </div>

                <!-- Mobile Money Economy -->
                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-yellow-500 text-white">
                            <i class="fas fa-mobile-alt text-xl"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Digital Financial Inclusion</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        Leverage mobile money ecosystems to drive financial inclusion, enabling seamless transactions and economic participation for all Zambians.
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
            <span class="block">Ready to drive Zambia's green growth?</span>
            <span class="block text-green-200">Join the circular economy revolution today.</span>
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