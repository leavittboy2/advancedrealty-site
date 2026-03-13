<?php
// functions.php - HOA Theme Configuration & WordPress Setup

// 1. Enqueue Styles and Scripts the "WordPress Way"
function advanced_realty_hoa_scripts() {
    // Loads the style.css file automatically
    wp_enqueue_style( 'hoa-style', get_stylesheet_uri() );
    
    // Loads Tailwind CSS safely via WordPress
    wp_enqueue_script( 'tailwindcss', 'https://cdn.tailwindcss.com', array(), null, false );
}
add_action( 'wp_enqueue_scripts', 'advanced_realty_hoa_scripts' );

// 2. Set up the WordPress Customizer (Appearance -> Customize)
function hoa_theme_customize_register( $wp_customize ) {
    
    // Create a new panel section in the Customizer
    $wp_customize->add_section( 'hoa_settings', [
        'title'    => 'HOA Details & Links',
        'priority' => 30,
        'description' => 'Update the contact info, links, and announcements for this specific HOA.'
    ]);

    // Helper function to easily add fields to the customizer
    $add_setting = function($id, $label, $default, $type = 'text') use ($wp_customize) {
        $wp_customize->add_setting( $id, [ 'default' => $default, 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $id, [
            'label'   => $label,
            'section' => 'hoa_settings',
            'type'    => $type,
        ]);
    };

    // Register all our fields (HOA Name is handled by WP Site Title automatically)
    $add_setting('management_name', 'Management Company Name', 'Advanced Realty');
    $add_setting('management_url', 'Management URL', 'https://advancedrealty.com', 'url');
    $add_setting('owner_portal_url', 'Owner Portal / Payments URL', 'https://advr.twa.rentmanager.com/', 'url');
    $add_setting('contact_phone', 'Contact Phone', '(435) 674-4343');
    $add_setting('contact_email', 'Contact Email', 'info@advancedrealty.com', 'email');
    $add_setting('contact_address', 'Contact Address', '1156 E 700 S Ste. 1, St. George, UT 84790');
    $add_setting('announcement_text', 'Announcement Text', 'Landscaping violations will be reviewed next week. Please ensure your yard meets community standards.', 'textarea');
    $add_setting('hero_image_url', 'Hero Image URL', 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'url');
    $add_setting('annual_meeting_date', 'Annual Meeting Date', 'October 15, 2025');
    $add_setting('acc_form_url', 'ACC Form URL', 'https://advancedrealty.com/wp-content/uploads/2026/02/Architectural-Control-Committee-ACC-Form-Template.pdf', 'url');
    $add_setting('documents_url', 'Governing Documents URL', '#', 'url');
    $add_setting('rental_quote_url', 'Rental Quote URL', 'https://advancedrealty.com/get-rental-quote', 'url');
    $add_setting('storage_url', 'Storage URL', 'https://stgeorgestorage.com', 'url');
    $add_setting('tos_url', 'Terms of Service URL', '#', 'url');
    $add_setting('privacy_url', 'Privacy Policy URL', '#', 'url');
}
add_action( 'customize_register', 'hoa_theme_customize_register' );


// 3. Helper Function to grab these variables anywhere in our theme
function get_hoa_var($key) {
    // AUTOMATICALLY PULL THE HOA NAME FROM WORDPRESS SITE TITLE!
    if ($key === 'hoa_name') {
        return get_bloginfo('name'); 
    }

    // Default fallbacks in case a setting is left blank
    $defaults = [
        'management_name'      => 'Advanced Realty',
        'management_url'       => 'https://advancedrealty.com',
        'owner_portal_url'     => 'https://advr.twa.rentmanager.com/',
        'contact_phone'        => '(435) 674-4343',
        'contact_email'        => 'info@advancedrealty.com',
        'contact_address'      => '1156 E 700 S Ste. 1, St. George, UT 84790',
        'announcement_text'    => 'Landscaping violations will be reviewed next week. Please ensure your yard meets community standards.',
        'hero_image_url'       => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'annual_meeting_date'  => 'October 15, 2025',
        'acc_form_url'         => 'https://advancedrealty.com/wp-content/uploads/2026/02/Architectural-Control-Committee-ACC-Form-Template.pdf',
        'documents_url'        => '#',
        'rental_quote_url'     => 'https://advancedrealty.com/get-rental-quote',
        'storage_url'          => 'https://stgeorgestorage.com',
        'tos_url'              => 'https://advancedrealty.com/terms-and-conditions/',
        'privacy_url'          => 'https://advancedrealty.com/privacy-policy/'
    ];

    // Grab the dynamic value from the WordPress database, or use default
    return get_theme_mod($key, $defaults[$key]);
}
?>