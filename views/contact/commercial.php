<!-- Hero Section -->
<div class="bg-gradient-to-r from-orange-600 to-red-600 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-extrabold text-white">Partner with EcoWaste</h1>
        <p class="mt-4 text-xl text-orange-100">Commercial food waste collection & recycling partnerships</p>
    </div>
</div>

<!-- Partnership Types -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">Partnership Opportunities</h2>
            <p class="mt-4 text-lg text-gray-500">Choose the partnership model that fits your organization</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-blue-50 rounded-lg p-6 text-center hover:shadow-lg transition-shadow">
                <i class="fas fa-hospital-alt text-5xl text-blue-600 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Healthcare Facilities</h3>
                <p class="text-gray-700 mb-4">Hospitals, clinics, medical centers</p>
                <ul class="text-left text-sm text-gray-600 space-y-2">
                    <li>✓ Compliant medical food waste disposal</li>
                    <li>✓ Daily or on-demand collection</li>
                    <li>✓ Segregated waste handling</li>
                </ul>
            </div>

            <div class="bg-green-50 rounded-lg p-6 text-center hover:shadow-lg transition-shadow">
                <i class="fas fa-utensils text-5xl text-green-600 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Food Service</h3>
                <p class="text-gray-700 mb-4">Restaurants, hotels, catering</p>
                <ul class="text-left text-sm text-gray-600 space-y-2">
                    <li>✓ Kitchen waste collection</li>
                    <li>✓ Reduce disposal costs</li>
                    <li>✓ Sustainability branding support</li>
                </ul>
            </div>

            <div class="bg-orange-50 rounded-lg p-6 text-center hover:shadow-lg transition-shadow">
                <i class="fas fa-shopping-cart text-5xl text-orange-600 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Retail & Supermarkets</h3>
                <p class="text-gray-700 mb-4">Grocery stores, markets</p>
                <ul class="text-left text-sm text-gray-600 space-y-2">
                    <li>✓ Expired produce recycling</li>
                    <li>✓ Large volume handling</li>
                    <li>✓ Scheduled weekly pickups</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Contact Form -->
<div class="py-16 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Partnership Inquiry</h2>
            <p class="mt-4 text-lg text-gray-500">Fill out this form and we'll contact you within 24 hours</p>
        </div>

        <form id="partnershipForm" class="bg-white shadow-md rounded-lg p-8">
            <!-- Organization Information -->
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Organization Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Organization Name *</label>
                        <input type="text" name="org_name" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Organization Type *</label>
                        <select name="org_type" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Type</option>
                            <option value="hospital">Hospital/Clinic</option>
                            <option value="restaurant">Restaurant</option>
                            <option value="hotel">Hotel</option>
                            <option value="supermarket">Supermarket</option>
                            <option value="school">School/University</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estimated Monthly Waste (kg) *</label>
                        <input type="number" name="monthly_volume" required placeholder="e.g., 500" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Location/Address *</label>
                        <input type="text" name="address" required placeholder="e.g., Cairo Road, Lusaka CBD" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
            </div>

            <!-- Contact Person -->
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Contact Person</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                        <input type="text" name="contact_name" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Position/Title *</label>
                        <input type="text" name="contact_position" required placeholder="e.g., Operations Manager" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                        <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                        <input type="tel" name="phone" required placeholder="e.g., 0977123456" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
            </div>

            <!-- Service Requirements -->
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Service Requirements</h3>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Waste Types (select all that apply) *</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="waste_types[]" value="food_waste" class="rounded text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-gray-700">Food Waste (kitchen scraps, expired food)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="waste_types[]" value="recyclables" class="rounded text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-gray-700">Recyclables (plastic, paper, cardboard)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="waste_types[]" value="general" class="rounded text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-gray-700">General Waste</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Collection Frequency *</label>
                    <select name="frequency" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                        <option value="">Select Frequency</option>
                        <option value="daily">Daily</option>
                        <option value="3x_week">3 times per week</option>
                        <option value="2x_week">2 times per week</option>
                        <option value="weekly">Weekly</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Additional Information</label>
                    <textarea name="notes" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500" placeholder="Any specific requirements, current waste management challenges, or questions..."></textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-md text-lg transition-colors shadow-lg">
                    Submit Partnership Inquiry
                    <i class="fas fa-paper-plane ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Benefits Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">Partnership Benefits</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="bg-green-100 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hand-holding-usd text-green-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Cost Reduction</h3>
                <p class="text-sm text-gray-600">Lower waste disposal costs with commercial rates</p>
            </div>

            <div class="text-center">
                <div class="bg-blue-100 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-certificate text-blue-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Green Certification</h3>
                <p class="text-sm text-gray-600">EcoWaste Certified badge for marketing</p>
            </div>

            <div class="text-center">
                <div class="bg-purple-100 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Impact Reports</h3>
                <p class="text-sm text-gray-600">Quarterly sustainability metrics for CSR</p>
            </div>

            <div class="text-center">
                <div class="bg-orange-100 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-handshake text-orange-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Reliable Service</h3>
                <p class="text-sm text-gray-600">Scheduled pickups, SMS notifications, tracking</p>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('partnershipForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validation
    const formData = new FormData(this);
    const wasteTypes = formData.getAll('waste_types[]');
    
    if (wasteTypes.length === 0) {
        alert('Please select at least one waste type');
        return;
    }
    
    // Success message
    alert('Thank you for your partnership inquiry! Our team will contact you within 24 hours to discuss your requirements and provide a custom quote.');
    this.reset();
});
</script>
