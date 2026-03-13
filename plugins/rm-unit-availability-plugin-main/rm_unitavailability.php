<?php
/*
Plugin Name:  Rent Manager Unit Availability
Plugin URI:   https://rentmanager.com
Description:  Custom-built unit availability plugin 
Version:      1.1
Author:       Rent Manager 
Author URI:   https://rentmanager.com

*/

$dbid = get_field('co_code', 'options');
$unitTemplate = get_field('unit_temp', 'options');
$propertyTemplate = get_field('property_temp', 'options');
$date = date('Y-m-d');
$rmua_url = 'https://ua-api.rentmanager.com/get_ua_int_ua.php';
$rm_cache = true;
$locations = sanitize_text_field(get_field('rm_location', 'options')); //Can add through WordPress

if(!$locations){
    $locations = "default";
}

//ACF Registration
require_once(plugin_dir_path(__FILE__) . 'inc/acf-registration.php');

function add_ua_styles()
{
    $pluginURL = plugin_dir_url(__FILE__);
   
    wp_enqueue_style('listings-style', $pluginURL . 'css/listing.css');
    wp_enqueue_style('lightbox-style', $pluginURL . 'inc/lightbox/css/lightbox.css');
    wp_enqueue_script('lightbox-script', $pluginURL . 'inc/lightbox/js/lightbox.js', array('jquery'));
    wp_enqueue_script('filters', $pluginURL . 'inc/js/filters.js', array('jquery'));
  
}
add_action('wp_enqueue_scripts', 'add_ua_styles');

//function to generate transient name. Setting it up here to maintain consistency whenever we need to generate a transient name
function rentmanager_generate_transient_name($uaurl, $api_ua_options, $dbid, $locations) {
    return 'rentmanager_ua_' . md5(serialize([$uaurl, $api_ua_options, $dbid, $locations]));
}

function rentmanager_get_ua($uaurl, $api_ua_options, $dbid, $locations = 'default')
{   
    // Log that the function has been called
    error_log('rentmanager_get_ua function called.');

    // Log the parameters passed to the function for debugging
    // error_log('rentmanager_get_ua parameters:');
    // error_log('URL: ' . $uaurl);
    // error_log('API Options: ' . var_export($api_ua_options, true));
    // error_log('DB ID: ' . $dbid);
    // error_log('Locations: ' . $locations);

    // Initialize variable to store cached data if available
    $rm_cached_data = false;
    global $rm_cache;

    // Log the global cache setting
    error_log('rm_cache value: ' . var_export($rm_cache, true));

    // Check if caching is enabled
    if ($rm_cache) {
        // Generate a unique name for the cache based on parameters
        $transient_name = rentmanager_generate_transient_name($uaurl, $api_ua_options, $dbid, $locations);
        // error_log('Generated Transient Name: ' . $transient_name);

        // Try to retrieve cached data
        $rm_cached_data = get_transient($transient_name);
        if ($rm_cached_data !== false) {
            // If cached data is found, log and return it
            // error_log('Using cached data for transient: ' . $transient_name);
            // error_log('Exiting function early with cached data.');
            return $rm_cached_data;
         }
        // else {
        //     // If no cached data is found, log the event
        //     error_log('No cached data found for transient: ' . $transient_name);
        // }
    }

    // Proceed with making an API call if no cached data is available
    if (false === $rm_cached_data) {
        // error_log('No cached data, proceeding with API call...');

        $api_error = "";
        $fullList = array(); // Array to hold the aggregated response
        global $rmua_url;
        $splitLocations = explode(',', $locations); // Split locations into an array

        // Iterate through each location
        foreach ($splitLocations as $location) {
            $api_ua_options['LocationName'] = $location; // Set the location option
            $data = array('dbid' => $dbid, 'api_ua_options' => $api_ua_options, 'url' => $uaurl);

            // Set up the HTTP POST request options
            $options = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => http_build_query($data),
                ),
            );

            $context = stream_context_create($options); // Create the context for the request

            // Perform the HTTP request and retrieve the response
            $response = file_get_contents($rmua_url, false, $context);
            $response = trim($response); // Clean up the response
            $response = json_decode($response); // Decode JSON response

            // Log the API response for debugging
            // error_log('API response: ' . var_export($response, true));

            // Process the response
            if (is_array($response)) {
                // Add location information to each entity
                foreach ($response as $entity) {
                    $entity->location = $location;
                }
                // Merge the response with the full list
                $fullList = array_merge($fullList, $response);

            } else if(is_object($response) && isset($response->Exception)){
                //Do not add to array if error in location
                $api_error .= esc_html($response->DeveloperMessage);
                continue;
            }else {
                // If response is not an array, replace the full list
                if(empty($fullList)){
                    $fullList = $response;
                } else {
                    // If response has data from prev location, append it
                    $fullList[] = $response;
                }
            }
        }

        $response = $fullList; // Finalize the response
        
        //For Dev
        if(empty($response) && $api_error){
            $response = "API Error: ". $api_error. ". ";
        }

        // Log detailed information about the response
        // error_log('Response is array: ' . var_export(is_array($response), true));
        //error_log('Response size: ' . sizeof($response));

        // Cache the response if caching is enabled and response is valid
        if ($rm_cache && (is_array($response)) && (sizeof($response) > 0)) {
            $set_result = set_transient($transient_name, $response, 3600);
            // if ($set_result) {
            //     error_log('Transient set successfully: ' . $transient_name);
            //     error_log('Transient value: ' . var_export($response, true));
            // } else {
            //     error_log('Failed to set transient: ' . $transient_name);
            // }
        } else {
            // Log if caching was not performed
            error_log('Transient not set due to failed condition check.');
        }
    }

    // Log completion of the function
    // error_log('rentmanager_get_ua function completed.');

    // Cache the response for the current request and return it
    $request_cache = $response;
    return $response;
}



function flush_rentmanager_cache() {
    global $wpdb;

    // Ensure caching is enabled
    global $rm_cache;
    if (!$rm_cache) {
        error_log('Cache is disabled.');
        return false; 
    }

    // SQL query to delete all transients related to Rent Manager
    $rows_deleted = $wpdb->query(
        "DELETE FROM $wpdb->options WHERE option_name LIKE '%\_transient\_rentmanager\_ua\_%'"
    );

    if ($rows_deleted > 0) {
        error_log("Successfully deleted $rows_deleted transients.");
        return true;
    } else {
        error_log('No matching transients found to delete.');
        return false;
    }
}



add_action('admin_bar_menu', 'add_item', 100);

function add_item( $admin_bar ){
    $admin_bar->add_menu( array(  
        'id' => 'refresh_cached_ua',
        'title' => 'Refresh Cached UA',
        'href' => '#',
        'meta' => array(
            'class' => 'refresh-cached',
            'title' => 'Refresh Cached UA',
            'onclick' => 'refreshCachedUA(); return false;', 
        ),
    ));
}
//JS handle click for cache clear
add_action('wp_enqueue_scripts', 'enqueue_admin_scripts');
add_action('admin_enqueue_scripts', 'enqueue_admin_scripts');

function enqueue_admin_scripts() {
    wp_enqueue_script('refresh-cache-script', plugin_dir_url(__FILE__) . 'inc/js/refresh-cache.js', array('jquery'), null, true );

    wp_localize_script('refresh-cache-script', 'refreshCacheAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('refresh_cache_nonce')
    ));
}
//Handle Ajax request and clear cache
add_action('wp_ajax_refresh_cached_ua', 'handle_refresh_cached_ua');

function handle_refresh_cached_ua() {
    check_ajax_referer('refresh_cache_nonce', 'nonce');

    // Log to verify that the function is being called
    error_log('AJAX request received to clear cache.');

    // Re-define the necessary variables
    $rmua_url = 'https://ua-api.rentmanager.com/get_unit_availability.php';
    $dbid = get_field('co_code', 'options');
    $unitTemplate = get_field('unit_temp', 'options');
    $propertyTemplate = get_field('prop_temp', 'options');
    global $locations;

    // Error handling
    $missing_fields = array();
    
    if (!$dbid) {
        $missing_fields[] = 'dbid (co_code)';
    }
    if (!$unitTemplate) {
        $missing_fields[] = 'unitTemplate (unit_temp)';
    }
    if (!$propertyTemplate) {
        $missing_fields[] = 'propertyTemplate (prop_temp)';
    }

    if (!empty($missing_fields)) {
        $missing_fields_list = implode(', ', $missing_fields);
        $error_message = 'Error: The following required fields are missing: ' . $missing_fields_list;
        error_log($error_message);
        wp_send_json_error(array('message' => $error_message));
        return;
    }

    // Construct api_ua_options
    $api_ua_options = array('unit_template' => $unitTemplate, 'property_template' => $propertyTemplate);

    // Attempt to clear the cache
    $result = flush_rentmanager_cache();

    // Log and return success or failure
    if ($result) {
        error_log('Cache cleared successfully.');
        wp_send_json_success(array('message' => 'Cache cleared successfully.'));
    } else {
        error_log('Failed to clear the cache.');
        wp_send_json_error(array('message' => 'Failed to clear the cache.'));
    }
}

//Property Listing

function rentmanager_propertylisting($atts)
{
    ob_start();
    $default = array(
        'listtype' => 'all',
    );
    $a = shortcode_atts($default, $atts);
  
    $listType = $a['listtype'];

    global $date;
    global $dbid;
    global $propertyTemplate;
    global $locations;

    $api_ua_options = array(
        "PropertyFilters" => [],
        "AsOfDate" => $date,
        "StartDate" => null,
        "EndDate" => null,
        "ProfileName" => $propertyTemplate,
        //"LocationName" => "Test",
        "MetaTag" => null
    );

    $rmua_url = 'https://' . $dbid . '.api.rentmanager.com/Properties/Availability';
    $response = rentmanager_get_ua($rmua_url, $api_ua_options, $dbid, $locations);

    // echo "<pre>";
    // print_r($response);
    // echo "</pre>";
    
    include_once('inc/build/build_property.php');
    include_once('inc/acf_listing_options.php');
    $propertyListObject = new PropertyList();

    //Only Loop Over Reponse if valid
    if(!is_string($response)){
        foreach ($response as $rm_property) {
            $propertyListObject->addProperty(new Property($rm_property));
        }
        $propertyList = $propertyListObject->properties;
    } else {
        $propertyList = array();
    }

    include_once(plugin_dir_path(__FILE__) . '/inc/template-functions.php');
    if ($listType == "featured") {
        include_once(plugin_dir_path(__FILE__) . '/templates/featured_list.php');
    } else {
        include_once(plugin_dir_path(__FILE__) . '/templates/property_list.php');
    }

    include_once(plugin_dir_path(__FILE__) . '/inc/acf_listing_options.php');

    ?>

    <?php

    return ob_get_clean();
}
add_shortcode('rm_propertyavailability', 'rentmanager_propertylisting');

//Unit Listing
function rentmanager_unitlisting($atts)
{

    ob_start();
    global $date;
    global $dbid;
    global $unitTemplate;
    global $locations;

    $api_ua_options = array(
        "UnitFilters" => [],
        "AsOfDate" => $date,
        "StartDate" => null,
        "EndDate" => null,
        "ProfileName" => $unitTemplate,
        //"LocationName" => "Test",
        "MetaTag" => null
    );

    $rmua_url = 'https://' . $dbid . '.api.rentmanager.com/Units/Availability';
    $response = rentmanager_get_ua($rmua_url, $api_ua_options, $dbid, $locations);



    //      echo "<pre>";
    //   print_r($response);
    //     echo "</pre>";


    include_once('inc/build/build_property.php');
    include_once('inc/build/build_unit.php');
    include_once('inc/acf_listing_options.php');
    $unitListObject = new UnitList();

    //Only Loop Over Valid Response
    if(!is_string($response)) {
        foreach ($response as $rm_unit) {
            $unitListObject->addUnit(new Unit($rm_unit));
        }
        $unitList = $unitListObject->units;
    } else {
        $unitList = array();
    }

    include_once(plugin_dir_path(__FILE__) . '/inc/template-functions.php');
    include_once(plugin_dir_path(__FILE__). '/templates/search_form.php');
    include_once(plugin_dir_path(__FILE__) . '/templates/unit_list.php');
    include_once(plugin_dir_path(__FILE__) . '/inc/acf_listing_options.php');

   


    ?>

    <?php
    return ob_get_clean();

}


add_shortcode('rm_unitavailability', 'rentmanager_unitlisting');


//Unit Detail
function rentmanager_detail_page_get()
{
    // Code to run on init before the shortcode is executed
    ob_start();
    if (isset($_GET['uid'])) {
        $uid = $_GET['uid'];
        if(isset($_GET['location'])){
            
            $location = sanitize_text_field($_GET['location']);
        }
        else{
            $location = $locations;
        }


        global $date;
        global $dbid;
        global $unitTemplate;


        $api_ua_options = array(
            "UnitFilters" => [],
            "AsOfDate" => $date,
            "StartDate" => null,
            "EndDate" => null,
            "ProfileName" => $unitTemplate,
           // "LocationName" => "Test",
            "MetaTag" => null
        );

        $rmua_url = 'https://' . $dbid . '.api.rentmanager.com/Units/' . $uid . '/Availability';
        $response = rentmanager_get_ua($rmua_url, $api_ua_options, $dbid, $location);


        // echo "<pre>";
        //  print_r($response);
        //  echo "</pre>";


        include_once(plugin_dir_path(__FILE__) . 'inc/build/build_property.php');
        include_once(plugin_dir_path(__FILE__) . 'inc/build/build_unit.php');
        include_once(plugin_dir_path(__FILE__) . '/inc/acf_listing_options.php');
        //include('inc/property_formatted_html.php');
        $unit = new Unit($response);
        global $unit_detail_data;
        $unit_detail_data = $unit;
        function rentmanager_unitdetail($atts)
        {


            global $unit_detail_data;
            //include('inc/property_formatted_html.php');
            $unit = $unit_detail_data;


            include_once(plugin_dir_path(__FILE__) . '/inc/template-functions.php');
            include_once(plugin_dir_path(__FILE__) . '/templates/unit_detail.php');




            ?>

            <?php

            return ob_get_clean();

            // Filters
            // 

        }


        add_shortcode('rm_unitdetail', 'rentmanager_unitdetail');


        function rm_ua_detail_title($title, $post_id)
        {
            // Check if the current post has the shortcode in its content
            if (has_shortcode(get_post()->post_content, 'rm_unitdetail')) {
                // Modify the title
                global $unit_detail_data;
                $title = $unit_detail_data->unitName;
            }
            return $title;
        }
        add_filter('the_title', 'rm_ua_detail_title', 10, 2);

        function wpnav_remove_title_filter_nav_menu_unit($nav_menu, $args)
        {
            // we are working with menu, so remove the title filter
            remove_filter('the_title', 'rm_ua_detail_title', 10, 2);
            return $nav_menu;
        }
        // this filter fires just before the nav menu item creation process
        add_filter('pre_wp_nav_menu', 'wpnav_remove_title_filter_nav_menu_unit', 10, 2);

        function wpnav_add_title_filter_non_menu_unit($items, $args)
        {
            // we are done working with menu, so add the title filter back
            add_filter('the_title', 'rm_ua_detail_title', 10, 2);
            return $items;
        }
        // this filter fires after nav menu item creation is done
        add_filter('wp_nav_menu_items', 'wpnav_add_title_filter_non_menu_unit', 10, 2);
    }
}


add_action('init', 'rentmanager_detail_page_get', 5);

?>
<?php

//Property Detail

function rentmanager_prop_detail_page_get()
{
    // Code to run on init before the shortcode is executed
    ob_start();
    global $date;
    global $dbid;
    global $propTemplate;
    global $locations;
    

    if (isset($_GET['pid'])) {
        $pid = $_GET['pid'];
        if(isset($_GET['location'])){
            
            $location = sanitize_text_field($_GET['location']);
        }
        else{
            $location = $locations;
        }

        $api_ua_options = array(
            "PropertyFilters" => [],
            "AsOfDate" => $date,
            "StartDate" => null,
            "EndDate" => null,
            "ProfileName" => $propTemplate,
            //"LocationName" => "Test",
            "MetaTag" => null
        );

        $rmua_url = 'https://' . $dbid . '.api.rentmanager.com/Properties/' . $pid . '/Availability';
        $response = rentmanager_get_ua($rmua_url, $api_ua_options, $dbid, $location);

        // echo "<pre>";
        // print_r($response);
        // echo "</pre>";


        include_once('inc/build/build_property.php');
        include_once('inc/build/build_unit.php');
        include_once('inc/acf_listing_options.php');
        //include('inc/property_formatted_html.php');
        $property = new Property($response);
        global $prop_detail_data;
        $prop_detail_data = $property;
        function rentmanager_propertydetail($atts)
        {

            global $prop_detail_data;
            //include('inc/property_formatted_html.php');
            $property = $prop_detail_data;
            ;


            include_once(plugin_dir_path(__FILE__) . '/inc/template-functions.php');
            include_once(plugin_dir_path(__FILE__) . '/templates/property_detail.php');

            ?>

            <?php

            return ob_get_clean();

            // Filters
            // 

        }


        add_shortcode('rm_propertydetail', 'rentmanager_propertydetail');


        function rm_ua_propdetail_title($title, $post_id)
        {
            // Check if the current post has the shortcode in its content
            if (has_shortcode(get_post()->post_content, 'rm_propertydetail')) {
                // Modify the title
                global $prop_detail_data;
                $title = $prop_detail_data->propName;
            }
            return $title;
        }
        add_filter('the_title', 'rm_ua_propdetail_title', 10, 2);

        function wpnav_remove_title_filter_nav_menu_prop($nav_menu, $args)
        {
            // we are working with menu, so remove the title filter
            remove_filter('the_title', 'rm_ua_propdetail_title', 10, 2);
            return $nav_menu;
        }
        // this filter fires just before the nav menu item creation process
        add_filter('pre_wp_nav_menu', 'wpnav_remove_title_filter_nav_menu_prop', 10, 2);

        function wpnav_add_title_filter_non_menu_prop($items, $args)
        {
            // we are done working with menu, so add the title filter back
            add_filter('the_title', 'rm_ua_propdetail_title', 10, 2);
            return $items;
        }
        // this filter fires after nav menu item creation is done
        add_filter('wp_nav_menu_items', 'wpnav_add_title_filter_non_menu_prop', 10, 2);
    }
}

add_action('init', 'rentmanager_prop_detail_page_get', 5);

//Unit List on Property           

function rentmanager_unit_list_on_prop($atts)
{
    $default = array(
        'propertyidlist' => '5',
    );
    $a = shortcode_atts($default, $atts);
    $propertyIDs = explode(',', $a['propertyidlist']);
    $propertyIDs = array_map(function ($value) {
        return "'" . trim($value) . "'";
    }, $propertyIDs);

    $propertyIDsString = '[' . implode(', ', $propertyIDs) . ']';

    global $date;
    global $dbid;
    global $unitTemplate;
    global $locations;

    if(isset($_GET['location'])){
            
        $location = sanitize_text_field($_GET['location']);
    }
    else{
        $location = $locations;
    }


    $api_ua_options = array(
        'UnitFilters' => [
            array(
                'Field' => 'PropertyID',
                'FilterOperation' => 'In',
                'Values' => eval("return $propertyIDsString;")
            )
        ],
        'AsOfDate' => $date,
        'StartDate' => null,
        'EndDate' => null,
        'ProfileName' => $unitTemplate,
       // 'LocationName' => 'Test',
        'MetaTag' => null
    );
    $rmua_url = 'https://' . $dbid . '.api.rentmanager.com/Units/Availability';
    $response = rentmanager_get_ua($rmua_url, $api_ua_options, $dbid, $location);


    //echo "<pre>";
    // print_r($response);
    // echo "</pre>"; 


    //include('inc/build/build_unit.php');
    $PropUnitList = "";
    $propUnitListObject = new UnitList();
    if ($response && !is_string($response)) {
        foreach ($response as $rm_unit) {
            $propUnitListObject->addUnit(new Unit($rm_unit));
        }
        $PropUnitList = $propUnitListObject->units;
    }
    include_once(plugin_dir_path(__FILE__) . '/inc/template-functions.php');
    include_once(plugin_dir_path(__FILE__) . '/templates/property_unit_list.php');

    ?>

<?php


}

add_shortcode('rm_unitlistproperty', 'rentmanager_unit_list_on_prop');

//Map 
function get_rm_map()
{
    wp_enqueue_script('rm_map_js');
    wp_localize_script('rm_map_js', 'php_vars', array(
        'plugindir' => plugin_dir_url(__FILE__),
    )
    );
}

add_action('get_map', 'get_rm_map');




?>