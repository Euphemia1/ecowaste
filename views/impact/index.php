<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-white shadow-sm rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Environmental Impact</h1>
                    <p class="mt-1 text-sm text-gray-500">Track your contribution to a cleaner Lusaka</p>
                </div>
                <div class="flex items-center space-x-3">
                    <select id="periodFilter" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="month">This Month</option>
                        <option value="quarter">This Quarter</option>
                        <option value="year">This Year</option>
                        <option value="all">All Time</option>
                    </select>
                    <button onclick="window.print()" class="px-3 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 text-sm">
                        <i class="fas fa-download mr-2"></i> Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Impact Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Waste Recycled -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Recycled</p>
                    <p class="text-3xl font-bold mt-2"><?php echo Helpers::formatWeight($impact_data['total_weight']); ?></p>
                    <p class="text-green-100 text-sm mt-2">
                        <span class="text-green-200">+<?php echo Helpers::formatWeight($impact_data['month_weight']); ?></span> this month
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-recycle text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- CO2 Saved -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">CO₂ Reduced</p>
                    <p class="text-3xl font-bold mt-2"><?php echo number_format($impact_data['total_co2_saved'], 1); ?> kg</p>
                    <p class="text-blue-100 text-sm mt-2">
                        <span class="text-blue-200">+<?php echo number_format($impact_data['month_co2_saved'], 1); ?> kg</span> this month
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-cloud text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Trees Saved -->
        <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Trees Saved</p>
                    <p class="text-3xl font-bold mt-2"><?php echo number_format($impact_data['total_trees_saved'], 0); ?></p>
                    <p class="text-green-100 text-sm mt-2">
                        <span class="text-green-200">+<?php echo number_format($impact_data['month_trees_saved'], 0); ?></span> this month
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-tree text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Recycling Rate -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Recycling Rate</p>
                    <p class="text-3xl font-bold mt-2"><?php echo number_format($impact_data['recycling_rate'], 0); ?>%</p>
                    <p class="text-purple-100 text-sm mt-2">
                        <span class="text-purple-200"><?php echo $impact_data['recycling_rate'] >= 70 ? 'Excellent' : ($impact_data['recycling_rate'] >= 50 ? 'Good' : 'Improving'); ?></span>
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Monthly Progress Chart -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Monthly Recycling Progress</h2>
                <p class="mt-1 text-sm text-gray-500">Your recycling activity over the past 6 months</p>
            </div>
            <div class="p-6">
                <canvas id="monthlyChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Waste Composition Chart -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Waste Composition</h2>
                <p class="mt-1 text-sm text-gray-500">Breakdown of waste types you've recycled</p>
            </div>
            <div class="p-6">
                <canvas id="compositionChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Detailed Impact Breakdown -->
    <div class="bg-white rounded-lg shadow-sm mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Environmental Impact Breakdown</h2>
            <p class="mt-1 text-sm text-gray-500">How your recycling efforts are making a difference</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Water Saved -->
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-500 text-white rounded-full mb-3">
                        <i class="fas fa-tint"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Water Conserved</h3>
                    <p class="text-2xl font-bold text-blue-600"><?php echo number_format($impact_data['water_saved'], 0); ?> liters</p>
                    <p class="text-sm text-gray-600 mt-2">Enough for <?php echo number_format($impact_data['water_saved'] / 200, 0); ?> people for a day</p>
                </div>

                <!-- Energy Saved -->
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-yellow-500 text-white rounded-full mb-3">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Energy Saved</h3>
                    <p class="text-2xl font-bold text-yellow-600"><?php echo number_format($impact_data['energy_saved'], 0); ?> kWh</p>
                    <p class="text-sm text-gray-600 mt-2">Power for <?php echo number_format($impact_data['energy_saved'] / 10, 0); ?> homes for a month</p>
                </div>

                <!-- Landfill Space -->
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-green-500 text-white rounded-full mb-3">
                        <i class="fas fa-mountain"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Landfill Space Saved</h3>
                    <p class="text-2xl font-bold text-green-600"><?php echo number_format($impact_data['landfill_saved'], 2); ?> m³</p>
                    <p class="text-sm text-gray-600 mt-2">Equivalent to <?php echo number_format($impact_data['landfill_saved'] * 0.5, 0); ?> pickup trucks</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Achievements & Milestones -->
    <div class="bg-white rounded-lg shadow-sm mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Achievements & Milestones</h2>
            <p class="mt-1 text-sm text-gray-500">Your environmental milestones and badges</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <?php foreach ($achievements as $achievement): ?>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 <?php echo $achievement['unlocked'] ? 'bg-yellow-400' : 'bg-gray-300'; ?> rounded-full mb-2">
                            <i class="fas fa-<?php echo $achievement['icon']; ?> text-white text-xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900"><?php echo Security::escape($achievement['title']); ?></h4>
                        <p class="text-xs text-gray-500"><?php echo Security::escape($achievement['description']); ?></p>
                        <?php if ($achievement['unlocked']): ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mt-1">
                                <i class="fas fa-check mr-1"></i> Earned
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Comparison with Community -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Community Comparison</h2>
            <p class="mt-1 text-sm text-gray-500">How you compare to other EcoWaste users in Lusaka</p>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <!-- Your Ranking -->
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center font-bold mr-3">
                            <?php echo $community_stats['user_rank']; ?>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Your Ranking</p>
                            <p class="text-sm text-gray-500">Out of <?php echo number_format($community_stats['total_users']); ?> users</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-green-600">Top <?php echo round(($community_stats['user_rank'] / $community_stats['total_users']) * 100, 1); ?>%</p>
                    </div>
                </div>

                <!-- Average Comparison -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 border rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Your Monthly Average</p>
                        <p class="text-xl font-bold text-green-600"><?php echo Helpers::formatWeight($community_stats['user_monthly_avg']); ?></p>
                    </div>
                    <div class="text-center p-4 border rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Community Average</p>
                        <p class="text-xl font-bold text-gray-600"><?php echo Helpers::formatWeight($community_stats['community_monthly_avg']); ?></p>
                    </div>
                    <div class="text-center p-4 border rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Top Performer</p>
                        <p class="text-xl font-bold text-yellow-600"><?php echo Helpers::formatWeight($community_stats['top_performer']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Progress Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($monthly_data['labels']); ?>,
            datasets: [{
                label: 'Weight Recycled (kg)',
                data: <?php echo json_encode($monthly_data['weights']); ?>,
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Waste Composition Chart
    const compositionCtx = document.getElementById('compositionChart').getContext('2d');
    new Chart(compositionCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode(array_keys($composition_data)); ?>,
            datasets: [{
                data: <?php echo json_encode(array_values($composition_data)); ?>,
                backgroundColor: [
                    '#22c55e',
                    '#3b82f6',
                    '#84cc16',
                    '#ef4444',
                    '#6366f1',
                    '#f59e0b'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Period Filter
    document.getElementById('periodFilter').addEventListener('change', function() {
        // Reload page with new period
        window.location.href = '/impact?period=' + this.value;
    });
});
</script>
