import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // User menu dropdown
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    
    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userMenu.contains(e.target) && !userMenuButton.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Form validation feedback
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';
            }
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Tooltips
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute z-50 px-2 py-1 text-xs text-white bg-gray-900 rounded shadow-lg';
            tooltip.textContent = this.getAttribute('data-tooltip');
            tooltip.style.top = this.offsetTop - 30 + 'px';
            tooltip.style.left = this.offsetLeft + 'px';
            this.appendChild(tooltip);
        });

        element.addEventListener('mouseleave', function() {
            const tooltip = this.querySelector('.absolute.z-50');
            if (tooltip) {
                tooltip.remove();
            }
        });
    });
});

// Service selection in booking form
window.updateServiceDetails = function(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const detailsDiv = document.getElementById('service-details');
    
    if (selectedOption.value) {
        const description = selectedOption.getAttribute('data-description');
        const duration = selectedOption.getAttribute('data-duration');
        const price = selectedOption.getAttribute('data-price');
        
        detailsDiv.innerHTML = `
            <div class="card mt-4">
                <div class="card-body">
                    <h3 class="text-lg font-semibold mb-2">Service Details</h3>
                    <p class="text-gray-600 mb-3">${description || 'No description available'}</p>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-sm text-gray-500">Duration:</span>
                            <span class="font-medium ml-2">${duration}</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Price:</span>
                            <span class="font-semibold text-primary-600 ml-2 text-lg">${price}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
        detailsDiv.classList.remove('hidden');
    } else {
        detailsDiv.classList.add('hidden');
    }
};

// Business selection in booking form
window.loadBusinessServices = function(businessId) {
    const serviceSelect = document.getElementById('plan_id');
    const detailsDiv = document.getElementById('service-details');
    
    if (!businessId) {
        serviceSelect.innerHTML = '<option value="">Select a business first</option>';
        serviceSelect.disabled = true;
        detailsDiv.classList.add('hidden');
        return;
    }
    
    serviceSelect.disabled = true;
    serviceSelect.innerHTML = '<option value="">Loading services...</option>';
    
    axios.get(`/api/businesses/${businessId}/plans`)
        .then(response => {
            const plans = response.data;
            serviceSelect.innerHTML = '<option value="">Select a service</option>';
            
            plans.forEach(plan => {
                const option = document.createElement('option');
                option.value = plan.id;
                option.textContent = plan.name;
                option.setAttribute('data-description', plan.description || '');
                option.setAttribute('data-duration', plan.formatted_duration);
                option.setAttribute('data-price', plan.formatted_price);
                serviceSelect.appendChild(option);
            });
            
            serviceSelect.disabled = false;
        })
        .catch(error => {
            console.error('Error loading services:', error);
            serviceSelect.innerHTML = '<option value="">Error loading services</option>';
        });
};

// Modal functions
window.showModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
};

window.hideModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
};

// Confirmation dialogs
window.confirmAction = function(message) {
    return confirm(message || 'Are you sure you want to perform this action?');
};

