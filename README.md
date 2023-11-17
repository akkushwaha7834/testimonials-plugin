# Testimonials Plugin

## Description

The Testimonials Plugin adds a Testimonials custom post type to your WordPress website. Each testimonial can include fields for name, position, company, and testimonial content.

## Installation

1. **Download the Plugin:**
   - Download the Testimonials Plugin ZIP file from the [GitHub repository](https://github.com/yourusername/testimonials-plugin).

2. **Upload the Plugin:**
   - Log in to your WordPress admin dashboard.
   - Navigate to `Plugins > Add New`.
   - Click on the "Upload Plugin" button.
   - Choose the ZIP file you downloaded and click "Install Now."

3. **Activate the Plugin:**
   - After successful installation, click the "Activate" button to activate the Testimonials Plugin.

## Configuration

Once the plugin is activated, you can configure and use it to add testimonials to your WordPress website.

1. **Create Testimonials:**
   - After activation, a new menu item "Testimonials" will appear in the WordPress admin menu.
   - Navigate to `Testimonials > Add New` to create a new testimonial.
   - Fill in the fields such as Name, Position, Company, Testimonial Content, and set a Featured Image if desired.

2. **Display Testimonials on a Page or Post:**
   - You can use the `[testimonials]` shortcode to display testimonials on any page or post.
   - Customize the shortcode with attributes for the number of testimonials and order. Examples:
     - `[testimonials]` (displays all testimonials in date order)
     - `[testimonials count="3"]` (displays 3 testimonials in date order)
     - `[testimonials count="5" order="rand"]` (displays 5 testimonials in random order)

## Styling and Customization

If you want to customize the appearance of the testimonials or the Slick slider, you can modify the plugin's CSS styles. Locate the styles in your theme or consider using a custom CSS plugin.

## Troubleshooting

If you encounter any issues with the plugin, consider the following:

1. **Check for Conflicts:**
   - Deactivate other plugins and switch to a default WordPress theme to see if the issue persists. This helps identify conflicts.

2. **Review Browser Console:**
   - Open the browser console (usually F12) and check for error messages. Address any reported issues.

## Developer Notes

If you are a developer and want to extend the functionality or make modifications:

- The main plugin file is `testimonials-plugin.php`.
- Custom post type registration and custom fields are defined in the `testimonials_register_post_type` function.
- Shortcode functionality is defined in the `testimonials_shortcode` function.
- Slick slider initialization is in the shortcode script.

**Code Comments:**

Please review the code comments for better understanding. They provide context and explanations for each function and section of the code.

**Note:** Always back up your site before installing or modifying plugins.
