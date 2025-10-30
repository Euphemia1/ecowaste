

document.addEventListener('DOMContentLoaded', function() {

    initPasswordStrength();
    
   
    initAuthFormValidation();
    
    initAccountTypeToggle();
});

function initPasswordStrength() {
    const passwordField = document.getElementById('password');
    
    if (passwordField) {
        passwordField.addEventListener('input', function() {
            checkPasswordStrength(this.value);
        });
    }
}

function checkPasswordStrength(password) {
    const strengthBars = document.querySelectorAll('[id^="strength-bar-"]');
    const strengthText = document.getElementById('strength-text');
    
    if (!strengthBars.length || !strengthText) return;
    
    let score = 0;
    let feedback = [];
    
    if (password.length >= 8) {
        score++;
    } else {
        feedback.push('at least 8 characters');
    }
    
    
    if (/[A-Z]/.test(password)) {
        score++;
    } else {
        feedback.push('an uppercase letter');
    }
    
    
    if (/[a-z]/.test(password)) {
        score++;
    } else {
        feedback.push('a lowercase letter');
    }
    
   
    if (/[0-9]/.test(password)) {
        score++;
    } else {
        feedback.push('a number');
    }
    

    if (/[^A-Za-z0-9]/.test(password)) {
        score++;
    } else {
        feedback.push('a special character');
    }
    
    // Update strength bars
    strengthBars.forEach((bar, index) => {
        bar.className = 'h-2 flex-1 rounded transition-all duration-300';
        
        if (index < score) {
            if (score <= 2) {
                bar.classList.add('bg-red-500');
            } else if (score <= 3) {
                bar.classList.add('bg-yellow-500');
            } else if (score <= 4) {
                bar.classList.add('bg-blue-500');
            } else {
                bar.classList.add('bg-green-500');
            }
        } else {
            bar.classList.add('bg-gray-200');
        }
    });
    
    // Update strength text
    const strengthLabels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
    const strengthColors = ['text-red-600', 'text-yellow-600', 'text-blue-600', 'text-green-600'];
    
    const strengthIndex = Math.min(score, strengthLabels.length - 1);
    const colorClass = score > 0 ? strengthColors[Math.min(score - 1, strengthColors.length - 1)] : 'text-gray-500';
    
    strengthText.textContent = `Password strength: ${strengthLabels[strengthIndex]}`;
    strengthText.className = `text-xs mt-1 ${colorClass}`;
    
    // Show feedback
    if (feedback.length > 0 && password.length > 0) {
        const feedbackText = `Add ${feedback.join(', ')} to strengthen your password.`;
        if (!document.getElementById('password-feedback')) {
            const feedbackElement = document.createElement('p');
            feedbackElement.id = 'password-feedback';
            feedbackElement.className = 'text-xs text-gray-500 mt-1';
            feedbackElement.textContent = feedbackText;
            strengthText.parentNode.appendChild(feedbackElement);
        } else {
            document.getElementById('password-feedback').textContent = feedbackText;
        }
    } else {
        const feedbackElement = document.getElementById('password-feedback');
        if (feedbackElement) {
            feedbackElement.remove();
        }
    }
}

function initAuthFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
    
    // Real-time password confirmation
    const confirmPasswordField = document.getElementById('confirm_password');
    const passwordField = document.getElementById('password');
    
    if (confirmPasswordField && passwordField) {
        confirmPasswordField.addEventListener('input', function() {
            checkPasswordMatch();
        });
        
        passwordField.addEventListener('input', function() {
            if (confirmPasswordField.value) {
                checkPasswordMatch();
            }
        });
    }
}

function checkPasswordMatch() {
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirm_password');
    const messageElement = document.getElementById('password-match-message');
    
    if (!passwordField || !confirmPasswordField || !messageElement) return;
    
    const password = passwordField.value;
    const confirmPassword = confirmPasswordField.value;
    
    if (confirmPassword.length === 0) {
        messageElement.classList.add('hidden');
        return;
    }
    
    if (password === confirmPassword) {
        messageElement.textContent = '✓ Passwords match';
        messageElement.className = 'text-xs mt-1 text-green-600';
        confirmPasswordField.classList.remove('field-error');
        confirmPasswordField.classList.add('field-success');
    } else {
        messageElement.textContent = '✗ Passwords do not match';
        messageElement.className = 'text-xs mt-1 text-red-600';
        confirmPasswordField.classList.remove('field-success');
        confirmPasswordField.classList.add('field-error');
    }
    
    messageElement.classList.remove('hidden');
}

function initAccountTypeToggle() {
    const accountTypeRadios = document.querySelectorAll('input[name="account_type"]');
    
    accountTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            toggleBusinessFields();
        });
    });
}

function toggleBusinessFields() {
    const businessRadio = document.querySelector('input[name="account_type"][value="business"]');
    const businessFields = document.getElementById('business_fields');
    const companyNameField = document.getElementById('company_name');
    
    if (!businessRadio || !businessFields) return;
    
    if (businessRadio.checked) {
        businessFields.classList.remove('hidden');
        if (companyNameField) {
            companyNameField.setAttribute('required', 'required');
        }
    } else {
        businessFields.classList.add('hidden');
        if (companyNameField) {
            companyNameField.removeAttribute('required');
            companyNameField.value = '';
        }
    }
}

function validateForm(form) {
    let isValid = true;
    const errors = [];
    
    // Get all required fields
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('field-error');
            errors.push(`${getFieldLabel(field)} is required`);
        } else {
            field.classList.remove('field-error');
        }
    });
    
    // Email validation
    const emailField = form.querySelector('input[type="email"]');
    if (emailField && emailField.value) {
        if (!window.EcoWaste.validateEmail(emailField.value)) {
            isValid = false;
            emailField.classList.add('field-error');
            errors.push('Please enter a valid email address');
        }
    }
    
    // Password confirmation
    const passwordField = form.querySelector('#password');
    const confirmPasswordField = form.querySelector('#confirm_password');
    
    if (passwordField && confirmPasswordField && passwordField.value !== confirmPasswordField.value) {
        isValid = false;
        confirmPasswordField.classList.add('field-error');
        errors.push('Passwords do not match');
    }
    
    // Terms acceptance (for registration)
    const termsCheckbox = form.querySelector('#terms_accepted');
    if (termsCheckbox && !termsCheckbox.checked) {
        isValid = false;
        errors.push('You must accept the Terms of Service and Privacy Policy');
    }
    
    // Show errors
    if (errors.length > 0) {
        showFormErrors(errors);
    }
    
    return isValid;
}

function getFieldLabel(field) {
    const label = form.querySelector(`label[for="${field.id}"]`);
    if (label) {
        return label.textContent.replace('*', '').trim();
    }
    return field.name.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
}

function showFormErrors(errors) {
    // Remove existing error messages
    const existingErrors = document.querySelectorAll('.form-error-message');
    existingErrors.forEach(error => error.remove());
    
    // Show new errors
    errors.forEach(error => {
        window.EcoWaste.showNotification(error, 'error');
    });
}

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (!field || !icon) return;
    
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

// Make functions globally available
window.togglePassword = togglePassword;
window.checkPasswordStrength = checkPasswordStrength;
window.checkPasswordMatch = checkPasswordMatch;
window.toggleBusinessFields = toggleBusinessFields;