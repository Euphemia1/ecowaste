<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        Welcome back, <?php echo Security::escape($user['first_name']); ?>!
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Here's an overview of your recycling impact and scheduled pickups.
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="/schedule-pickup" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-plus mr-2"></i> Schedule Pickup
                    </a>
                    <a href="/recycling-guide" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-book mr-2"></i> View Guide
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Weight -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-md bg-green-400 p-3">
                            <i class="fas fa-weight-hanging text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Recycled</dt>
                            <dd>
                                <div class="text-lg font-medium text-gray-900">
                                    <?php echo Helpers::formatWeight($impact_stats['total_weight']); ?>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <span class="text-green-600 font-medium">
                        <?php echo Helpers::formatWeight($impact_stats['month_weight']); ?>
                    </span>
                    <span class="text-gray-500"> this month</span>
                </div>
            </div>
        </div>

        <!-- CO2 Saved -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-md bg-green-500 p-3">
                            <i class="fas fa-cloud text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">CO₂ Saved</dt>
                            <dd>
                                <div class="text-lg font-medium text-gray-900">
                                    <?php echo number_format($impact_stats['co2_saved'], 1); ?> kg
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <span class="text-green-600 font-medium">
                        <?php echo number_format($impact_stats['month_co2_saved'], 1); ?> kg
                    </span>
                    <span class="text-gray-500"> this month</span>
                </div>
            </div>
        </div>

        <!-- Trees Saved -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-md bg-green-600 p-3">
                            <i class="fas fa-tree text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Trees Saved</dt>
                            <dd>
                                <div class="text-lg font-medium text-gray-900">
                                    <?php echo number_format($impact_stats['trees_saved'], 1); ?>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <span class="text-green-600 font-medium">
                        <?php echo number_format($impact_stats['month_trees_saved'], 1); ?>
                    </span>
                    <span class="text-gray-500"> this month</span>
                </div>
            </div>
        </div>

        <!-- Impact Score -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-md bg-green-500 p-3">
                            <i class="fas fa-star text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Recycling Rate</dt>
                            <dd>
                                <div class="text-lg font-medium text-gray-900">
                                    <?php echo number_format($impact_stats['recycling_rate'], 0); ?>%
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="/impact" class="font-medium text-green-600 hover:text-green-900">
                        View detailed impact
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Upcoming Pickups -->
        <div class="bg-white shadow rounded-lg">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Upcoming Pickups</h3>
                <a href="/schedule-pickup" class="text-sm text-green-600 hover:text-green-900">Schedule New</a>
            </div>
            <div class="p-6">
                <?php if (empty($upcoming_pickups)): ?>
                    <div class="text-center py-6">
                        <i class="fas fa-calendar-times text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">No scheduled pickups.</p>
                        <a href="/schedule-pickup" class="mt-2 inline-block text-sm font-medium text-green-600 hover:text-green-500">
                            Schedule your first pickup &rarr;
                        </a>
                    </div>
                <?php else: ?>
                    <ul class="divide-y divide-gray-200">
                        <?php foreach ($upcoming_pickups as $pickup): ?>
                        <li class="py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-green-600">
                                        <?php echo date('l, M j, Y', strtotime($pickup['pickup_date'])); ?>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <?php echo ucfirst($pickup['time_slot']); ?>
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        #<?php echo Security::escape($pickup['request_number']); ?>
                                    </p>
                                </div>
                                <div class="flex items-center">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <?php echo ucfirst($pickup['status']); ?>
                                    </span>
                                    <a href="/pickup-details?id=<?php echo $pickup['id']; ?>" class="ml-4 text-gray-400 hover:text-gray-500">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white shadow rounded-lg">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Activity</h3>
                <a href="/pickup-history" class="text-sm text-green-600 hover:text-green-900">View All</a>
            </div>
            <div class="p-6">
                <?php if (empty($recent_pickups)): ?>
                    <div class="text-center py-6">
                        <i class="fas fa-history text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">No past activity found.</p>
                    </div>
                <?php else: ?>
                    <ul class="divide-y divide-gray-200">
                        <?php foreach ($recent_pickups as $pickup): ?>
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <span class="h-10 w-10 rounded-full flex items-center justify-center <?php echo $pickup['status'] == 'completed' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500'; ?>">
                                        <i class="fas fa-recycle"></i>
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        Pickup Request #<?php echo Security::escape($pickup['request_number']); ?>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <?php echo date('M j, Y', strtotime($pickup['pickup_date'])); ?>
                                    </p>
                                </div>
                                <div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo Helpers::getStatusColorClass($pickup['status']); ?>">
                                        <?php echo ucfirst($pickup['status']); ?>
                                    </span>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
