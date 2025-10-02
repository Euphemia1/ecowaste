<div class="space-y-6">
    <div>
        <h2 class="text-center text-3xl font-extrabold text-gray-900">
            Join EcoWaste
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Create your account to start making a difference
        </p>
    </div>

    <form class="space-y-6" action="/register" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        
        <!-- Account Type -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">
                Account Type
            </label>
            <div class="grid grid-cols-2 gap-3">
                <?php foreach ($account_types as $type => $label): ?>
                <label class="relative">
                    <input type="radio" name="account_type" value="<?php echo $type; ?>" 
                           class="sr-only peer" <?php echo $type === 'individual' ? 'checked' : ''; ?> 
                           onchange="toggleBusinessFields()">
                    <div class="w-full p-3 text-center border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 hover:bg-gray-50 transition-colors">
                        <div class="text-sm font-medium text-gray-900"><?php echo $label; ?></div>
                    </div>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700">
                    First Name <span class="text-red-500">*</span>
                </label>
                <div class="mt-1">
                    <input id="first_name" name="first_name" type="text" required 
                           class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                           placeholder="John">
                </div>
            </div>

            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700">
                    Last Name <span class="text-red-500">*</span>
                </label>
                <div class="mt-1">
                    <input id="last_name" name="last_name" type="text" required 
                           class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                           placeholder="Doe">
                </div>
            </div>
        </div>

        <!-- Business Name (hidden by default) -->
        <div id="business_fields" class="hidden">
            <label for="company_name" class="block text-sm font-medium text-gray-700">
                Company Name <span class="text-red-500">*</span>
            </label>
            <div class="mt-1">
                <input id="company_name" name="company_name" type="text" 
                       class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                       placeholder="Company Name">
            </div>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
                Email Address <span class="text-red-500">*</span>
            </label>
            <div class="mt-1 relative">
                <input id="email" name="email" type="email" autocomplete="email" required 
                       class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                       placeholder="john@example.com">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">
                Phone Number (Optional)
            </label>
            <div class="mt-1 relative">
                <input id="phone" name="phone" type="tel" 
                       class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                       placeholder="(555) 123-4567">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <i class="fas fa-phone text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
                Password <span class="text-red-500">*</span>
            </label>
            <div class="mt-1 relative">
                <input id="password" name="password" type="password" required 
                       class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                       placeholder="Create a strong password" onkeyup="checkPasswordStrength()">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePassword('password')">
                        <i id="password-icon" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <!-- Password Strength Indicator -->
            <div class="mt-2">
                <div class="flex space-x-1">
                    <div id="strength-bar-1" class="h-2 flex-1 bg-gray-200 rounded"></div>
                    <div id="strength-bar-2" class="h-2 flex-1 bg-gray-200 rounded"></div>
                    <div id="strength-bar-3" class="h-2 flex-1 bg-gray-200 rounded"></div>
                    <div id="strength-bar-4" class="h-2 flex-1 bg-gray-200 rounded"></div>
                </div>
                <p id="strength-text" class="text-xs text-gray-500 mt-1">Password strength: Weak</p>
            </div>
            <p class="mt-2 text-xs text-gray-500">
                Password must be at least 8 characters and include uppercase, lowercase, and numbers.
            </p>
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="confirm_password" class="block text-sm font-medium text-gray-700">
                Confirm Password <span class="text-red-500">*</span>
            </label>
            <div class="mt-1 relative">
                <input id="confirm_password" name="confirm_password" type="password" required 
                       class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                       placeholder="Confirm your password" onkeyup="checkPasswordMatch()">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePassword('confirm_password')">
                        <i id="confirm_password-icon" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <p id="password-match-message" class="text-xs mt-1 hidden"></p>
        </div>

        <!-- Terms and Conditions -->
        <div class="flex items-center">
            <input id="terms_accepted" name="terms_accepted" type="checkbox" required
                   class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
            <label for="terms_accepted" class="ml-2 block text-sm text-gray-900">
                I agree to the <a href="#" class="text-green-600 hover:text-green-500 font-medium">Terms of Service</a> 
                and <a href="#" class="text-green-600 hover:text-green-500 font-medium">Privacy Policy</a> 
                <span class="text-red-500">*</span>
            </label>
        </div>

        <div>
            <button type="submit" 
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <i class="fas fa-user-plus text-green-500 group-hover:text-green-400"></i>
                </span>
                Create Account
            </button>
        </div>

        <div class="text-center">
            <span class="text-sm text-gray-600">Already have an account?</span>
            <a href="/login" class="font-medium text-green-600 hover:text-green-500 ml-1">
                Sign in here
            </a>
        </div>
    </form>
</div>

<script>
function toggleBusinessFields() {
    const businessRadio = document.querySelector('input[name="account_type"][value="business"]');
    const businessFields = document.getElementById('business_fields');
    const companyNameField = document.getElementById('company_name');
    
    if (businessRadio.checked) {
        businessFields.classList.remove('hidden');
        companyNameField.setAttribute('required', 'required');
    } else {
        businessFields.classList.add('hidden');
        companyNameField.removeAttribute('required');
    }
}

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthBars = [
        document.getElementById('strength-bar-1'),
        document.getElementById('strength-bar-2'),
        document.getElementById('strength-bar-3'),
        document.getElementById('strength-bar-4')
    ];
    const strengthText = document.getElementById('strength-text');
    
    let strength = 0;
    let strengthLabel = 'Very Weak';
    let color = 'bg-red-500';
    
    // Length check
    if (password.length >= 8) strength++;
    
    // Uppercase check
    if (/[A-Z]/.test(password)) strength++;
    
    // Lowercase check
    if (/[a-z]/.test(password)) strength++;
    
    // Number check
    if (/[0-9]/.test(password)) strength++;
    
    // Special character check
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    // Reset all bars
    strengthBars.forEach(bar => {
        bar.className = 'h-2 flex-1 bg-gray-200 rounded';
    });
    
    // Update strength display
    if (strength >= 1) {
        strengthLabel = 'Weak';
        color = 'bg-red-500';
        strengthBars[0].classList.add(color);
    }
    if (strength >= 2) {
        strengthLabel = 'Fair';
        color = 'bg-yellow-500';
        strengthBars[1].classList.add(color);
    }
    if (strength >= 3) {
        strengthLabel = 'Good';
        color = 'bg-blue-500';
        strengthBars[2].classList.add(color);
    }
    if (strength >= 4) {
        strengthLabel = 'Strong';
        color = 'bg-green-500';
        strengthBars[3].classList.add(color);
    }
    
    strengthText.textContent = `Password strength: ${strengthLabel}`;
}

function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const message = document.getElementById('password-match-message');
    
    if (confirmPassword.length > 0) {
        if (password === confirmPassword) {
            message.textContent = 'Passwords match';
            message.className = 'text-xs mt-1 text-green-600';
            message.classList.remove('hidden');
        } else {
            message.textContent = 'Passwords do not match';
            message.className = 'text-xs mt-1 text-red-600';
            message.classList.remove('hidden');
        }
    } else {
        message.classList.add('hidden');
    }
}

// Initialize business fields visibility
document.addEventListener('DOMContentLoaded', function() {
    toggleBusinessFields();
});
</script>