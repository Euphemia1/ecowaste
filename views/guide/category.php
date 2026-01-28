<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/recycling-guide" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600">
                        <i class="fas fa-book mr-2"></i>
                        Recycling Guide
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-sm mx-1"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2"><?php echo Security::escape($category); ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="text-center mb-12">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                <?php echo Security::escape($category); ?> Recycling Guide
            </h1>
            <p class="mt-4 text-lg text-gray-500">
                Browse detailed guides on how to properly recycle <?php echo strtolower($category); ?> items.
            </p>
        </div>

        <?php if (empty($guides)): ?>
            <div class="text-center py-12 bg-white rounded-lg shadow-sm border border-gray-200">
                <i class="far fa-folder-open text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">No guides found</h3>
                <p class="mt-2 text-gray-500">We haven't added any guides for this category yet. Check back soon!</p>
                <div class="mt-6">
                    <a href="/recycling-guide" class="text-green-600 hover:text-green-500 font-medium">
                        Browse other categories <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($guides as $guide): ?>
                <div class="flex flex-col bg-white rounded-lg shadow overflow-hidden border border-gray-100 hover:border-green-200 transition-colors">
                    <?php if ($guide['image_url']): ?>
                    <div class="flex-shrink-0">
                        <img class="h-48 w-full object-cover" src="<?php echo Security::escape($guide['image_url']); ?>" alt="<?php echo Security::escape($guide['title']); ?>">
                    </div>
                    <?php else: ?>
                    <div class="h-48 bg-gradient-to-br from-green-100 to-blue-100 flex items-center justify-center">
                        <i class="fas fa-recycle text-4xl text-green-600 opacity-50"></i>
                    </div>
                    <?php endif; ?>
                    
                    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-green-600">
                                <?php echo Security::escape($guide['category']); ?>
                            </p>
                            <a href="/recycling-guide/article?slug=<?php echo Security::escape($guide['slug']); ?>" class="block mt-2">
                                <p class="text-xl font-semibold text-gray-900 group-hover:text-green-600 transition-colors">
                                    <?php echo Security::escape($guide['title']); ?>
                                </p>
                                <p class="mt-3 text-base text-gray-500 line-clamp-3">
                                    <?php echo Helpers::truncateText(strip_tags($guide['content']), 150); ?>
                                </p>
                            </a>
                        </div>
                        <div class="mt-6">
                            <a href="/recycling-guide/article?slug=<?php echo Security::escape($guide['slug']); ?>" class="w-full flex items-center justify-center px-4 py-2 border border-green-600 text-sm font-medium rounded-md text-green-600 bg-white hover:bg-green-50">
                                Read Full Guide
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
