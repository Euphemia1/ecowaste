// Main JavaScript for EcoWaste Application

document.addEventListener('DOMContentLoaded', function() {
    // Initialize mobile menu
    initMobileMenu();
    
    // Initialize tooltips
    initTooltips();
    
    // Auto-hide flash messages
    autoHideFlashMessages();
    
    // Initialize form enhancements
    initFormEnhancements();
});

// Mobile menu functionality
function initMobileMenu() {
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('show');
            
            // Update aria-expanded
            const isExpanded = !mobileMenu.classList.contains('hidden');
            mobileMenuButton.setAttribute('aria-expanded', isExpanded);
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('show');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
            }
        });
    }
}

// Tooltip functionality
function initTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    
    tooltipElements.forEach(element => {
        let tooltip = null;
        
        element.addEventListener('mouseenter', function() {
            const tooltipText = this.getAttribute('data-tooltip');
            
            // Create tooltip
            tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = tooltipText;
            document.body.appendChild(tooltip);
            
            // Position tooltip
            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';
            
            // Show tooltip
            setTimeout(() => tooltip.classList.add('show'), 10);
        });
        
        element.addEventListener('mouseleave', function() {
            if (tooltip) {
                tooltip.remove();
                tooltip = null;
            }
        });
    });
}

// Auto-hide flash messages
function autoHideFlashMessages() {
    const flashMessages = document.querySelectorAll('.flash-messages .alert');
    
    flashMessages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            message.style.transform = 'translateX(100%)';
            setTimeout(() => message.remove(), 300);
        }, 5000);
    });
}

// Form enhancements
function initFormEnhancements() {
    // Add loading state to form submissions
    const forms = document.querySelectorAll('form[data-loading]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<span class="spinner mr-2"></span>Loading...';
                submitButton.disabled = true;
                
                // Re-enable after 10 seconds (fallback)
                setTimeout(() => {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }, 10000);
            }
        });
    });
    
    // Real-time form validation
    initFormValidation();
}

// Form validation
function initFormValidation() {
    const emailFields = document.querySelectorAll('input[type="email"]');
    const phoneFields = document.querySelectorAll('input[type="tel"]');
    
    // Email validation
    emailFields.forEach(field => {
        field.addEventListener('blur', function() {
            const isValid = validateEmail(this.value);
            toggleFieldValidation(this, isValid);
        });
    });
    
    // Phone validation
    phoneFields.forEach(field => {
        field.addEventListener('input', function() {
            this.value = formatPhone(this.value);
        });
        
        field.addEventListener('blur', function() {
            const isValid = validatePhone(this.value);
            toggleFieldValidation(this, isValid);
        });
    });
}

// Validation functions
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePhone(phone) {
    const re = /^\(\d{3}\)\s\d{3}-\d{4}$/;
    return re.test(phone) || phone === '';
}

function formatPhone(phone) {
    const numbers = phone.replace(/\D/g, '');
    if (numbers.length >= 6) {
        return `(${numbers.slice(0, 3)}) ${numbers.slice(3, 6)}-${numbers.slice(6, 10)}`;
    } else if (numbers.length >= 3) {
        return `(${numbers.slice(0, 3)}) ${numbers.slice(3)}`;
    } else {
        return numbers;
    }
}

function toggleFieldValidation(field, isValid) {
    field.classList.remove('field-error', 'field-success');
    
    if (field.value.trim() !== '') {
        if (isValid) {
            field.classList.add('field-success');
        } else {
            field.classList.add('field-error');
        }
    }
}

// Utility functions
function showLoading(element) {
    if (element) {
        element.innerHTML = '<span class="spinner mr-2"></span>Loading...';
        element.disabled = true;
    }
}

function hideLoading(element, originalText) {
    if (element) {
        element.innerHTML = originalText;
        element.disabled = false;
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg max-w-sm ${getNotificationClasses(type)}`;
    notification.innerHTML = `
        <div class="flex items-center">
            <div class="flex-shrink-0">
                ${getNotificationIcon(type)}
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">${message}</p>
            </div>
            <div class="ml-auto pl-3">
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

function getNotificationClasses(type) {
    const classes = {
        'success': 'bg-green-100 border border-green-200 text-green-800',
        'error': 'bg-red-100 border border-red-200 text-red-800',
        'warning': 'bg-yellow-100 border border-yellow-200 text-yellow-800',
        'info': 'bg-blue-100 border border-blue-200 text-blue-800'
    };
    return classes[type] || classes.info;
}

function getNotificationIcon(type) {
    const icons = {
        'success': '<i class="fas fa-check-circle text-green-400"></i>',
        'error': '<i class="fas fa-exclamation-circle text-red-400"></i>',
        'warning': '<i class="fas fa-exclamation-triangle text-yellow-400"></i>',
        'info': '<i class="fas fa-info-circle text-blue-400"></i>'
    };
    return icons[type] || icons.info;
}

// AJAX helper
function makeAjaxRequest(url, method = 'GET', data = null, headers = {}) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open(method, url, true);
        
        // Set default headers
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        
        // Set custom headers
        Object.keys(headers).forEach(key => {
            xhr.setRequestHeader(key, headers[key]);
        });
        
        // Handle response
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    resolve(response);
                } catch (e) {
                    resolve(xhr.responseText);
                }
            } else {
                reject(new Error(`HTTP ${xhr.status}: ${xhr.statusText}`));
            }
        };
        
        xhr.onerror = function() {
            reject(new Error('Network error'));
        };
        
        // Send request
        if (data && method !== 'GET') {
            if (data instanceof FormData) {
                xhr.send(data);
            } else {
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.send(JSON.stringify(data));
            }
        } else {
            xhr.send();
        }
    });
}

// Export functions for use in other scripts
window.EcoWaste = {
    showLoading,
    hideLoading,
    showNotification,
    makeAjaxRequest,
    validateEmail,
    validatePhone,
    formatPhone
};