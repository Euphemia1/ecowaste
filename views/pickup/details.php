<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-white shadow-sm rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="/pickup-history" class="text-gray-500 hover:text-gray-700 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Pickup Details</h1>
                        <p class="mt-1 text-sm text-gray-500">Request #<?php echo Security::escape($pickup['request_number']); ?></p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <?php if ($pickup['status'] === 'pending'): ?>
                        <a href="/pickup-cancel?id=<?php echo $pickup['id']; ?>" 
                           onclick="return confirm('Are you sure you want to cancel this pickup?')"
                           class="px-4 py-2 border border-red-300 text-red-700 rounded-md hover:bg-red-50 text-sm">
                            <i class="fas fa-times mr-2"></i> Cancel
                        </a>
                    <?php endif; ?>
                    <?php if ($pickup['status'] === 'completed' && !$pickup['rated']): ?>
                        <button onclick="ratePickup()" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 text-sm">
                            <i class="fas fa-star mr-2"></i> Rate Service
                        </button>
                    <?php endif; ?>
                    <button onclick="window.print()" class="px-3 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 text-sm">
                        <i class="fas fa-download mr-2"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Banner -->
    <div class="bg-<?php echo Helpers::getStatusColor($pickup['status']); ?>-50 border-l-4 border-<?php echo Helpers::getStatusColor($pickup['status']); ?>-400 p-4 mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-<?php echo Helpers::getStatusIcon($pickup['status']); ?> text-<?php echo Helpers::getStatusColor($pickup['status']); ?> text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-<?php echo Helpers::getStatusColor($pickup['status']); ?>-800">
                    Status: <?php echo ucfirst(str_replace('_', ' ', $pickup['status'])); ?>
                </p>
                <p class="text-sm text-<?php echo Helpers::getStatusColor($pickup['status']); ?>-600 mt-1">
                    <?php echo Helpers::getStatusMessage($pickup['status']); ?>
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Pickup Information -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Pickup Information</h2>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Request Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">#<?php echo Security::escape($pickup['request_number']); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Pickup Date</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?php echo date('l, F j, Y', strtotime($pickup['pickup_date'])); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Time Slot</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?php echo ucfirst($pickup['time_slot']); ?> (<?php echo Helpers::getTimeSlotRange($pickup['time_slot']); ?>)</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Requested On</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?php echo date('F j, Y \a\t g:i A', strtotime($pickup['created_at'])); ?></dd>
                        </div>
                    </dl>
                    
                    <?php if ($pickup['special_instructions']): ?>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <dt class="text-sm font-medium text-gray-500">Special Instructions</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?php echo Security::escape($pickup['special_instructions']); ?></dd>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Address Information -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Pickup Address</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-green-600 text-xl mt-1"></i>
                        </div>
                        <div class="ml-3">
                            <div class="text-gray-900">
                                <p class="font-medium"><?php echo Security::escape($pickup['address_line_1']); ?></p>
                                <?php if ($pickup['address_line_2']): ?>
                                    <p><?php echo Security::escape($pickup['address_line_2']); ?></p>
                                <?php endif; ?>
                                <p class="text-gray-600 mt-1">
                                    <?php echo Security::escape($pickup['district']); ?>, <?php echo Security::escape($pickup['city']); ?><br>
                                    <?php echo Security::escape($pickup['province']); ?>, <?php echo Security::escape($pickup['country']); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Waste Details -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Waste Details</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <?php foreach ($pickup['items'] as $item): ?>
                            <div class="flex items-center justify-between p-4 border rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-<?php echo $item['icon']; ?> text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900"><?php echo Security::escape($item['name']); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo Security::escape($item['description']); ?></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900"><?php echo Helpers::formatWeight($item['estimated_weight']); ?></p>
                                    <?php if ($item['actual_weight'] > 0): ?>
                                        <p class="text-sm text-green-600">Actual: <?php echo Helpers::formatWeight($item['actual_weight']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-medium text-gray-900">Total Weight</span>
                            <span class="text-lg font-bold text-green-600">
                                <?php echo Helpers::formatWeight($pickup['total_weight']); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Activity Timeline</h2>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <?php foreach ($timeline as $event): ?>
                                <li>
                                    <div class="relative pb-8">
                                        <?php if (!$event['last']): ?>
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        <?php endif; ?>
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center ring-8 ring-white">
                                                    <i class="fas fa-<?php echo $event['icon']; ?> text-green-600 text-sm"></i>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-900"><?php echo Security::escape($event['title']); ?></p>
                                                    <p class="text-sm text-gray-500"><?php echo Security::escape($event['description']); ?></p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <?php echo Helpers::formatTimeAgo($event['timestamp']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Cost Summary -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Cost Summary</h2>
                </div>
                <div class="p-6">
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Base Fee</dt>
                            <dd class="text-sm font-medium text-gray-900">ZMW 50.00</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Weight Charges</dt>
                            <dd class="text-sm font-medium text-gray-900">
                                ZMW <?php echo number_format($pickup['weight_charges'], 2); ?>
                            </dd>
                        </div>
                        <?php if ($pickup['discount'] > 0): ?>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Discount</dt>
                                <dd class="text-sm font-medium text-green-600">
                                    -ZMW <?php echo number_format($pickup['discount'], 2); ?>
                                </dd>
                            </div>
                        <?php endif; ?>
                        <div class="pt-3 border-t border-gray-200">
                            <div class="flex justify-between">
                                <dt class="text-base font-medium text-gray-900">Total Cost</dt>
                                <dd class="text-base font-bold text-green-600">
                                    ZMW <?php echo number_format($pickup['pickup_fee'], 2); ?>
                                </dd>
                            </div>
                        </div>
                    </dl>
                    
                    <?php if ($pickup['payment_status'] === 'paid'): ?>
                        <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-md">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                <span class="text-sm text-green-800">Paid via <?php echo ucfirst($pickup['payment_method']); ?></span>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="mt-4">
                            <a href="/payment?pickup=<?php echo $pickup['id']; ?>" 
                               class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                <i class="fas fa-credit-card mr-2"></i> Pay Now
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Environmental Impact -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Environmental Impact</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-cloud text-green-500"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">CO₂ Reduced</p>
                                <p class="text-lg font-bold text-gray-900"><?php echo number_format($pickup['co2_saved'], 1); ?> kg</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-tree text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Trees Saved</p>
                                <p class="text-lg font-bold text-gray-900"><?php echo number_format($pickup['trees_saved'], 1); ?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-200 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-tint text-green-700"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Water Saved</p>
                                <p class="text-lg font-bold text-gray-900"><?php echo number_format($pickup['water_saved'], 0); ?> L</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Actions</h2>
                </div>
                <div class="p-6 space-y-3">
                    <a href="/schedule-pickup" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        <i class="fas fa-plus mr-2"></i> Schedule Another Pickup
                    </a>
                    
                    <a href="/support?pickup=<?php echo $pickup['id']; ?>" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-headset mr-2"></i> Contact Support
                    </a>
                    
                    <button onclick="sharePickup()" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-share mr-2"></i> Share Details
                    </button>
                </div>
            </div>
        </div>
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

function ratePickup() {
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
            pickup_id: <?php echo $pickup['id']; ?>,
            rating: currentRating,
            comment: comment
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeRatingModal();
            location.reload();
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
    currentRating = 0;
}

function sharePickup() {
    const url = window.location.href;
    const text = `Check out my EcoWaste pickup #<?php echo $pickup['request_number']; ?>! I recycled <?php echo Helpers::formatWeight($pickup['total_weight']); ?> and saved <?php echo number_format($pickup['co2_saved'], 1); ?> kg of CO₂.`;
    
    if (navigator.share) {
        navigator.share({
            title: 'EcoWaste Pickup',
            text: text,
            url: url
        });
    } else {
        // Fallback - copy to clipboard
        const dummy = document.createElement('textarea');
        document.body.appendChild(dummy);
        dummy.value = text + ' ' + url;
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);
        alert('Details copied to clipboard!');
    }
}
</script>
