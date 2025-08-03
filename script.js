jQuery(document).ready(function($) {
    let currentStep = 1;
    const totalSteps = 5;
    
    // Form data storage
    let formData = {
        name: '',
        email: '',
        phone: '',
        plan: '',
        billing: 'monthly',
        addons: []
    };

    // Initialize the form
    function initForm() {
        updateStepDisplay();
        setupEventListeners();
        loadSavedData();
    }

    // Update step display
    function updateStepDisplay() {
        // Update step navigation
        $('.step-item').removeClass('active completed').attr('aria-selected', 'false');
        $('.step-item[data-step="' + currentStep + '"]').addClass('active').attr('aria-selected', 'true');
        
        // Mark completed steps
        for (let i = 1; i < currentStep; i++) {
            $('.step-item[data-step="' + i + '"]').addClass('completed');
        }

        // Show/hide step content
        $('.step-content').removeClass('active').attr('aria-hidden', 'true');
        $('#step-' + currentStep).addClass('active').attr('aria-hidden', 'false');

        // Update summary if on step 4
        if (currentStep === 4) {
            updateSummary();
        }

        // Update buttons
        updateButtons();
    }

    // Update button visibility and text
    function updateButtons() {
        const backBtn = $('#backBtn');
        const nextBtn = $('#nextBtn');

        if (currentStep === 1) {
            backBtn.hide();
        } else {
            backBtn.show();
        }

        if (currentStep === totalSteps - 1) {
            nextBtn.text('Confirm');
            nextBtn.removeClass('btn-next').addClass('btn-confirm');
        } else if (currentStep === totalSteps) {
            backBtn.hide();
            nextBtn.hide();
        } else {
            nextBtn.text('Next Step');
            nextBtn.removeClass('btn-confirm').addClass('btn-next');
        }
    }

    // Setup event listeners
    function setupEventListeners() {
        // Next button
        $('#nextBtn').on('click', function() {
            if (validateCurrentStep()) {
                saveCurrentStepData();
                if (currentStep < totalSteps) {
                    currentStep++;
                    updateStepDisplay();
                }
            }
        });

        // Back button
        $('#backBtn').on('click', function() {
            if (currentStep > 1) {
                currentStep--;
                updateStepDisplay();
            }
        });

        // Step navigation clicks
        $('.step-item').on('click', function() {
            const step = parseInt($(this).data('step'));
            if (step <= currentStep || isStepCompleted(step - 1)) {
                currentStep = step;
                updateStepDisplay();
            } else {
                // Show a message that they need to complete previous steps
                alert('Please complete the current step before proceeding.');
            }
        });

        // Plan selection
        $('.plan-option').on('click', function() {
            $('.plan-option').removeClass('selected');
            $(this).addClass('selected');
            const plan = $(this).data('plan');
            $('input[name="plan"][value="' + plan + '"]').prop('checked', true);
            
            // Update summary if on step 4
            if (currentStep === 4) {
                updateSummary();
            }
        });

        // Billing toggle
        $('#billing-toggle').on('click', function() {
            $(this).toggleClass('active');
            const isYearly = $(this).hasClass('active');
            $('.billing-option').removeClass('active');
            if (isYearly) {
                $('.billing-option:last').addClass('active');
                formData.billing = 'yearly';
                updatePlanPrices();
            } else {
                $('.billing-option:first').addClass('active');
                formData.billing = 'monthly';
                updatePlanPrices();
            }
        });

        // Addon selection
        $('.addon-option').on('click', function() {
            $(this).toggleClass('selected');
            const checkbox = $(this).find('input[type="checkbox"]');
            checkbox.prop('checked', !checkbox.prop('checked'));
            
            // Update summary if on step 4
            if (currentStep === 4) {
                updateSummary();
            }
        });

        // Form input validation
        $('input[type="text"], input[type="email"], input[type="tel"]').on('blur', function() {
            validateField($(this));
        });

        // Real-time validation
        $('input[type="text"], input[type="email"], input[type="tel"]').on('input', function() {
            clearFieldError($(this));
        });

        // Change link in summary
        $('.change-link').on('click', function() {
            currentStep = 2;
            updateStepDisplay();
        });
    }

    // Validate current step
    function validateCurrentStep() {
        let isValid = true;

        switch (currentStep) {
            case 1:
                isValid = validateStep1();
                break;
            case 2:
                isValid = validateStep2();
                break;
            case 3:
                isValid = validateStep3();
                break;
            case 4:
                isValid = validateStep4();
                break;
        }

        return isValid;
    }

    // Validate Step 1 (Personal Info)
    function validateStep1() {
        let isValid = true;

        // Validate name
        const name = $('#name').val().trim();
        if (!name) {
            showFieldError('#name', 'This field is required');
            isValid = false;
        } else if (name.length < 2) {
            showFieldError('#name', 'Name must be at least 2 characters');
            isValid = false;
        }

        // Validate email
        const email = $('#email').val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            showFieldError('#email', 'This field is required');
            isValid = false;
        } else if (!emailRegex.test(email)) {
            showFieldError('#email', 'Please enter a valid email address');
            isValid = false;
        }

        // Validate phone
        const phone = $('#phone').val().trim();
        if (!phone) {
            showFieldError('#phone', 'This field is required');
            isValid = false;
        } else if (phone.length < 10) {
            showFieldError('#phone', 'Please enter a valid phone number');
            isValid = false;
        }

        return isValid;
    }

    // Validate Step 2 (Plan Selection)
    function validateStep2() {
        const selectedPlan = $('input[name="plan"]:checked').val();
        if (!selectedPlan) {
            alert('Please select a plan');
            return false;
        }
        return true;
    }

    // Validate Step 3 (Add-ons) - Always valid as add-ons are optional
    function validateStep3() {
        return true;
    }

    // Validate Step 4 (Summary) - Always valid
    function validateStep4() {
        return true;
    }

    // Show field error
    function showFieldError(fieldSelector, message) {
        const field = $(fieldSelector);
        const formGroup = field.closest('.form-group');
        formGroup.addClass('error');
        
        let errorSpan = formGroup.find('.error-message');
        if (errorSpan.length === 0) {
            errorSpan = $('<span class="error-message" role="alert" aria-live="polite"></span>');
            formGroup.append(errorSpan);
        }
        errorSpan.text(message);
        
        // Update ARIA attributes
        field.attr('aria-invalid', 'true');
        field.attr('aria-describedby', field.attr('id') + '-error');
    }

    // Clear field error
    function clearFieldError(field) {
        const formGroup = field.closest('.form-group');
        formGroup.removeClass('error');
        formGroup.find('.error-message').remove();
        
        // Update ARIA attributes
        field.attr('aria-invalid', 'false');
        field.removeAttr('aria-describedby');
    }

    // Validate individual field
    function validateField(field) {
        const fieldId = field.attr('id');
        const value = field.val().trim();

        switch (fieldId) {
            case 'name':
                if (!value) {
                    showFieldError('#' + fieldId, 'This field is required');
                } else if (value.length < 2) {
                    showFieldError('#' + fieldId, 'Name must be at least 2 characters');
                } else {
                    clearFieldError(field);
                }
                break;
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!value) {
                    showFieldError('#' + fieldId, 'This field is required');
                } else if (!emailRegex.test(value)) {
                    showFieldError('#' + fieldId, 'Please enter a valid email address');
                } else {
                    clearFieldError(field);
                }
                break;
            case 'phone':
                if (!value) {
                    showFieldError('#' + fieldId, 'This field is required');
                } else if (value.length < 10) {
                    showFieldError('#' + fieldId, 'Please enter a valid phone number');
                } else {
                    clearFieldError(field);
                }
                break;
        }
    }

    // Save current step data
    function saveCurrentStepData() {
        switch (currentStep) {
            case 1:
                formData.name = $('#name').val().trim();
                formData.email = $('#email').val().trim();
                formData.phone = $('#phone').val().trim();
                break;
            case 2:
                formData.plan = $('input[name="plan"]:checked').val();
                formData.billing = $('#billing-toggle').hasClass('active') ? 'yearly' : 'monthly';
                break;
            case 3:
                formData.addons = [];
                $('input[name="addons[]"]:checked').each(function() {
                    formData.addons.push($(this).val());
                });
                break;
        }
        
        // Save to localStorage
        localStorage.setItem('multiStepFormData', JSON.stringify(formData));
    }

    // Load saved data
    function loadSavedData() {
        const savedData = localStorage.getItem('multiStepFormData');
        if (savedData) {
            formData = JSON.parse(savedData);
            
            // Populate form fields
            $('#name').val(formData.name);
            $('#email').val(formData.email);
            $('#phone').val(formData.phone);
            
            // Select plan
            if (formData.plan) {
                $('.plan-option[data-plan="' + formData.plan + '"]').addClass('selected');
                $('input[name="plan"][value="' + formData.plan + '"]').prop('checked', true);
            }
            
            // Set billing
            if (formData.billing === 'yearly') {
                $('#billing-toggle').addClass('active');
                $('.billing-option:last').addClass('active');
                $('.billing-option:first').removeClass('active');
            }
            
            // Select addons
            if (formData.addons && formData.addons.length > 0) {
                formData.addons.forEach(addon => {
                    $('input[name="addons[]"][value="' + addon + '"]').prop('checked', true);
                    $('.addon-option[data-addon="' + addon + '"]').addClass('selected');
                });
            }
        }
    }

    // Check if step is completed
    function isStepCompleted(step) {
        switch (step) {
            case 1:
                return formData.name && formData.email && formData.phone;
            case 2:
                return formData.plan;
            case 3:
                return true; // Add-ons are optional
            case 4:
                return true; // Summary is always accessible
            default:
                return false;
        }
    }

    // Update plan prices based on billing cycle
    function updatePlanPrices() {
        const isYearly = formData.billing === 'yearly';
        const prices = {
            arcade: { monthly: '$9/mo', yearly: '$90/yr' },
            advanced: { monthly: '$12/mo', yearly: '$120/yr' },
            pro: { monthly: '$15/mo', yearly: '$150/yr' }
        };

        $('.plan-option').each(function() {
            const plan = $(this).data('plan');
            const priceElement = $(this).find('.plan-price');
            const discountElement = $(this).find('.plan-discount');
            
            if (isYearly) {
                priceElement.text(prices[plan].yearly);
                discountElement.addClass('show');
            } else {
                priceElement.text(prices[plan].monthly);
                discountElement.removeClass('show');
            }
        });
        
        // Update summary if we're on step 4
        if (currentStep === 4) {
            updateSummary();
        }
    }

    // Update summary section
    function updateSummary() {
        if (!formData.plan) return;
        
        const planNames = {
            arcade: 'Arcade',
            advanced: 'Advanced',
            pro: 'Pro'
        };
        
        const planPrices = {
            arcade: { monthly: 9, yearly: 90 },
            advanced: { monthly: 12, yearly: 120 },
            pro: { monthly: 15, yearly: 150 }
        };
        
        const addonPrices = {
            'online-service': { monthly: 1, yearly: 10 },
            'larger-storage': { monthly: 2, yearly: 20 },
            'customizable-profile': { monthly: 2, yearly: 20 }
        };
        
        const addonNames = {
            'online-service': 'Online service',
            'larger-storage': 'Larger storage',
            'customizable-profile': 'Customizable Profile'
        };
        
        const isYearly = formData.billing === 'yearly';
        const period = isYearly ? ' (Yearly)' : ' (Monthly)';
        const planPrice = isYearly ? planPrices[formData.plan].yearly : planPrices[formData.plan].monthly;
        
        $('.summary-plan .plan-details h3').text(planNames[formData.plan] + period);
        $('.summary-plan .plan-cost').text(`$${planPrice}/${isYearly ? 'yr' : 'mo'}`);
        
        let addonsHtml = '';
        let totalAddons = 0;
        
        formData.addons.forEach(addon => {
            const addonPrice = isYearly ? addonPrices[addon].yearly : addonPrices[addon].monthly;
            totalAddons += addonPrice;
            addonsHtml += `
                <div class="summary-addon">
                    <span class="addon-name-summary">${addonNames[addon]}</span>
                    <span class="addon-price-summary">+$${addonPrice}/${isYearly ? 'yr' : 'mo'}</span>
                </div>
            `;
        });
        
        $('.summary-addons').html(addonsHtml);
        
        const total = planPrice + totalAddons;
        const totalPeriod = isYearly ? 'per year' : 'per month';
        $('.total-label').text(`Total (${totalPeriod})`);
        $('.total-amount').text(`$${total}/${isYearly ? 'yr' : 'mo'}`);
    }

    // Initialize the form when document is ready
    initForm();
}); 