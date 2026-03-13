<?php
/**
 * Advanced Realty 2026 Child Theme Functions
 */

function advanced_realty_child_scripts() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'google-fonts-inter', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800;900&display=swap', array(), null );
    wp_enqueue_script( 'tailwind-cdn', 'https://cdn.tailwindcss.com', array(), null, false );

    $tailwind_config = "tailwind.config = { 
        corePlugins: { preflight: false },
        theme: {
            extend: {
                colors: {
                    'adv-teal': '#00A699',
                    'adv-teal-dark': '#008f83'
                }
            }
        }
    };";
    wp_add_inline_script( 'tailwind-cdn', $tailwind_config, 'before' );
    wp_enqueue_script( 'lucide-icons', 'https://unpkg.com/lucide@latest', array(), null, false );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'), wp_get_theme()->get('Version') );
}
add_action( 'wp_enqueue_scripts', 'advanced_realty_child_scripts' );

add_theme_support( 'post-thumbnails' );

/**
 * Register Custom Navigation Menus (NEW)
 */
function advanced_realty_register_menus() {
    register_nav_menus( array(
        'hoa_menu' => 'HOA Communities Dropdown'
    ) );
}
add_action( 'init', 'advanced_realty_register_menus' );

/**
 * Register the "Listing" Custom Post Type
 */
function register_advanced_realty_listings() {
    $labels = array(
        'name' => 'Listings',
        'singular_name' => 'Listing',
        'add_new' => 'Add New Listing',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-admin-home',
        'supports' => array( 'title', 'thumbnail', 'custom-fields' ),
        'show_in_rest' => true,
    );
    register_post_type( 'listing', $args );
}
add_action( 'init', 'register_advanced_realty_listings' );

/**
 * Register the "Agent" Custom Post Type
 */
function register_advanced_realty_agents() {
    $labels = array(
        'name' => 'Agents',
        'singular_name' => 'Agent',
        'add_new' => 'Add New Agent',
        'edit_item' => 'Edit Agent',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-businessman', 
        'supports' => array( 'title', 'thumbnail', 'page-attributes' ), 
        'show_in_rest' => true,
    );
    register_post_type( 'agent', $args );
}
add_action( 'init', 'register_advanced_realty_agents' );

/**
 * THE AUTOMATIC REFRESH ENGINE
 */
function refresh_flexmls_listings_automatically() {
    $url = 'https://my.flexmls.com/advancedrealty';
    
    $response = wp_remote_get($url, array('user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'));
    if (is_wp_error($response)) return;
    $html = wp_remote_retrieve_body($response);

    preg_match_all('/<div class="listing-card".*?>(.*?)<\/div>\s*<\/div>/s', $html, $matches);

    if (empty($matches[1])) return;

    $active_mls_addresses = array();

    foreach ($matches[1] as $card_html) {
        preg_match('/<div class="price">(.*?)<\/div>/', $card_html, $price);
        preg_match('/<div class="address">(.*?)<\/div>/', $card_html, $address);
        preg_match('/title="Total Bedrooms">.*?<div class="value".*?>(.*?)<\/div>/s', $card_html, $beds);
        preg_match('/title="Total Bathrooms">.*?<div class="value".*?>(.*?)<\/div>/s', $card_html, $baths);
        preg_match('/title="Total SqFt">.*?<div class="value".*?>(.*?)<\/div>/s', $card_html, $sqft);
        preg_match('/<a href="(.*?)".*?class="listing-link"/', $card_html, $link);
        preg_match('/<img.*?src="(.*?)"/', $card_html, $img);

        $clean_address = isset($address[1]) ? sanitize_text_field($address[1]) : '';
        if (!$clean_address) continue;

        $active_mls_addresses[] = html_entity_decode($clean_address);

        $args = array(
            'title'                  => $clean_address,
            'post_type'              => 'listing',
            'post_status'            => 'any',
            'posts_per_page'         => 1,
            'fields'                 => 'ids',
            'no_found_rows'          => true,
        );
        $query = new WP_Query($args);
        $existing_id = $query->have_posts() ? $query->posts[0] : null;
        
        $post_data = array(
            'post_title'   => $clean_address,
            'post_content' => 'Automatically imported listing.',
            'post_type'    => 'listing',
            'post_status'  => 'publish',
        );

        if ($existing_id) {
            $post_data['ID'] = $existing_id;
            $result_id = wp_update_post($post_data, true);
        } else {
            $result_id = wp_insert_post($post_data, true);
        }

        if (!is_wp_error($result_id)) {
            update_post_meta($result_id, 'price', isset($price[1]) ? sanitize_text_field($price[1]) : '');
            update_post_meta($result_id, 'bedrooms', isset($beds[1]) ? sanitize_text_field($beds[1]) : '');
            update_post_meta($result_id, 'bathrooms', isset($baths[1]) ? sanitize_text_field($baths[1]) : '');
            update_post_meta($result_id, 'sq_ft', isset($sqft[1]) ? sanitize_text_field($sqft[1]) : '');
            update_post_meta($result_id, 'mls_link', isset($link[1]) ? 'https://my.flexmls.com' . esc_url_raw($link[1]) : '');
            
            if (isset($img[1])) {
                update_post_meta($result_id, '_thumbnail_ext_url', esc_url_raw($img[1]));
            }
        }
    }

    if (!empty($active_mls_addresses)) {
        $all_listings_query = new WP_Query(array(
            'post_type'      => 'listing',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ));

        if ($all_listings_query->have_posts()) {
            foreach ($all_listings_query->posts as $listing_post) {
                $post_title_decoded = html_entity_decode($listing_post->post_title);
                
                if (!in_array($post_title_decoded, $active_mls_addresses)) {
                    wp_update_post(array(
                        'ID'          => $listing_post->ID,
                        'post_status' => 'draft'
                    ));
                }
            }
        }
    }
}

if (!wp_next_scheduled('daily_flexmls_refresh')) {
    wp_schedule_event(time(), 'hourly', 'daily_flexmls_refresh');
}
add_action('daily_flexmls_refresh', 'refresh_flexmls_listings_automatically');

add_action('wp_ajax_trigger_full_sync', 'trigger_full_sync_handler');
function trigger_full_sync_handler() {
    if (!current_user_can('edit_posts')) wp_die('Unauthorized');
    refresh_flexmls_listings_automatically();
    echo "Sync Complete. All listings refreshed from FlexMLS.";
    wp_die();
}

add_action('wp_ajax_create_listing_auto', 'create_listing_auto_handler');
function create_listing_auto_handler() {
    if (!current_user_can('edit_posts')) wp_die('Unauthorized');

    $address   = isset($_POST['address']) ? sanitize_text_field($_POST['address']) : '';
    $price     = isset($_POST['price']) ? sanitize_text_field($_POST['price']) : '';
    $beds      = isset($_POST['beds']) ? sanitize_text_field($_POST['beds']) : '';
    $baths     = isset($_POST['baths']) ? sanitize_text_field($_POST['baths']) : '';
    $sqft      = isset($_POST['sqft']) ? sanitize_text_field($_POST['sqft']) : '';
    $link      = isset($_POST['link']) ? esc_url_raw($_POST['link']) : '';
    $image     = isset($_POST['image']) ? esc_url_raw($_POST['image']) : '';

    if (empty($address) || $address === 'New Property Listing') {
        echo "Error: Could not detect an address from your text.";
        wp_die();
    }

    $args = array(
        'title'                  => $address,
        'post_type'              => 'listing',
        'post_status'            => 'any',
        'posts_per_page'         => 1,
        'fields'                 => 'ids',
        'no_found_rows'          => true,
    );
    $query = new WP_Query($args);
    $existing_id = $query->have_posts() ? $query->posts[0] : null;
    
    $post_data = array(
        'post_title'   => $address,
        'post_content' => 'Automatically imported listing.', 
        'post_type'    => 'listing',
        'post_status'  => 'publish', 
    );

    if ($existing_id) {
        $post_data['ID'] = $existing_id;
        $result_id = wp_update_post($post_data, true);
    } else {
        $result_id = wp_insert_post($post_data, true);
    }

    if (is_wp_error($result_id)) {
        echo "Database Error: " . $result_id->get_error_message();
        wp_die();
    }

    update_post_meta($result_id, 'price', $price);
    update_post_meta($result_id, 'bedrooms', $beds);
    update_post_meta($result_id, 'bathrooms', $baths);
    update_post_meta($result_id, 'sq_ft', $sqft);
    update_post_meta($result_id, 'mls_link', $link);
    
    if (!empty($image)) {
        update_post_meta($result_id, '_thumbnail_ext_url', $image);
    }
    
    echo "Success! Property: " . $address . " has been strictly published into your Listings menu. (ID: " . $result_id . ")";
    wp_die();
}