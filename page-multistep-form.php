<?php
/*
Template Name: Multi-Step Form
*/

// Remove WordPress header/footer for full-page experience
get_header();
?>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Ubuntu', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f0f6ff;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        color: #022959;
    }

    .form-container {
        display: flex;
        max-width: 1200px;
        width: 100%;
        background: white;
        border-radius: 15px;
        box-shadow: 0 25px 40px -20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        min-height: 600px;
        position: relative;
    }

    /* Left Sidebar */
    .sidebar {
        position: relative;
        width: 274px;
        background: linear-gradient(135deg, #683fea 0%, #bf60e5 100%);
        padding: 32px 24px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        border-radius: 0 15px 15px 0;
        overflow: hidden;
    }

    /* Step Navigation */
    .step-nav {
        margin-bottom: 32px;
    }

    .step-item {
        display: flex;
        align-items: center;
        margin-bottom: 32px;
        color: white;
        opacity: 0.7;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .step-item.active {
        opacity: 1;
    }

    .step-item.completed {
        opacity: 1;
    }

    .step-number {
        width: 33px;
        height: 33px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        margin-right: 24px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
    }

    .step-item.active .step-number {
        background: #bfe7fd;
        color: #022959;
        border-color: #bfe7fd;
    }

    .step-item.completed .step-number {
        background: #bfe7fd;
        color: #022959;
        border-color: #bfe7fd;
    }

    .step-info {
        flex: 1;
    }

    .step-label {
        font-size: 12px;
        font-weight: 400;
        opacity: 0.7;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 4px;
    }

    .step-title {
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Right Form Section */
    .form-content {
        flex: 1;
        padding: 56px 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
    }

    /* Step Content */
    .step-content {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }

    .step-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Form Headers */
    .form-header {
        margin-bottom: 35px;
    }

    .form-header h1 {
        font-size: 32px;
        font-weight: 700;
        color: #022959;
        margin-bottom: 11px;
    }

    .form-header p {
        font-size: 16px;
        color: #9699aa;
        line-height: 1.5;
    }

    /* Form Fields */
    .form-fields {
        max-width: 450px;
    }

    .form-group {
        margin-bottom: 24px;
        position: relative;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #022959;
        margin-bottom: 8px;
    }

    .form-group input {
        width: 100%;
        padding: 15px 16px;
        border: 1px solid #d6d9e6;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        background: white;
        color: #022959;
    }

    .form-group input:focus {
        outline: none;
        border-color: #483eff;
        box-shadow: 0 0 0 1px #483eff;
    }

    .form-group input::placeholder {
        color: #9699aa;
        font-weight: 500;
    }

    .form-group.error input {
        border-color: #ee374a;
    }

    .error-message {
        display: block;
        color: #ee374a;
        font-size: 14px;
        margin-top: 8px;
        font-weight: 500;
    }

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    .required {
        color: #ee374a;
    }

    /* Plan Selection */
    .plan-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 32px;
    }

    .plan-option {
        border: 1px solid #d6d9e6;
        border-radius: 8px;
        padding: 20px 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .plan-option:hover {
        border-color: #483eff;
    }

    .plan-option.selected {
        border-color: #483eff;
        background: #f8f9fe;
    }

    .plan-option input[type="radio"] {
        display: none;
    }

    .plan-label {
        display: block;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .plan-icon {
        width: 40px;
        height: 40px;
        margin-bottom: 39px;
    }

    .plan-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .plan-name {
        font-size: 16px;
        font-weight: 700;
        color: #022959;
        margin-bottom: 6px;
    }

    .plan-price {
        font-size: 14px;
        color: #9699aa;
        margin-bottom: 6px;
    }

    .plan-discount {
        font-size: 12px;
        color: #022959;
        font-weight: 500;
        display: none;
    }

    .plan-discount.show {
        display: block;
    }

    /* Billing Toggle */
    .billing-toggle {
        background: #f8f9fe;
        border-radius: 8px;
        padding: 14px 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 24px;
        margin-bottom: 32px;
    }

    .billing-option {
        font-size: 14px;
        font-weight: 700;
        color: #9699aa;
        transition: color 0.3s ease;
    }

    .billing-option.active {
        color: #022959;
    }

    .toggle-switch {
        position: relative;
        width: 38px;
        height: 20px;
        background: #022959;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .toggle-switch::after {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 16px;
        height: 16px;
        background: white;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .toggle-switch.active::after {
        transform: translateX(18px);
    }

    /* Add-ons */
    .addon-options {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 32px;
    }

    .addon-option {
        border: 1px solid #d6d9e6;
        border-radius: 8px;
        padding: 18px 24px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .addon-option:hover {
        border-color: #483eff;
    }

    .addon-option.selected {
        border-color: #483eff;
        background: #f8f9fe;
    }

    .addon-option input[type="checkbox"] {
        width: 20px;
        height: 20px;
        accent-color: #483eff;
    }

    .addon-info {
        flex: 1;
    }

    .addon-name {
        font-size: 16px;
        font-weight: 700;
        color: #022959;
        margin-bottom: 6px;
    }

    .addon-description {
        font-size: 14px;
        color: #9699aa;
    }

    .addon-price {
        font-size: 14px;
        color: #483eff;
        font-weight: 500;
    }

    /* Summary */
    .summary-container {
        background: #f8f9fe;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .summary-plan {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 24px;
        border-bottom: 1px solid #d6d9e6;
        margin-bottom: 24px;
    }

    .plan-details h3 {
        font-size: 16px;
        font-weight: 700;
        color: #022959;
        margin-bottom: 6px;
    }

    .change-link {
        font-size: 14px;
        color: #9699aa;
        text-decoration: underline;
        cursor: pointer;
    }

    .plan-cost {
        font-size: 16px;
        font-weight: 700;
        color: #022959;
    }

    .summary-addons {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .summary-addon {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .addon-name-summary {
        font-size: 14px;
        color: #9699aa;
    }

    .addon-price-summary {
        font-size: 14px;
        color: #022959;
    }

    .total-section {
        padding: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .total-label {
        font-size: 14px;
        color: #9699aa;
    }

    .total-amount {
        font-size: 20px;
        font-weight: 700;
        color: #483eff;
    }

    /* Thank You Step */
    .thank-you-content {
        text-align: center;
        padding: 40px 0;
    }

    .thank-you-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 32px;
        background: #483eff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .thank-you-icon::after {
        content: '✓';
        color: white;
        font-size: 40px;
        font-weight: bold;
    }

    .thank-you-title {
        font-size: 32px;
        font-weight: 700;
        color: #022959;
        margin-bottom: 14px;
    }

    .thank-you-message {
        font-size: 16px;
        color: #9699aa;
        line-height: 1.5;
        max-width: 450px;
        margin: 0 auto;
    }

    /* Form Actions */
    .form-actions {
        position: absolute;
        bottom: 32px;
        left: 80px;
        right: 80px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn {
        padding: 16px 24px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-back {
        background: transparent;
        color: #9699aa;
        font-weight: 500;
    }

    .btn-back:hover {
        color: #022959;
    }

    .btn-next {
        background: #022959;
        color: white;
        margin-left: auto;
    }

    .btn-next:hover {
        background: #164a8a;
    }

    .btn-confirm {
        background: #483eff;
        color: white;
    }

    .btn-confirm:hover {
        background: #928cff;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-container {
            flex-direction: column;
            max-width: 100%;
            border-radius: 0;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 100%;
            border-radius: 0;
            padding: 32px 24px;
            min-height: 172px;
        }
        
        .form-content {
            padding: 32px 24px 100px;
            flex: 1;
        }
        
        .form-header h1 {
            font-size: 24px;
        }
        
        .step-nav {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-bottom: 0;
        }
        
        .step-item {
            flex-direction: column;
            text-align: center;
            margin-bottom: 0;
            gap: 8px;
        }
        
        .step-number {
            margin-right: 0;
        }
        
        .step-label {
            display: none;
        }
        
        .step-title {
            font-size: 12px;
        }
        
        .plan-options {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        
        .plan-option {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
        }
        
        .plan-icon {
            margin-bottom: 0;
            width: 40px;
            height: 40px;
        }
        
        .form-actions {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 16px 24px;
            box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    }

    @media (max-width: 480px) {
        body {
            padding: 0;
        }
        
        .form-content {
            padding: 24px 16px 100px;
        }
        
        .form-actions {
            padding: 16px;
        }
        
        .btn {
            padding: 14px 20px;
            font-size: 14px;
        }
    }
</style>

<main class="form-container" role="main" aria-label="Multi-step subscription form">
    <!-- Left Sidebar with Step Navigation -->
    <nav class="sidebar" role="navigation" aria-label="Form progress">
        <div class="step-nav" role="tablist" aria-label="Form steps">
            <div class="step-item active" data-step="1" role="tab" aria-selected="true" aria-label="Step 1 of 4: Personal Information">
                <div class="step-number" aria-hidden="true">1</div>
                <div class="step-info">
                    <div class="step-label">Step 1</div>
                    <div class="step-title">Your Info</div>
                </div>
            </div>
            <div class="step-item" data-step="2" role="tab" aria-selected="false" aria-label="Step 2 of 4: Select Plan">
                <div class="step-number" aria-hidden="true">2</div>
                <div class="step-info">
                    <div class="step-label">Step 2</div>
                    <div class="step-title">Select Plan</div>
                </div>
            </div>
            <div class="step-item" data-step="3" role="tab" aria-selected="false" aria-label="Step 3 of 4: Add-ons">
                <div class="step-number" aria-hidden="true">3</div>
                <div class="step-info">
                    <div class="step-label">Step 3</div>
                    <div class="step-title">Add-ons</div>
                </div>
            </div>
            <div class="step-item" data-step="4" role="tab" aria-selected="false" aria-label="Step 4 of 4: Summary">
                <div class="step-number" aria-hidden="true">4</div>
                <div class="step-info">
                    <div class="step-label">Step 4</div>
                    <div class="step-title">Summary</div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Right Form Section -->
    <section class="form-content" role="region" aria-label="Form content">
        <!-- Step 1: Personal Info -->
        <div class="step-content active" id="step-1" role="tabpanel" aria-labelledby="step-1-tab">
            <div class="form-header">
                <h1>Personal Info</h1>
                <p>Please provide your name, email address, and phone number.</p>
            </div>
            
            <form class="form-fields" novalidate>
                <fieldset>
                    <legend class="sr-only">Personal Information</legend>
                    <div class="form-group">
                        <label for="name">Name <span class="required" aria-label="required">*</span></label>
                        <input type="text" id="name" name="name" placeholder="e.g. Stephen King" required aria-describedby="name-error" aria-invalid="false">
                        <div id="name-error" class="error-message" role="alert" aria-live="polite"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address <span class="required" aria-label="required">*</span></label>
                        <input type="email" id="email" name="email" placeholder="e.g. stephenking@lorem.com" required aria-describedby="email-error" aria-invalid="false">
                        <div id="email-error" class="error-message" role="alert" aria-live="polite"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number <span class="required" aria-label="required">*</span></label>
                        <input type="tel" id="phone" name="phone" placeholder="e.g. +1 234 567 890" required aria-describedby="phone-error" aria-invalid="false">
                        <div id="phone-error" class="error-message" role="alert" aria-live="polite"></div>
                    </div>
                </fieldset>
            </form>
        </div>

        <!-- Step 2: Select Plan -->
        <div class="step-content" id="step-2" role="tabpanel" aria-labelledby="step-2-tab">
            <div class="form-header">
                <h1>Select your plan</h1>
                <p>You have the option of monthly or yearly billing.</p>
            </div>
            
            <fieldset class="plan-options">
                <legend class="sr-only">Select your subscription plan</legend>
                <div class="plan-option" data-plan="arcade">
                    <input type="radio" name="plan" value="arcade" id="arcade" aria-describedby="arcade-description">
                    <label for="arcade" class="plan-label">
                        <div class="plan-icon" aria-hidden="true">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <rect width="40" height="40" rx="10" fill="#FFAF7E"/>
                                <path d="M24.038 12.22c1.46 0 2.647 1.188 2.647 2.647v1.411a2.655 2.655 0 0 1-2.647 2.647H16.412a2.655 2.655 0 0 1-2.647-2.647v-1.411a2.655 2.655 0 0 1 2.647-2.647h7.626zm-7.626 1.294a1.353 1.353 0 0 0-1.353 1.353v1.411a1.353 1.353 0 0 0 1.353 1.353h7.626a1.353 1.353 0 0 0 1.353-1.353v-1.411a1.353 1.353 0 0 0-1.353-1.353H16.412z" fill="white"/>
                                <path d="M20.176 15.882a.647.647 0 0 1 .647.647v1.294a.647.647 0 0 1-1.294 0v-1.294a.647.647 0 0 1 .647-.647z" fill="white"/>
                            </svg>
                        </div>
                        <div class="plan-name">Arcade</div>
                        <div class="plan-price">$9/mo</div>
                        <div class="plan-discount" id="arcade-description">2 months free</div>
                    </label>
                </div>
                
                <div class="plan-option" data-plan="advanced">
                    <input type="radio" name="plan" value="advanced" id="advanced">
                    <label for="advanced" class="plan-label">
                        <div class="plan-icon">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <rect width="40" height="40" rx="10" fill="#F9818E"/>
                                <path d="M20 12c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6z" fill="white"/>
                                <path d="M20 16c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z" fill="white"/>
                            </svg>
                        </div>
                        <div class="plan-name">Advanced</div>
                        <div class="plan-price">$12/mo</div>
                        <div class="plan-discount">2 months free</div>
                    </label>
                </div>
                
                <div class="plan-option" data-plan="pro">
                    <input type="radio" name="plan" value="pro" id="pro">
                    <label for="pro" class="plan-label">
                        <div class="plan-icon">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <rect width="40" height="40" rx="10" fill="#483EFF"/>
                                <path d="M20 12c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6z" fill="white"/>
                                <path d="M20 16c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z" fill="white"/>
                            </svg>
                        </div>
                        <div class="plan-name">Pro</div>
                        <div class="plan-price">$15/mo</div>
                        <div class="plan-discount">2 months free</div>
                    </label>
                </div>
            </fieldset>
            
            <div class="billing-toggle">
                <span class="billing-option active">Monthly</span>
                <div class="toggle-switch" id="billing-toggle">
                    <input type="checkbox" id="yearly-billing" style="display: none;">
                </div>
                <span class="billing-option">Yearly</span>
            </div>
        </div>

        <!-- Step 3: Pick Add-ons -->
        <div class="step-content" id="step-3">
            <div class="form-header">
                <h1>Pick add-ons</h1>
                <p>Add-ons help enhance your gaming experience.</p>
            </div>
            
            <div class="addon-options">
                <div class="addon-option" data-addon="online-service">
                    <input type="checkbox" id="online-service" name="addons[]" value="online-service">
                    <div class="addon-info">
                        <div class="addon-name">Online service</div>
                        <div class="addon-description">Access to multiplayer games</div>
                    </div>
                    <div class="addon-price">+$1/mo</div>
                </div>
                
                <div class="addon-option" data-addon="larger-storage">
                    <input type="checkbox" id="larger-storage" name="addons[]" value="larger-storage">
                    <div class="addon-info">
                        <div class="addon-name">Larger storage</div>
                        <div class="addon-description">Extra 1TB of cloud save</div>
                    </div>
                    <div class="addon-price">+$2/mo</div>
                </div>
                
                <div class="addon-option" data-addon="customizable-profile">
                    <input type="checkbox" id="customizable-profile" name="addons[]" value="customizable-profile">
                    <div class="addon-info">
                        <div class="addon-name">Customizable Profile</div>
                        <div class="addon-description">Custom theme on your profile</div>
                    </div>
                    <div class="addon-price">+$2/mo</div>
                </div>
            </div>
        </div>

        <!-- Step 4: Finishing Up -->
        <div class="step-content" id="step-4">
            <div class="form-header">
                <h1>Finishing up</h1>
                <p>Double-check everything looks OK before confirming.</p>
            </div>
            
            <div class="summary-container">
                <div class="summary-plan">
                    <div class="plan-details">
                        <h3>Arcade (Monthly)</h3>
                        <span class="change-link">Change</span>
                    </div>
                    <div class="plan-cost">$9/mo</div>
                </div>
                
                <div class="summary-addons">
                    <div class="summary-addon">
                        <span class="addon-name-summary">Online service</span>
                        <span class="addon-price-summary">+$1/mo</span>
                    </div>
                    <div class="summary-addon">
                        <span class="addon-name-summary">Larger storage</span>
                        <span class="addon-price-summary">+$2/mo</span>
                    </div>
                </div>
            </div>
            
            <div class="total-section">
                <span class="total-label">Total (per month)</span>
                <span class="total-amount">+$12/mo</span>
            </div>
        </div>

        <!-- Step 5: Thank You -->
        <div class="step-content" id="step-5">
            <div class="thank-you-content">
                <div class="thank-you-icon"></div>
                <h1 class="thank-you-title">Thank you!</h1>
                <p class="thank-you-message">Thanks for confirming your subscription! We hope you have fun using our platform. If you ever need support, please feel free to email us at support@loremgaming.com.</p>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions" role="group" aria-label="Form navigation">
            <button type="button" class="btn btn-back" id="backBtn" style="display: none;" aria-label="Go to previous step">Go Back</button>
            <button type="button" class="btn btn-next" id="nextBtn" aria-label="Go to next step">Next Step</button>
        </div>
    </section>
</main>

<?php get_footer(); ?>