<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header with Glass Effect -->
    <div class="relative overflow-hidden bg-white/80 backdrop-blur-md border border-white shadow-xl rounded-2xl p-8 mb-8">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-green-100 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute -left-16 -bottom-16 w-64 h-64 bg-green-50 rounded-full opacity-30 blur-3xl"></div>
        
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Schedule Your Pickup</h1>
                <p class="text-gray-600 max-w-lg">Transforming Zambia's waste management. Book your collection in four easy steps.</p>
            </div>
            <div class="flex-shrink-0">
                <div class="inline-flex items-center px-5 py-3 rounded-2xl bg-green-600 shadow-lg shadow-green-200 text-white transform hover:scale-105 transition-all">
                    <div class="mr-3 p-2 bg-white/20 rounded-xl">
                        <i class="fas fa-coins text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold opacity-80 tracking-widest leading-none mb-1">Base Price</p>
                        <p class="text-xl font-black leading-none">ZMW 50.00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Stepper -->
    <div class="px-4 mb-12">
        <div class="relative flex justify-between items-center max-w-2xl mx-auto">
            <!-- Progress Line Background -->
            <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-100 -translate-y-1/2 rounded-full overflow-hidden">
                <div id="progressBar" class="h-full bg-green-500 transition-all duration-500 ease-out" style="width: 12.5%"></div>
            </div>
            
            <!-- Step 1 -->
            <div id="step1" class="relative z-10 text-center group cursor-pointer" onclick="goToStep(1)">
                <div class="w-12 h-12 bg-green-600 text-white rounded-2xl shadow-lg shadow-green-100 flex items-center justify-center text-lg font-black transform group-hover:scale-110 transition-all duration-300">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <p class="absolute top-14 left-1/2 -translate-x-1/2 whitespace-nowrap text-xs font-bold text-green-600 uppercase tracking-wider">Address</p>
            </div>

            <!-- Step 2 -->
            <div id="step2" class="relative z-10 text-center group opacity-40 grayscale pointer-events-none transition-all duration-500" onclick="goToStep(2)">
                <div class="w-12 h-12 bg-white text-gray-400 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center text-lg font-black group-hover:scale-110 transition-all duration-300">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <p class="absolute top-14 left-1/2 -translate-x-1/2 whitespace-nowrap text-xs font-bold text-gray-400 uppercase tracking-wider">Time Slot</p>
            </div>

            <!-- Step 3 -->
            <div id="step3" class="relative z-10 text-center group opacity-40 grayscale pointer-events-none transition-all duration-500" onclick="goToStep(3)">
                <div class="w-12 h-12 bg-white text-gray-400 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center text-lg font-black group-hover:scale-110 transition-all duration-300">
                    <i class="fas fa-recycle"></i>
                </div>
                <p class="absolute top-14 left-1/2 -translate-x-1/2 whitespace-nowrap text-xs font-bold text-gray-400 uppercase tracking-wider">Details</p>
            </div>

            <!-- Step 4 -->
            <div id="step4" class="relative z-10 text-center group opacity-40 grayscale pointer-events-none transition-all duration-500" onclick="goToStep(4)">
                <div class="w-12 h-12 bg-white text-gray-400 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center text-lg font-black group-hover:scale-110 transition-all duration-300">
                    <i class="fas fa-check-double"></i>
                </div>
                <p class="absolute top-14 left-1/2 -translate-x-1/2 whitespace-nowrap text-xs font-bold text-gray-400 uppercase tracking-wider">Review</p>
            </div>
        </div>
    </div>

    <!-- Schedule Form -->
    <form id="pickupForm" method="POST" action="/schedule-pickup/process">
        <input type="hidden" name="csrf_token" value="<?php echo Security::generateCSRFToken(); ?>">
        
        <!-- Step 1: Address Selection -->
        <div id="addressStep" class="bg-white rounded-2xl shadow-xl overflow-hidden animate-slide-up">
            <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                <h2 class="text-xl font-black text-gray-900">Select Pickup Address</h2>
                <p class="mt-1 text-sm text-gray-500">Where should we collect your waste?</p>
            </div>
            <div class="p-8">
                <?php if (!empty($addresses)): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach ($addresses as $address): ?>
                            <label class="group relative flex flex-col p-6 rounded-2xl border-2 border-gray-100 hover:border-green-400 hover:bg-green-50/30 transition-all cursor-pointer">
                                <input type="radio" name="address_id" value="<?php echo $address['id']; ?>" class="absolute top-4 right-4 w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500" required>
                                
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 rounded-xl bg-gray-100 group-hover:bg-green-100 text-gray-400 group-hover:text-green-600 flex items-center justify-center transition-colors">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <?php if ($address['is_default']): ?>
                                        <span class="ml-auto inline-flex items-center px-2 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-green-100 text-green-700">Default</span>
                                    <?php endif; ?>
                                </div>
                                
                                <div>
                                    <p class="font-bold text-gray-900"><?php echo Security::escape($address['address_line_1']); ?></p>
                                    <?php if ($address['address_line_2']): ?>
                                        <p class="text-sm text-gray-600 truncate"><?php echo Security::escape($address['address_line_2']); ?></p>
                                    <?php endif; ?>
                                    <p class="text-sm text-gray-500 mt-2">
                                        <?php echo Security::escape($address['city']); ?>, <?php echo Security::escape($address['province']); ?>
                                    </p>
                                </div>
                            </label>
                        <?php endforeach; ?>
                        
                        <!-- Add Address Card -->
                        <a href="/profile/addresses" class="flex flex-col items-center justify-center p-6 rounded-2xl border-2 border-dashed border-gray-200 hover:border-green-300 hover:bg-green-50 group transition-all">
                            <div class="w-12 h-12 rounded-full bg-gray-50 group-hover:bg-green-100 text-gray-300 group-hover:text-green-500 flex items-center justify-center mb-3 transition-colors">
                                <i class="fas fa-plus text-xl"></i>
                            </div>
                            <span class="font-bold text-gray-400 group-hover:text-green-600 transition-colors">New Address</span>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12 px-4">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-map-marked-alt text-gray-200 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">No Address Found</h3>
                        <p class="text-gray-500 mb-8 max-w-xs mx-auto">You'll need to add a pickup location to your profile first.</p>
                        <a href="/profile/addresses" class="inline-flex items-center px-8 py-3 bg-green-600 text-white font-black rounded-2xl shadow-lg shadow-green-100 hover:bg-green-700 hover:scale-105 transition-all">
                            Add Address
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Step 2: Date & Time Selection -->
        <div id="dateTimeStep" class="bg-white rounded-2xl shadow-xl overflow-hidden hidden animate-slide-up">
            <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                <h2 class="text-xl font-black text-gray-900">Choose Date & Time</h2>
                <p class="mt-1 text-sm text-gray-500">When should our green team arrive?</p>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <label class="block text-sm font-black text-gray-400 uppercase tracking-widest">Select Date</label>
                        <div class="relative">
                            <input type="date" name="pickup_date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required
                                   class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent border-gray-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all font-bold text-gray-900">
                        </div>
                        <div class="flex items-center p-4 bg-blue-50 rounded-2xl text-blue-700">
                            <i class="fas fa-info-circle mr-3"></i>
                            <p class="text-xs font-bold leading-snug">Note: Same-day pickups are currently unavailable to ensure efficient routing.</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <label class="block text-sm font-black text-gray-400 uppercase tracking-widest">Time Slot</label>
                        <div class="flex flex-col gap-3">
                            <?php foreach ($time_slots as $slot => $label): ?>
                                <label class="group relative flex items-center p-5 bg-white border-2 border-gray-100 rounded-2xl cursor-pointer hover:border-green-400 hover:bg-green-50/20 transition-all">
                                    <input type="radio" name="time_slot" value="<?php echo $slot; ?>" required class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500">
                                    <div class="ml-4">
                                        <p class="font-bold text-gray-900 transition-colors"><?php echo $label; ?></p>
                                        <p class="text-xs text-gray-500"><?php echo $this->getTimeSlotDescription($slot); ?></p>
                                    </div>
                                    <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-clock text-green-300"></i>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Waste Details -->
        <div id="wasteStep" class="bg-white rounded-2xl shadow-xl overflow-hidden hidden animate-slide-up">
            <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                <h2 class="text-xl font-black text-gray-900">Waste Audit</h2>
                <p class="mt-1 text-sm text-gray-500">Tell us what we're recycling today</p>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <?php foreach ($waste_categories as $category): ?>
                        <div class="relative group">
                            <label class="flex items-start h-full p-6 border-2 border-gray-100 rounded-2xl hover:border-green-400 hover:bg-green-50/20 transition-all cursor-pointer">
                                <input type="checkbox" name="waste_categories[]" value="<?php echo $category['id']; ?>" 
                                       class="mt-1 mr-4 w-5 h-5 text-green-600 border-gray-300 rounded-lg focus:ring-green-500 waste-category-checkbox" data-category="<?php echo $category['slug']; ?>">
                                <div class="flex-1">
                                    <div class="flex items-center mb-1">
                                        <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center mr-3">
                                            <i class="fas fa-<?php echo $category['icon']; ?>"></i>
                                        </div>
                                        <span class="font-black text-gray-900 uppercase tracking-tighter"><?php echo Security::escape($category['name']); ?></span>
                                    </div>
                                    <p class="text-xs text-gray-500 line-clamp-2"><?php echo Security::escape($category['description']); ?></p>
                                    
                                    <!-- Dynamic Weight Input -->
                                    <div class="mt-4 hidden" id="weight-<?php echo $category['id']; ?>">
                                        <div class="relative">
                                            <input type="number" name="weight_<?php echo $category['id']; ?>" min="0.5" step="0.5" placeholder="0.0"
                                                   class="w-full pl-4 pr-12 py-3 bg-white border-2 border-gray-100 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:border-green-500 font-bold block">
                                            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-black text-gray-400">KG</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="mt-10">
                    <label class="block text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Special Handling Instructions</label>
                    <textarea name="special_instructions" rows="4" placeholder="Need us to call upon arrival? Items left at the gate? Let us know here..."
                              class="w-full p-6 bg-gray-50 border-2 border-transparent border-gray-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all font-medium text-gray-900"></textarea>
                </div>
            </div>
        </div>

        <!-- Step 4: Confirmation -->
        <div id="confirmStep" class="bg-white rounded-2xl shadow-xl overflow-hidden hidden animate-slide-up">
            <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                <h2 class="text-xl font-black text-gray-900">Final Review</h2>
                <p class="mt-1 text-sm text-gray-500">Almost done! Verify your request details</p>
            </div>
            <div class="p-8">
                <div id="confirmationDetails" class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <!-- Details will be populated by JavaScript -->
                </div>
                
                <div class="relative p-8 bg-green-600 rounded-2xl text-white overflow-hidden shadow-xl shadow-green-100 mb-8">
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full"></div>
                    <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <p class="text-xs font-black uppercase tracking-widest opacity-80">Estimated Total Cost</p>
                            <p class="text-4xl font-black">ZMW <span id="totalCost">50.00</span></p>
                        </div>
                        <div class="flex items-center text-xs bg-black/10 backdrop-blur-sm p-3 rounded-xl border border-white/20 h-fit">
                            <i class="fas fa-info-circle mr-2"></i>
                            <p class="font-bold">Includes ZMW 50 base fee + pickup-specific kg rates.</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-gray-50 border-2 border-gray-100 rounded-2xl">
                    <label class="flex items-start gap-4 cursor-pointer">
                        <input type="checkbox" id="terms" required class="mt-1 w-6 h-6 text-green-600 border-gray-300 rounded-lg focus:ring-green-500">
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-900">I confirm the details are correct</p>
                            <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">
                                By scheduling, you agree to the <a href="/terms" class="text-green-600 hover:underline">Pickup Guidelines</a>. 
                                Our team will verify weight on-site using calibrated digital scales for exact pricing.
                            </p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex items-center justify-between mt-10">
            <button type="button" id="prevBtn" class="group px-8 py-4 bg-white border-2 border-gray-100 text-gray-900 font-black rounded-2xl hover:border-gray-300 hover:bg-gray-50 transition-all hidden">
                <i class="fas fa-arrow-left mr-3 group-hover:-translate-x-1 transition-transform"></i> Back
            </button>
            <button type="button" id="nextBtn" class="group px-10 py-4 bg-green-600 text-white font-black rounded-2xl shadow-lg shadow-green-100 hover:bg-green-700 hover:scale-105 active:scale-95 transition-all ml-auto">
                Continue <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
            </button>
            <button type="submit" id="submitBtn" class="group px-10 py-4 bg-green-600 text-white font-black rounded-2xl shadow-xl shadow-green-200 hover:bg-green-700 hover:scale-105 active:scale-95 transition-all hidden">
                <i class="fas fa-calendar-check mr-3"></i> Confirm Booking
            </button>
        </div>
    </form>
</div>

<style>
@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}
@keyframes slide-up {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fade-in 0.8s ease-out; }
.animate-slide-up { animation: slide-up 0.5s ease-out; }

input[type="radio"]:checked + div p { color: #16a34a; }
input[type="checkbox"]:checked ~ div i { color: #16a34a; }
</style>

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
                // Update navigation line
                const progressBar = document.getElementById('progressBar');
                const progressWidths = [12.5, 37.5, 62.5, 100];
                
                // Dim current indicator
                const currentInd = document.getElementById('step' + currentStep);
                currentInd.classList.add('opacity-100');
                currentInd.querySelector('div').className = 'w-12 h-12 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-lg font-black transition-all';
                currentInd.querySelector('p').className = 'absolute top-14 left-1/2 -translate-x-1/2 whitespace-nowrap text-xs font-bold text-green-300 uppercase tracking-wider';

                currentStep++;
                
                // Glow next indicator
                const nextInd = document.getElementById('step' + currentStep);
                nextInd.classList.remove('opacity-40', 'grayscale', 'pointer-events-none');
                nextInd.querySelector('div').className = 'w-12 h-12 bg-green-600 text-white rounded-2xl shadow-lg shadow-green-100 flex items-center justify-center text-lg font-black transform scale-110 transition-all duration-300';
                nextInd.querySelector('p').className = 'absolute top-14 left-1/2 -translate-x-1/2 whitespace-nowrap text-xs font-bold text-green-600 uppercase tracking-wider';
                
                progressBar.style.width = progressWidths[currentStep-1] + '%';
                
                showStep(currentStep);
            }
        }
    }
    
    function prevStep() {
        if (currentStep > 1) {
            const progressBar = document.getElementById('progressBar');
            const progressWidths = [12.5, 37.5, 62.5, 100];
            
            // Revert current to disabled
            const currentInd = document.getElementById('step' + currentStep);
            currentInd.classList.add('opacity-40', 'grayscale', 'pointer-events-none');
            currentInd.querySelector('div').className = 'w-12 h-12 bg-white text-gray-400 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center text-lg font-black transition-all';
            currentInd.querySelector('p').className = 'absolute top-14 left-1/2 -translate-x-1/2 whitespace-nowrap text-xs font-bold text-gray-400 uppercase tracking-wider';

            currentStep--;
            
            // Glow previous
            const prevInd = document.getElementById('step' + currentStep);
            prevInd.querySelector('div').className = 'w-12 h-12 bg-green-600 text-white rounded-2xl shadow-lg shadow-green-100 flex items-center justify-center text-lg font-black transform scale-110 transition-all duration-300';
            prevInd.querySelector('p').className = 'absolute top-14 left-1/2 -translate-x-1/2 whitespace-nowrap text-xs font-bold text-green-600 uppercase tracking-wider';
            
            progressBar.style.width = progressWidths[currentStep-1] + '%';
            
            showStep(currentStep);
        }
    }
    
    window.goToStep = function(step) {
        if (step < currentStep) {
            while (currentStep > step) prevStep();
        } else if (step > currentStep) {
            while (currentStep < step) nextStep();
        }
    };
    
    function showStep(step) {
        // Hide all steps
        document.getElementById('addressStep').classList.add('hidden');
        document.getElementById('dateTimeStep').classList.add('hidden');
        document.getElementById('wasteStep').classList.add('hidden');
        document.getElementById('confirmStep').classList.add('hidden');
        
        // Show current step with animation reset
        const stepEl = [
            null,
            document.getElementById('addressStep'),
            document.getElementById('dateTimeStep'),
            document.getElementById('wasteStep'),
            document.getElementById('confirmStep')
        ][step];
        
        stepEl.classList.remove('hidden');
        
        // Update buttons
        document.getElementById('prevBtn').classList.toggle('hidden', step === 1);
        document.getElementById('nextBtn').classList.toggle('hidden', step === totalSteps);
        document.getElementById('submitBtn').classList.toggle('hidden', step !== totalSteps);
        
        if (step === 4) updateConfirmation();
    }
    
    function validateStep(step) {
        switch(step) {
            case 1:
                const addressSelected = document.querySelector('input[name="address_id"]:checked');
                if (!addressSelected) {
                    showToast('Please select a pickup address', 'error');
                    return false;
                }
                return true;
            case 2:
                const date = document.querySelector('input[name="pickup_date"]').value;
                const timeSlot = document.querySelector('input[name="time_slot"]:checked');
                if (!date || !timeSlot) {
                    showToast('Please select both date and time slot', 'error');
                    return false;
                }
                return true;
            case 3:
                const categories = document.querySelectorAll('input[name="waste_categories[]"]:checked');
                if (categories.length === 0) {
                    showToast('Please select at least one waste category', 'error');
                    return false;
                }
                // Validate weights
                for (let category of categories) {
                    const weightInput = document.querySelector('input[name="weight_' + category.value + '"]');
                    if (weightInput && (!weightInput.value || parseFloat(weightInput.value) <= 0)) {
                        showToast('Please enter valid weight for all selected categories', 'error');
                        return false;
                    }
                }
                return true;
            case 4:
                const terms = document.getElementById('terms').checked;
                if (!terms) {
                    showToast('Please confirm the details are correct', 'error');
                    return false;
                }
                return true;
            default:
                return true;
        }
    }
    
    function showToast(msg) {
        // Simple alert for now, but styled if possible
        alert(msg);
    }
    
    function updateConfirmation() {
        const addressId = document.querySelector('input[name="address_id"]:checked').value;
        const address = <?php echo json_encode($addresses); ?>.find(a => a.id == addressId);
        const date = document.querySelector('input[name="pickup_date"]').value;
        const timeSlotValue = document.querySelector('input[name="time_slot"]:checked').value;
        const timeSlotLabel = { morning: 'Morning (08:00 - 12:00)', afternoon: 'Afternoon (13:00 - 17:00)', evening: 'Evening (18:00 - 20:00)' }[timeSlotValue];
        const categories = document.querySelectorAll('input[name="waste_categories[]"]:checked');
        
        let html = `
            <div class="space-y-6">
                <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 h-full">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Location</p>
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-green-500 mt-1 mr-3"></i>
                        <div>
                            <p class="font-bold text-gray-900">${address.address_line_1}</p>
                            <p class="text-xs text-gray-500">${address.city}, ${address.province}</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 h-full">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Scheduled Time</p>
                    <div class="flex items-start">
                        <i class="fas fa-calendar-check text-green-500 mt-1 mr-3"></i>
                        <div>
                            <p class="font-bold text-gray-900">${new Date(date).toLocaleDateString('en-GB', { weekday: 'long', day: 'numeric', month: 'short' })}</p>
                            <p class="text-xs text-gray-500">${timeSlotLabel}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 border-2 border-gray-100 rounded-2xl h-full">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Waste Items</p>
                <div class="space-y-3">
        `;
        
        let totalWeight = 0;
        const categoryData = <?php echo json_encode($waste_categories); ?>;
        
        categories.forEach(cat => {
            const weight = parseFloat(document.querySelector('input[name="weight_' + cat.value + '"]').value) || 0;
            totalWeight += weight;
            const category = categoryData.find(c => c.id == cat.value);
            html += `
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-${category.icon} text-green-500 text-xs mr-3"></i>
                        <span class="text-sm font-bold text-gray-700">${category.name}</span>
                    </div>
                    <span class="text-xs font-black text-gray-400">${weight} KG</span>
                </div>
            `;
        });
        
        html += `
                </div>
                <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-sm font-black text-gray-900">Total Load</span>
                    <span class="px-3 py-1 bg-gray-900 text-white text-[10px] font-black rounded-lg uppercase tracking-widest">${totalWeight} KG</span>
                </div>
            </div>
        `;
        
        document.getElementById('confirmationDetails').innerHTML = html;
        
        // Calculate cost (base 50 + 5 per kg)
        const cost = 50 + (totalWeight * 5);
        document.getElementById('totalCost').textContent = cost.toFixed(2);
    }
});
</script>
