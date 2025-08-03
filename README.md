# Multi-Step Form WordPress Theme

A modern, responsive multi-step form WordPress theme with validation and smooth transitions.

## Features

- **4-Step Form Process**: Personal Info → Plan Selection → Add-ons → Summary
- **Real-time Validation**: Form fields are validated as users type
- **Responsive Design**: Works on desktop, tablet, and mobile devices
- **Data Persistence**: Form data is saved to localStorage and restored on page reload
- **Smooth Animations**: CSS transitions and animations for better UX
- **Modern UI**: Clean, professional design with gradient backgrounds
- **Accessibility**: WCAG 2.1 AA compliant with ARIA labels, screen reader support
- **SEO Optimized**: Proper meta tags, semantic HTML structure
- **WordPress Standards**: Follows WordPress coding standards and best practices

## Installation

1. Upload the theme files to your WordPress themes directory (`wp-content/themes/multi-step-form-theme/`)
2. Activate the theme in WordPress admin
3. The "Multi Step Form" page will be automatically created
4. Visit the page to see the form in action

## Form Steps

### Step 1: Personal Info
- Name (required, minimum 2 characters)
- Email Address (required, valid email format)
- Phone Number (required, minimum 10 characters)

### Step 2: Plan Selection
- Choose between Arcade ($9/mo), Advanced ($12/mo), or Pro ($15/mo)
- Toggle between monthly and yearly billing
- Yearly plans get 2 months free

### Step 3: Add-ons
- Online service (+$1/mo)
- Larger storage (+$2/mo)
- Customizable profile (+$2/mo)
- All add-ons are optional

### Step 4: Summary
- Review all selections
- See total cost
- Click "Change" to go back to plan selection
- Click "Confirm" to complete

### Step 5: Thank You
- Confirmation message
- Form completion

## Validation Rules

- **Name**: Required, minimum 2 characters
- **Email**: Required, valid email format
- **Phone**: Required, minimum 10 characters
- **Plan**: Must select one plan before proceeding

## Browser Support

- Chrome (recommended)
- Firefox
- Safari
- Edge

## File Structure

```
multi-step-form-theme/
├── functions.php          # WordPress theme functions
├── header.php            # Theme header template
├── footer.php            # Theme footer template
├── index.php             # Default template
├── page-multistep-form.php # Multi-step form template
├── script.js             # JavaScript functionality
├── style.css             # Theme stylesheet
└── README.md             # This file
```

## Customization

### Colors
The theme uses CSS custom properties for easy color customization. Main colors:
- Primary: #483eff
- Secondary: #022959
- Background: #f0f6ff
- Text: #9699aa

### Styling
All styles are contained in the `style.css` file and inline styles in the template. Modify these to customize the appearance.

## Troubleshooting

1. **Form not progressing**: Make sure all required fields are filled correctly
2. **JavaScript errors**: Check browser console for errors
3. **Styling issues**: Clear browser cache and refresh
4. **WordPress integration**: Ensure the theme is properly activated

## Support

For issues or questions, check the browser console for JavaScript errors and ensure all files are properly uploaded to the theme directory. 