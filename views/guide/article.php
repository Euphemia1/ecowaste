<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/recycling-guide" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600">
                        <i class="fas fa-book mr-2"></i>
                        Recycling Guide
                    </a>
                </li>
                <li class="inline-flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-sm mx-1"></i>
                    <a href="/recycling-guide/category?slug=<?php echo urlencode($guide['category']); ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600">
                        <?php echo Security::escape($guide['category']); ?>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-sm mx-1"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 truncate max-w-xs"><?php echo Security::escape($guide['title']); ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <article class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100">
            <?php if ($guide['image_url']): ?>
            <div class="h-64 w-full relative">
                <img class="w-full h-full object-cover" src="<?php echo Security::escape($guide['image_url']); ?>" alt="<?php echo Security::escape($guide['title']); ?>">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
            </div>
            <?php endif; ?>

            <div class="p-8">
                <header class="mb-8">
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                            <?php echo Security::escape($guide['category']); ?>
                        </span>
                    </div>
                    <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                        <?php echo Security::escape($guide['title']); ?>
                    </h1>
                </header>

                <div class="prose prose-green max-w-none text-gray-700">
                    <?php echo nl2br(Security::escape($guide['content'])); ?>
                </div>

                <!-- Tips Section if available -->
                <?php if (!empty($guide['tips'])): ?>
                <div class="mt-10 bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-lightbulb text-yellow-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-yellow-800">Pro Tips</h3>
                            <div class="mt-2 text-yellow-700">
                                <p><?php echo nl2br(Security::escape($guide['tips'])); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Do's and Don'ts -->
                <?php 
                    $dos = !empty($guide['do_list']) ? json_decode($guide['do_list'], true) : [];
                    $donts = !empty($guide['dont_list']) ? json_decode($guide['dont_list'], true) : [];
                ?>
                
                <?php if (!empty($dos) || !empty($donts)): ?>
                <div class="mt-12 grid md:grid-cols-2 gap-8">
                    <?php if (!empty($dos)): ?>
                    <div class="bg-green-50 rounded-lg p-6 border border-green-100">
                        <h3 class="text-lg font-bold text-green-800 mb-4 flex items-center">
                            <i class="fas fa-check-circle mr-2"></i> Do Recycle
                        </h3>
                        <ul class="space-y-2">
                            <?php foreach ($dos as $item): ?>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-2">•</span>
                                <span class="text-gray-700"><?php echo Security::escape($item); ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($donts)): ?>
                    <div class="bg-red-50 rounded-lg p-6 border border-red-100">
                        <h3 class="text-lg font-bold text-red-800 mb-4 flex items-center">
                            <i class="fas fa-times-circle mr-2"></i> Don't Recycle
                        </h3>
                        <ul class="space-y-2">
                            <?php foreach ($donts as $item): ?>
                            <li class="flex items-start">
                                <span class="text-red-500 mr-2">•</span>
                                <span class="text-gray-700"><?php echo Security::escape($item); ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </article>

        <!-- Related Guides -->
        <?php if (!empty($related_guides)): ?>
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Guides</h2>
            <div class="grid gap-6 md:grid-cols-3">
                <?php foreach ($related_guides as $related): ?>
                <a href="/recycling-guide/article?slug=<?php echo Security::escape($related['slug']); ?>" class="group block bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow overflow-hidden">
                    <?php if ($related['image_url']): ?>
                    <div class="h-32 bg-gray-200">
                        <img src="<?php echo Security::escape($related['image_url']); ?>" class="w-full h-full object-cover group-hover:opacity-90 transition-opacity">
                    </div>
                    <?php else: ?>
                    <div class="h-32 bg-green-50 flex items-center justify-center">
                        <i class="fas fa-recycle text-gray-300 text-3xl"></i>
                    </div>
                    <?php endif; ?>
                    <div class="p-4">
                        <h4 class="font-medium text-gray-900 group-hover:text-green-600 transition-colors">
                            <?php echo Security::escape($related['title']); ?>
                        </h4>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="mt-12 text-center">
            <a href="/recycling-guide" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back to All Guides
            </a>
        </div>
    </div>
</div>
