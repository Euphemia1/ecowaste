<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-white shadow-sm rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
                    <p class="mt-1 text-sm text-gray-500">Manage your account information and preferences</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="/profile/settings" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 text-sm">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </a>
                    <a href="/profile/addresses" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                        <i class="fas fa-map-marker-alt mr-2"></i> Addresses
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Personal Information</h2>
                </div>
                <div class="p-6">
                    <form id="profileForm" method="POST" action="/profile/update">
                        <input type="hidden" name="csrf_token" value="<?php echo Security::generateCSRFToken(); ?>">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                <input type="text" name="first_name" value="<?php echo Security::escape($user['first_name']); ?>" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                <input type="text" name="last_name" value="<?php echo Security::escape($user['last_name']); ?>" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" value="<?php echo Security::escape($user['email']); ?>" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <?php if (!$user['email_verified']): ?>
                                <p class="mt-1 text-sm text-red-600">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Email not verified. <a href="/profile/verify-email" class="text-red-600 hover:text-red-700 underline">Verify now</a>
                                </p>
                            <?php else: ?>
                                <p class="mt-1 text-sm text-green-600">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Email verified
                                </p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" name="phone" value="<?php echo Security::escape($user['phone'] ?? ''); ?>"
                                   placeholder="+260 97 123 4567"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Account Type</label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="account_type" value="individual" 
                                           <?php echo $user['account_type'] === 'individual' ? 'checked' : ''; ?>
                                           class="mr-2">
                                    <span class="text-sm text-gray-700">Individual</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="account_type" value="business" 
                                           <?php echo $user['account_type'] === 'business' ? 'checked' : ''; ?>
                                           class="mr-2">
                                    <span class="text-sm text-gray-700">Business</span>
                                </label>
                            </div>
                        </div>
                        
                        <?php if ($user['account_type'] === 'business'): ?>
                            <div class="mt-6" id="companyField">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                                <input type="text" name="company_name" value="<?php echo Security::escape($user['company_name'] ?? ''); ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                        <?php endif; ?>
                        
                        <div class="mt-8">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                <i class="fas fa-save mr-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Change -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Change Password</h2>
                </div>
                <div class="p-6">
                    <form id="passwordForm" method="POST" action="/profile/change-password">
                        <input type="hidden" name="csrf_token" value="<?php echo Security::generateCSRFToken(); ?>">
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                <input type="password" name="current_password" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <input type="password" name="new_password" id="newPassword" required minlength="8"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                <input type="password" name="confirm_password" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                <i class="fas fa-lock mr-2"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notification Preferences -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Notification Preferences</h2>
                </div>
                <div class="p-6">
                    <form id="notificationsForm" method="POST" action="/profile/notifications">
                        <input type="hidden" name="csrf_token" value="<?php echo Security::generateCSRFToken(); ?>">
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Email Notifications</label>
                                    <p class="text-sm text-gray-500">Receive pickup confirmations and updates via email</p>
                                </div>
                                <input type="checkbox" name="email_notifications" value="1" 
                                       <?php echo $preferences['email_notifications'] ? 'checked' : ''; ?>
                                       class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <label class="text-sm font-medium text-gray-700">SMS Notifications</label>
                                    <p class="text-sm text-gray-500">Get SMS alerts for pickup status changes</p>
                                </div>
                                <input type="checkbox" name="sms_notifications" value="1" 
                                       <?php echo $preferences['sms_notifications'] ? 'checked' : ''; ?>
                                       class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Monthly Impact Report</label>
                                    <p class="text-sm text-gray-500">Receive monthly environmental impact summaries</p>
                                </div>
                                <input type="checkbox" name="monthly_report" value="1" 
                                       <?php echo $preferences['monthly_report'] ? 'checked' : ''; ?>
                                       class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Promotional Offers</label>
                                    <p class="text-sm text-gray-500">Receive information about special offers and new features</p>
                                </div>
                                <input type="checkbox" name="promotional_emails" value="1" 
                                       <?php echo $preferences['promotional_emails'] ? 'checked' : ''; ?>
                                       class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                <i class="fas fa-bell mr-2"></i> Save Preferences
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Profile Summary -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Profile Summary</h2>
                </div>
                <div class="p-6">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">
                            <?php echo Security::escape($user['first_name'] . ' ' . $user['last_name']); ?>
                        </h3>
                        <p class="text-sm text-gray-500"><?php echo Security::escape($user['email']); ?></p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-2">
                            <?php echo ucfirst($user['account_type']); ?>
                        </span>
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm text-gray-500">Member Since</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    <?php echo date('F Y', strtotime($user['created_at'])); ?>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-500">Total Pickups</dt>
                                <dd class="text-sm font-medium text-gray-900"><?php echo $stats['total_pickups']; ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-500">Total Recycled</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    <?php echo Helpers::formatWeight($stats['total_weight']); ?>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Quick Actions</h2>
                </div>
                <div class="p-6 space-y-3">
                    <a href="/schedule-pickup" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        <i class="fas fa-plus mr-2"></i> Schedule Pickup
                    </a>
                    
                    <a href="/pickup-history" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-history mr-2"></i> View History
                    </a>
                    
                    <a href="/impact" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-chart-line mr-2"></i> My Impact
                    </a>
                    
                    <a href="/profile/addresses" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-map-marker-alt mr-2"></i> Manage Addresses
                    </a>
                </div>
            </div>

            <!-- Account Status -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Account Status</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Account Status</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Email Verified</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $user['email_verified'] ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                <?php echo $user['email_verified'] ? 'Verified' : 'Pending'; ?>
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Payment Method</span>
                            <span class="text-sm text-gray-900">Mobile Money</span>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <a href="/profile/delete" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')"
                           class="text-sm text-red-600 hover:text-red-700">
                            <i class="fas fa-trash mr-1"></i> Delete Account
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle company field based on account type
    const accountTypeRadios = document.querySelectorAll('input[name="account_type"]');
    const companyField = document.getElementById('companyField');
    
    accountTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'business') {
                companyField.style.display = 'block';
            } else {
                companyField.style.display = 'none';
            }
        });
    });
    
    // Initialize company field visibility
    const currentAccountType = document.querySelector('input[name="account_type"]:checked').value;
    if (currentAccountType !== 'business') {
        companyField.style.display = 'none';
    }
    
    // Form submissions
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        submitForm(this, 'profile');
    });
    
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate passwords match
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = this.querySelector('input[name="confirm_password"]').value;
        
        if (newPassword !== confirmPassword) {
            alert('Passwords do not match');
            return;
        }
        
        submitForm(this, 'password');
    });
    
    document.getElementById('notificationsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        submitForm(this, 'notifications');
    });
});

function submitForm(form, type) {
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Changes saved successfully!');
            if (type === 'password') {
                form.reset();
            }
        } else {
            alert(data.message || 'Error saving changes. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving changes. Please try again.');
    });
}
</script>
