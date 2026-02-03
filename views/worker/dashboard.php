<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-white shadow-sm rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Worker Dashboard</h1>
                    <p class="mt-1 text-sm text-gray-500">Manage your pickups and track your earnings</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-3">
                            <i class="fas fa-circle text-green-500 mr-1"></i>
                            Online
                        </span>
                        <button onclick="toggleAvailability()" id="availabilityBtn" 
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                            <i class="fas fa-toggle-on mr-2"></i> Available
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Today's Pickups -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Today's Pickups</p>
                    <p class="text-3xl font-bold mt-2"><?php echo $stats['today_pickups']; ?></p>
                    <p class="text-blue-100 text-sm mt-2">
                        <?php echo $stats['today_completed']; ?> completed
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-calendar-day text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Weekly Earnings -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Weekly Earnings</p>
                    <p class="text-3xl font-bold mt-2">ZMW <?php echo number_format($stats['weekly_earnings'], 0); ?></p>
                    <p class="text-green-100 text-sm mt-2">
                        <?php echo $stats['weekly_pickups']; ?> pickups
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Rating -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Average Rating</p>
                    <p class="text-3xl font-bold mt-2"><?php echo number_format($stats['average_rating'], 1); ?></p>
                    <p class="text-yellow-100 text-sm mt-2">
                        <?php echo $stats['total_ratings']; ?> ratings
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-star text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Pickups -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Pickups</p>
                    <p class="text-3xl font-bold mt-2"><?php echo $stats['total_pickups']; ?></p>
                    <p class="text-purple-100 text-sm mt-2">
                        All time
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-truck text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Available Pickups -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-medium text-gray-900">Available Pickups</h2>
                        <div class="flex items-center space-x-2">
                            <select id="pickupFilter" class="px-3 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="all">All Areas</option>
                                <option value="nearby">Nearby Only</option>
                                <option value="high_priority">High Priority</option>
                            </select>
                            <button onclick="refreshPickups()" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="divide-y divide-gray-200" id="pickupsList">
                    <?php if (!empty($available_pickups)): ?>
                        <?php foreach ($available_pickups as $pickup): ?>
                            <div class="p-6 hover:bg-gray-50 pickup-item" 
                                 data-priority="<?php echo $pickup['priority']; ?>"
                                 data-distance="<?php echo $pickup['distance_km']; ?>">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center">
                                            <h3 class="text-lg font-medium text-gray-900">
                                                #<?php echo Security::escape($pickup['request_number']); ?>
                                            </h3>
                                            <?php if ($pickup['priority'] === 'high'): ?>
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    High Priority
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    <?php echo date('l, M j, Y', strtotime($pickup['pickup_date'])); ?>
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    <?php echo ucfirst($pickup['time_slot']); ?>
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                                    <?php echo Security::escape($pickup['district']); ?> (<?php echo $pickup['distance_km']; ?> km)
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    <i class="fas fa-weight mr-1"></i>
                                                    Est. <?php echo Helpers::formatWeight($pickup['estimated_weight']); ?>
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <i class="fas fa-money-bill mr-1"></i>
                                                    ZMW <?php echo number_format($pickup['estimated_earnings'], 2); ?>
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <i class="fas fa-recycle mr-1"></i>
                                                    <?php echo count($pickup['waste_types']); ?> types
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <?php if ($pickup['special_instructions']): ?>
                                            <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                                                <p class="text-sm text-yellow-800">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    <?php echo Security::escape($pickup['special_instructions']); ?>
                                                </p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="ml-4 flex flex-col space-y-2">
                                        <button onclick="acceptPickup(<?php echo $pickup['id']; ?>)" 
                                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                                            <i class="fas fa-check mr-2"></i> Accept
                                        </button>
                                        <button onclick="viewPickupDetails(<?php echo $pickup['id']; ?>)" 
                                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 text-sm">
                                            <i class="fas fa-eye mr-2"></i> Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-12 text-center">
                            <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500 text-lg">No available pickups</p>
                            <p class="text-gray-400 text-sm mt-2">Check back later for new pickup requests</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Current Pickup -->
            <?php if ($current_pickup): ?>
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Current Pickup</h2>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-4">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-truck-loading text-green-600 text-2xl"></i>
                            </div>
                            <h3 class="font-medium text-gray-900">#<?php echo Security::escape($current_pickup['request_number']); ?></h3>
                            <p class="text-sm text-gray-500"><?php echo Security::escape($current_pickup['district']); ?></p>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Status</span>
                                <span class="text-sm font-medium text-green-600">In Progress</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Started</span>
                                <span class="text-sm font-medium"><?php echo Helpers::formatTimeAgo($current_pickup['started_at']); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Est. Weight</span>
                                <span class="text-sm font-medium"><?php echo Helpers::formatWeight($current_pickup['estimated_weight']); ?></span>
                            </div>
                        </div>
                        
                        <div class="mt-6 space-y-2">
                            <button onclick="navigateToPickup()" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                <i class="fas fa-directions mr-2"></i> Navigate
                            </button>
                            <button onclick="contactCustomer()" class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 text-sm">
                                <i class="fas fa-phone mr-2"></i> Contact Customer
                            </button>
                            <button onclick="completePickup()" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                                <i class="fas fa-check mr-2"></i> Complete Pickup
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Today's Schedule -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Today's Schedule</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <?php if (!empty($today_schedule)): ?>
                            <?php foreach ($today_schedule as $scheduled): ?>
                                <div class="flex items-center justify-between p-3 border rounded-lg <?php echo $scheduled['status'] === 'completed' ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200'; ?>">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">#<?php echo Security::escape($scheduled['request_number']); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo ucfirst($scheduled['time_slot']); ?> - <?php echo Security::escape($scheduled['district']); ?></p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo Helpers::getStatusColorClass($scheduled['status']); ?>">
                                            <?php echo ucfirst($scheduled['status']); ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-sm text-gray-500 text-center">No pickups scheduled for today</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Earnings Summary -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Earnings Summary</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Today</span>
                            <span class="text-sm font-medium text-gray-900">ZMW <?php echo number_format($earnings['today'], 0); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">This Week</span>
                            <span class="text-sm font-medium text-gray-900">ZMW <?php echo number_format($earnings['week'], 0); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">This Month</span>
                            <span class="text-sm font-medium text-gray-900">ZMW <?php echo number_format($earnings['month'], 0); ?></span>
                        </div>
                        <div class="pt-3 border-t border-gray-200">
                            <div class="flex justify-between">
                                <span class="text-base font-medium text-gray-900">Pending Payout</span>
                                <span class="text-base font-bold text-green-600">ZMW <?php echo number_format($earnings['pending'], 0); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <a href="/worker/earnings" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-chart-line mr-2"></i> View Detailed Earnings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pickup Details Modal -->
<div id="pickupDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Pickup Details</h3>
            <button onclick="closePickupDetails()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="pickupDetailsContent">
            <!-- Content will be loaded via JavaScript -->
        </div>
    </div>
</div>

<!-- Complete Pickup Modal -->
<div id="completePickupModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Complete Pickup</h3>
            <div class="mt-2 px-7 py-3">
                <form id="completePickupForm">
                    <input type="hidden" name="pickup_id" id="completePickupId">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Actual Weight (kg)</label>
                            <input type="number" name="actual_weight" step="0.5" min="0" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                            <textarea name="completion_notes" rows="3" placeholder="Any issues or special notes..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Photos (Optional)</label>
                            <input type="file" name="photos[]" multiple accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <p class="mt-1 text-xs text-gray-500">Take photos of the collected waste</p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="items-center px-4 py-3">
                <button onclick="submitCompletion()" class="px-4 py-2 bg-green-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <i class="fas fa-check mr-2"></i> Complete Pickup
                </button>
                <button onclick="closeCompleteModal()" class="mt-3 px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter pickups
    document.getElementById('pickupFilter').addEventListener('change', filterPickups);
    
    // Auto-refresh pickups every 30 seconds
    setInterval(refreshPickups, 30000);
});

function toggleAvailability() {
    const btn = document.getElementById('availabilityBtn');
    const isAvailable = btn.classList.contains('bg-green-600');
    
    fetch('/worker/toggle-availability', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            available: !isAvailable,
            csrf_token: '<?php echo Security::generateCSRFToken(); ?>'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (isAvailable) {
                btn.classList.remove('bg-green-600', 'hover:bg-green-700');
                btn.classList.add('bg-gray-600', 'hover:bg-gray-700');
                btn.innerHTML = '<i class="fas fa-toggle-off mr-2"></i> Offline';
            } else {
                btn.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                btn.classList.add('bg-green-600', 'hover:bg-green-700');
                btn.innerHTML = '<i class="fas fa-toggle-on mr-2"></i> Available';
            }
        }
    });
}

function filterPickups() {
    const filter = document.getElementById('pickupFilter').value;
    const items = document.querySelectorAll('.pickup-item');
    
    items.forEach(item => {
        let show = true;
        
        if (filter === 'nearby') {
            show = parseFloat(item.dataset.distance) <= 5;
        } else if (filter === 'high_priority') {
            show = item.dataset.priority === 'high';
        }
        
        item.style.display = show ? '' : 'none';
    });
}

function refreshPickups() {
    fetch('/worker/available-pickups')
        .then(response => response.json())
        .then(data => {
            if (data.pickups) {
                // Update pickups list
                location.reload();
            }
        });
}

function acceptPickup(pickupId) {
    if (confirm('Are you sure you want to accept this pickup?')) {
        fetch('/worker/accept-pickup', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                pickup_id: pickupId,
                csrf_token: '<?php echo Security::generateCSRFToken(); ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pickup accepted successfully!');
                location.reload();
            } else {
                alert(data.message || 'Error accepting pickup.');
            }
        });
    }
}

function viewPickupDetails(pickupId) {
    fetch('/worker/pickup-details?id=' + pickupId)
        .then(response => response.text())
        .then(html => {
            document.getElementById('pickupDetailsContent').innerHTML = html;
            document.getElementById('pickupDetailsModal').classList.remove('hidden');
        });
}

function closePickupDetails() {
    document.getElementById('pickupDetailsModal').classList.add('hidden');
}

function navigateToPickup() {
    // Open navigation app
    if (<?php echo $current_pickup ? 'true' : 'false'; ?>) {
        const address = '<?php echo $current_pickup ? addslashes($current_pickup['address_line_1'] . ', ' . $current_pickup['district']) : ''; ?>';
        window.open(`https://maps.google.com/?q=${encodeURIComponent(address)}`, '_blank');
    }
}

function contactCustomer() {
    if (<?php echo $current_pickup ? 'true' : 'false'; ?>) {
        const phone = '<?php echo $current_pickup ? $current_pickup['customer_phone'] : ''; ?>';
        window.open(`tel:${phone}`, '_self');
    }
}

function completePickup() {
    document.getElementById('completePickupId').value = <?php echo $current_pickup ? $current_pickup['id'] : '0'; ?>;
    document.getElementById('completePickupModal').classList.remove('hidden');
}

function closeCompleteModal() {
    document.getElementById('completePickupModal').classList.add('hidden');
    document.getElementById('completePickupForm').reset();
}

function submitCompletion() {
    const form = document.getElementById('completePickupForm');
    const formData = new FormData(form);
    
    fetch('/worker/complete-pickup', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeCompleteModal();
            alert('Pickup completed successfully!');
            location.reload();
        } else {
            alert(data.message || 'Error completing pickup.');
        }
    });
}
</script>
