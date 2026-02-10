<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-white shadow-sm rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Schedule Waste Pickup</h1>
                    <p class="mt-1 text-sm text-gray-500">Schedule a convenient time for waste collection from your location</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-leaf mr-1"></i>
                        ZMW 50 per pickup
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Steps -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div id="step1" class="flex items-center">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-medium">1</div>
                        <span class="ml-2 text-sm font-medium text-gray-900">Select Address</span>
                    </div>
                    <div class="w-12 h-0.5 bg-gray-300 mx-4"></div>
                    <div id="step2" class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-medium">2</div>
                        <span class="ml-2 text-sm text-gray-500">Choose Date & Time</span>
                    </div>
                    <div class="w-12 h-0.5 bg-gray-300 mx-4"></div>
                    <div id="step3" class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-medium">3</div>
                        <span class="ml-2 text-sm text-gray-500">Waste Details</span>
                    </div>
                    <div class="w-12 h-0.5 bg-gray-300 mx-4"></div>
                    <div id="step4" class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-medium">4</div>
                        <span class="ml-2 text-sm text-gray-500">Confirm</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Form -->
    <form id="pickupForm" method="POST" action="/schedule-pickup/process">
        <input type="hidden" name="csrf_token" value="<?php echo Security::generateCSRFToken(); ?>">
        
        <!-- Step 1: Address Selection -->
        <div id="addressStep" class="bg-white rounded-lg shadow-sm mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Select Pickup Address</h2>
                <p class="mt-1 text-sm text-gray-500">Choose the address where waste will be collected</p>
            </div>
            <div class="p-6">
                <?php if (!empty($addresses)): ?>
                    <div class="space-y-3">
                        <?php foreach ($addresses as $address): ?>
                            <label class="relative flex items-start p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                <input type="radio" name="address_id" value="<?php echo $address['id']; ?>" class="mt-1 mr-3" required>
                                <div class="ml-3">
                                    <div class="flex items-center">
                                        <span class="font-medium text-gray-900"><?php echo Security::escape($address['address_line_1']); ?></span>
                                        <?php if ($address['is_default']): ?>
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Default</span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($address['address_line_2']): ?>
                                        <p class="text-sm text-gray-600"><?php echo Security::escape($address['address_line_2']); ?></p>
                                    <?php endif; ?>
                                    <p class="text-sm text-gray-500">
                                        <?php echo Security::escape($address['city']); ?>, <?php echo Security::escape($address['district']); ?>, <?php echo Security::escape($address['province']); ?>
                                    </p>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-4">
                        <a href="/profile/addresses" class="text-sm text-green-600 hover:text-green-700 font-medium">
                            <i class="fas fa-plus mr-1"></i> Add New Address
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <i class="fas fa-map-marker-alt text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500 mb-4">No addresses found. Please add an address first.</p>
                        <a href="/profile/addresses" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                            Add Address
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Step 2: Date & Time Selection -->
        <div id="dateTimeStep" class="bg-white rounded-lg shadow-sm mb-6 hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Choose Date & Time</h2>
                <p class="mt-1 text-sm text-gray-500">Select your preferred pickup date and time slot</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Date</label>
                        <input type="date" name="pickup_date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <p class="mt-1 text-xs text-gray-500">Pickups available from tomorrow</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Time Slot</label>
                        <div class="space-y-2">
                            <?php foreach ($time_slots as $slot => $label): ?>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="time_slot" value="<?php echo $slot; ?>" required class="mr-3">
                                    <div>
                                        <span class="font-medium text-gray-900"><?php echo $label; ?></span>
                                        <p class="text-xs text-gray-500"><?php echo $this->getTimeSlotDescription($slot); ?></p>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Waste Details -->
        <div id="wasteStep" class="bg-white rounded-lg shadow-sm mb-6 hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Waste Details</h2>
                <p class="mt-1 text-sm text-gray-500">Tell us about the waste you want to dispose</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <?php foreach ($waste_categories as $category): ?>
                        <div class="border rounded-lg p-4">
                            <label class="flex items-start">
                                <input type="checkbox" name="waste_categories[]" value="<?php echo $category['id']; ?>" 
                                       class="mt-1 mr-3 waste-category-checkbox" data-category="<?php echo $category['slug']; ?>">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <i class="fas fa-<?php echo $category['icon']; ?> text-<?php echo $category['color']; ?> mr-2"></i>
                                        <span class="font-medium text-gray-900"><?php echo Security::escape($category['name']); ?></span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1"><?php echo Security::escape($category['description']); ?></p>
                                </div>
                            </label>
                            <div class="mt-3 pl-6 hidden" id="weight-<?php echo $category['id']; ?>">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Weight (kg)</label>
                                <input type="number" name="weight_<?php echo $category['id']; ?>" min="0.5" step="0.5" placeholder="0.0"
                                       class="w-full md:w-32 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Special Instructions (Optional)</label>
                    <textarea name="special_instructions" rows="3" placeholder="Any special instructions for the pickup team..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                </div>
            </div>
        </div>

        <!-- Step 4: Confirmation -->
        <div id="confirmStep" class="bg-white rounded-lg shadow-sm mb-6 hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Confirm Pickup Details</h2>
                <p class="mt-1 text-sm text-gray-500">Review your pickup request before submission</p>
            </div>
            <div class="p-6">
                <div id="confirmationDetails" class="space-y-4">
                    <!-- Details will be populated by JavaScript -->
                </div>
                
                <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-800">Estimated Cost</p>
                            <p class="text-xs text-green-600">Base fee + per kg charges</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-green-900">ZMW <span id="totalCost">50.00</span></p>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="flex items-start">
                        <input type="checkbox" id="terms" required class="mt-1 mr-3">
                        <label for="terms" class="text-sm text-gray-600">
                            I agree to the <a href="/terms" class="text-green-600 hover:text-green-700">terms and conditions</a> 
                            and understand that the final cost may vary based on actual weight measurement.
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between">
            <button type="button" id="prevBtn" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 hidden">
                <i class="fas fa-arrow-left mr-2"></i> Previous
            </button>
            <button type="button" id="nextBtn" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 ml-auto">
                Next <i class="fas fa-arrow-right ml-2"></i>
            </button>
            <button type="submit" id="submitBtn" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 hidden">
                <i class="fas fa-check mr-2"></i> Schedule Pickup
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 4;
    
    // Waste category checkboxes
    document.querySelectorAll('.waste-category-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const weightDiv = document.getElementById('weight-' + this.value);
            if (weightDiv) {
                weightDiv.classList.toggle('hidden', !this.checked);
                if (this.checked) {
                    weightDiv.querySelector('input').focus();
                }
            }
        });
    });
    
    // Navigation
    document.getElementById('nextBtn').addEventListener('click', nextStep);
    document.getElementById('prevBtn').addEventListener('click', prevStep);
    
    function nextStep() {
        if (validateStep(currentStep)) {
            if (currentStep < totalSteps) {
                document.getElementById('step' + currentStep).querySelector('div').className = 'w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-medium';
                document.getElementById('step' + currentStep).querySelector('span').className = 'ml-2 text-sm font-medium text-green-600';
                
                currentStep++;
                showStep(currentStep);
            }
        }
    }
    
    function prevStep() {
        if (currentStep > 1) {
            document.getElementById('step' + currentStep).querySelector('div').className = 'w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-medium';
            document.getElementById('step' + currentStep).querySelector('span').className = 'ml-2 text-sm text-gray-500';
            
            currentStep--;
            showStep(currentStep);
        }
    }
    
    function showStep(step) {
        // Hide all steps
        document.getElementById('addressStep').classList.add('hidden');
        document.getElementById('dateTimeStep').classList.add('hidden');
        document.getElementById('wasteStep').classList.add('hidden');
        document.getElementById('confirmStep').classList.add('hidden');
        
        // Show current step
        switch(step) {
            case 1:
                document.getElementById('addressStep').classList.remove('hidden');
                break;
            case 2:
                document.getElementById('dateTimeStep').classList.remove('hidden');
                break;
            case 3:
                document.getElementById('wasteStep').classList.remove('hidden');
                break;
            case 4:
                document.getElementById('confirmStep').classList.remove('hidden');
                updateConfirmation();
                break;
        }
        
        // Update buttons
        document.getElementById('prevBtn').classList.toggle('hidden', step === 1);
        document.getElementById('nextBtn').classList.toggle('hidden', step === totalSteps);
        document.getElementById('submitBtn').classList.toggle('hidden', step !== totalSteps);
        
        // Update current step indicator
        document.getElementById('step' + step).querySelector('div').className = 'w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-medium';
        document.getElementById('step' + step).querySelector('span').className = 'ml-2 text-sm font-medium text-green-600';
    }
    
    function validateStep(step) {
        switch(step) {
            case 1:
                const addressSelected = document.querySelector('input[name="address_id"]:checked');
                if (!addressSelected) {
                    alert('Please select a pickup address');
                    return false;
                }
                return true;
            case 2:
                const date = document.querySelector('input[name="pickup_date"]').value;
                const timeSlot = document.querySelector('input[name="time_slot"]:checked');
                if (!date || !timeSlot) {
                    alert('Please select both date and time slot');
                    return false;
                }
                return true;
            case 3:
                const categories = document.querySelectorAll('input[name="waste_categories[]"]:checked');
                if (categories.length === 0) {
                    alert('Please select at least one waste category');
                    return false;
                }
                // Validate weights
                for (let category of categories) {
                    const weightInput = document.querySelector('input[name="weight_' + category.value + '"]');
                    if (weightInput && (!weightInput.value || parseFloat(weightInput.value) <= 0)) {
                        alert('Please enter valid weight for all selected categories');
                        return false;
                    }
                }
                return true;
            case 4:
                const terms = document.getElementById('terms').checked;
                if (!terms) {
                    alert('Please agree to the terms and conditions');
                    return false;
                }
                return true;
            default:
                return true;
        }
    }
    
    function updateConfirmation() {
        const addressId = document.querySelector('input[name="address_id"]:checked').value;
        const address = <?php echo json_encode($addresses); ?>.find(a => a.id == addressId);
        const date = document.querySelector('input[name="pickup_date"]').value;
        const timeSlot = document.querySelector('input[name="time_slot"]:checked');
        const categories = document.querySelectorAll('input[name="waste_categories[]"]:checked');
        
        let html = `
            <div class="space-y-3">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pickup Address</p>
                    <p class="text-gray-900">${address.address_line_1}, ${address.city}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Date & Time</p>
                    <p class="text-gray-900">${new Date(date).toLocaleDateString()} - ${timeSlot.nextElementSibling.querySelector('.font-medium').textContent}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Waste Categories</p>
        `;
        
        let totalWeight = 0;
        categories.forEach(cat => {
            const weight = parseFloat(document.querySelector('input[name="weight_' + cat.value + ']').value) || 0;
            totalWeight += weight;
            const category = <?php echo json_encode($waste_categories); ?>.find(c => c.id == cat.value);
            html += `<p class="text-gray-900">• ${category.name}: ${weight} kg</p>`;
        });
        
        html += `</div></div>`;
        
        document.getElementById('confirmationDetails').innerHTML = html;
        
        // Calculate cost (base 50 + 5 per kg)
        const cost = 50 + (totalWeight * 5);
        document.getElementById('totalCost').textContent = cost.toFixed(2);
    }
});
</script>
