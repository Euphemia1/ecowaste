<div class="bg-white">
    <!-- Header -->
    <div class="bg-green-600 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h1 class="text-4xl font-extrabold tracking-tight">Recycling Guide</h1>
            <p class="mt-4 text-xl text-green-100 max-w-2xl mx-auto">
                Everything you need to know about sorting and recycling waste correctly in Zambia.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Categories Grid -->
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Browse by Category</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
            <?php foreach ($categories as $category): ?>
            <a href="/recycling-guide/category?slug=<?php echo urlencode($category); ?>" class="group block">
                <div class="bg-gray-50 rounded-lg p-6 text-center hover:bg-green-50 hover:shadow-md transition-all border border-gray-200 hover:border-green-200">
                    <div class="h-12 w-12 mx-auto bg-white rounded-full flex items-center justify-center text-green-600 shadow-sm mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-recycle text-xl"></i>
                    </div>
                    <span class="text-lg font-medium text-gray-900 group-hover:text-green-700"><?php echo Security::escape($category); ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Recent Guides -->
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Recent Articles</h2>
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($recent_guides as $guide): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow border border-gray-100">
                <?php if ($guide['image_url']): ?>
                <div class="h-48 bg-gray-200">
                    <img src="<?php echo Security::escape($guide['image_url']); ?>" alt="<?php echo Security::escape($guide['title']); ?>" class="w-full h-full object-cover">
                </div>
                <?php else: ?>
                <div class="h-48 bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center">
                    <i class="fas fa-book-open text-4xl text-white opacity-80"></i>
                </div>
                <?php endif; ?>
                
                <div class="p-6">
                    <div class="flex items-center mb-2">
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                            <?php echo Security::escape($guide['category']); ?>
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        <a href="/recycling-guide/article?slug=<?php echo Security::escape($guide['slug']); ?>" class="hover:text-green-600">
                            <?php echo Security::escape($guide['title']); ?>
                        </a>
                    </h3> 
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        <?php echo Helpers::truncateText(strip_tags($guide['content']), 120); ?>
                    </p>
                    <a href="/recycling-guide/article?slug=<?php echo Security::escape($guide['slug']); ?>" class="text-green-600 font-medium hover:text-green-700 inline-flex items-center">
                        Read Guide <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
