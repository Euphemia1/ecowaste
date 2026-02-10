<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="bg-white shadow-sm rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Pickup History</h1>
                    <p class="mt-1 text-sm text-gray-500">View your past waste collection requests and their status</p>
                </div>
                <div class="flex items-center space-x-3">
                    <button onclick="window.print()" class="px-3 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 text-sm">
                        <i class="fas fa-download mr-2"></i> Export
                    </button>
                    <a href="/schedule-pickup" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                        <i class="fas fa-plus mr-2"></i> Schedule New
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="px-6 py-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div class="flex flex-col sm:flex-row gap-4">
                    <select id="statusFilter" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    
                    <select id="monthFilter" class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">All Time</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    
                    <input type="text" id="searchInput" placeholder="Search by request number..." 
                           class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div class="text-sm text-gray-500">
                    Showing <span id="showingCount"><?php echo count($pickups); ?></span> of <span id="totalCount"><?php echo $total_pickups; ?></span> requests
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-400 text-white rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-list"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Requests</p>
                    <p class="text-xl font-bold text-gray-900"><?php echo $stats['total_requests']; ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Completed</p>
                    <p class="text-xl font-bold text-gray-900"><?php echo $stats['completed_requests']; ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-300 text-white rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-xl font-bold text-gray-900"><?php echo $stats['pending_requests']; ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-weight"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Weight</p>
                    <p class="text-xl font-bold text-gray-900"><?php echo Helpers::formatWeight($stats['total_weight']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pickups Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Request #
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date & Time
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Address
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Waste Types
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Weight
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cost
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="pickupsTableBody">
                    <?php if (!empty($pickups)): ?>
                        <?php foreach ($pickups as $pickup): ?>
                            <tr class="hover:bg-gray-50 pickup-row" 
                                data-status="<?php echo $pickup['status']; ?>"
                                data-month="<?php echo date('n', strtotime($pickup['pickup_date'])); ?>"
                                data-search="<?php echo Security::escape($pickup['request_number']); ?>">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        #<?php echo Security::escape($pickup['request_number']); ?>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        ID: <?php echo $pickup['id']; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <?php echo date('M j, Y', strtotime($pickup['pickup_date'])); ?>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        <?php echo ucfirst($pickup['time_slot']); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate">
                                        <?php echo Security::escape($pickup['address_line_1']); ?>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        <?php echo Security::escape($pickup['district']); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        <?php foreach ($pickup['waste_types'] as $type): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                <?php echo Security::escape($type['name']); ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <?php echo Helpers::formatWeight($pickup['total_weight']); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        ZMW <?php echo number_format($pickup['pickup_fee'], 2); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo Helpers::getStatusColorClass($pickup['status']); ?>">
                                        <?php echo ucfirst(str_replace('_', ' ', $pickup['status'])); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="/pickup-details?id=<?php echo $pickup['id']; ?>" 
                                           class="text-green-600 hover:text-green-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if ($pickup['status'] === 'pending'): ?>
                                            <a href="/pickup-cancel?id=<?php echo $pickup['id']; ?>" 
                                               onclick="return confirm('Are you sure you want to cancel this pickup?')"
                                               class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($pickup['status'] === 'completed'): ?>
                                            <button onclick="ratePickup(<?php echo $pickup['id']; ?>)" 
                                                    class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                                <p class="text-gray-500 text-lg">No pickup requests found</p>
                                <p class="text-gray-400 text-sm mt-2">Schedule your first pickup to get started</p>
                                <a href="/schedule-pickup" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                    <i class="fas fa-plus mr-2"></i> Schedule Pickup
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Showing <?php echo ($current_page - 1) * $per_page + 1; ?> to 
                        <?php echo min($current_page * $per_page, $total_pickups); ?> of 
                        <?php echo $total_pickups; ?> results
                    </div>
                    <div class="flex items-center space-x-2">
                        <?php if ($current_page > 1): ?>
                            <a href="?page=<?php echo $current_page - 1; ?>" 
                               class="px-3 py-1 border border-gray-300 text-gray-500 rounded hover:bg-gray-50">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
                            <a href="?page=<?php echo $i; ?>" 
                               class="px-3 py-1 border rounded <?php echo $i == $current_page ? 'bg-green-600 text-white border-green-600' : 'border-gray-300 text-gray-500 hover:bg-gray-50'; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($current_page < $total_pages): ?>
                            <a href="?page=<?php echo $current_page + 1; ?>" 
                               class="px-3 py-1 border border-gray-300 text-gray-500 rounded hover:bg-gray-50">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Rating Modal -->
<div id="ratingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Rate Pickup Service</h3>
            <div class="mt-2 px-7 py-3">
                <div class="flex justify-center space-x-2 mb-4">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <button type="button" onclick="setRating(<?php echo $i; ?>)" 
                                class="star-btn text-3xl text-gray-300 hover:text-green-500 transition-colors">
                            <i class="fas fa-star"></i>
                        </button>
                    <?php endfor; ?>
                </div>
                <textarea id="ratingComment" rows="3" placeholder="Share your experience (optional)..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
            </div>
            <div class="items-center px-4 py-3">
                <button onclick="submitRating()" class="px-4 py-2 bg-green-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Submit Rating
                </button>
                <button onclick="closeRatingModal()" class="mt-3 px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentRating = 0;
let currentPickupId = null;

document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    document.getElementById('statusFilter').addEventListener('change', filterPickups);
    document.getElementById('monthFilter').addEventListener('change', filterPickups);
    document.getElementById('searchInput').addEventListener('input', filterPickups);
});

function filterPickups() {
    const statusFilter = document.getElementById('statusFilter').value;
    const monthFilter = document.getElementById('monthFilter').value;
    const searchFilter = document.getElementById('searchInput').value.toLowerCase();
    
    const rows = document.querySelectorAll('.pickup-row');
    let visibleCount = 0;
    
    rows.forEach(row => {
        let show = true;
        
        if (statusFilter && row.dataset.status !== statusFilter) {
            show = false;
        }
        
        if (monthFilter && row.dataset.month !== monthFilter) {
            show = false;
        }
        
        if (searchFilter && !row.dataset.search.includes(searchFilter)) {
            show = false;
        }
        
        row.style.display = show ? '' : 'none';
        if (show) visibleCount++;
    });
    
    document.getElementById('showingCount').textContent = visibleCount;
}

function ratePickup(pickupId) {
    currentPickupId = pickupId;
    currentRating = 0;
    document.getElementById('ratingModal').classList.remove('hidden');
    document.getElementById('ratingComment').value = '';
    updateStarDisplay();
}

function setRating(rating) {
    currentRating = rating;
    updateStarDisplay();
}

function updateStarDisplay() {
    const stars = document.querySelectorAll('.star-btn');
    stars.forEach((star, index) => {
        if (index < currentRating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-green-500');
        } else {
            star.classList.remove('text-green-500');
            star.classList.add('text-gray-300');
        }
    });
}

function submitRating() {
    if (currentRating === 0) {
        alert('Please select a rating');
        return;
    }
    
    const comment = document.getElementById('ratingComment').value;
    
    // Submit rating via AJAX
    fetch('/pickup-rate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            pickup_id: currentPickupId,
            rating: currentRating,
            comment: comment
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeRatingModal();
            alert('Thank you for your feedback!');
        } else {
            alert('Error submitting rating. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error submitting rating. Please try again.');
    });
}

function closeRatingModal() {
    document.getElementById('ratingModal').classList.add('hidden');
    currentPickupId = null;
    currentRating = 0;
}
</script>
