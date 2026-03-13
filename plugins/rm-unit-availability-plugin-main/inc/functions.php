<?php 

acf_add_options_page(array(
    'page_title'    => 'RM Unit Availability Settings',
    'menu_title'    => 'UA Settings',
    'menu_slug'     => 'rmua-default-settings',
    'capability'    => 'edit_posts',
    'redirect'      => false
));

function rmunitavailability_acf_init() {
    if( function_exists('acf_register_block') ) {

        // registers a "color section" ACF block
        // default render_callback looks for a file in template-parts/blocks/content-{block name}.php

        acf_register_block(array(
            'name'              => 'featured-section',
            'title'             => __('Featured Section'),
            'description'       => __('Featured Listing section'),
            'render_callback'   => 'rmcore_render_block',
            'category'          => 'rmwebpro-blocks',
            'icon'              => 'heart',
            'mode'              => 'edit',
            'keywords'          => array( 'rmwebpro', 'rent manager', 'featured', 'listing' ),
        ));
       /* commenting until needed
        acf_register_block(array(
            'name'              => 'googlemap',
            'title'             => __('Google Map Section'),
            'description'       => __('Google Map of company location'),
            'render_callback'   => 'rmcore_render_block',
            'category'          => 'rmwebpro-blocks',
            'icon'              => 'location-alt',
            'mode'              => 'edit',
            'keywords'          => array( 'google', 'map', 'section', 'rent manager', 'rmwebpro' ),
        ));
        */
        
		acf_register_block(array(
            'name'              => 'availability-listing',
            'title'             => __('Rent Manager Listing'),
            'description'       => __('Listing of properties or units that pulls data from Rent Manager'),
            'render_callback'   => 'rmcore_render_block',
            'category'          => 'rmwebpro-blocks',
            'icon'              => 'admin-multisite',
            'mode'              => 'edit',
            'keywords'          => array( 'listing', 'properties', 'units', 'rent manager', 'rmwebpro' ),
        ));
		acf_register_block(array(
            'name'              => 'availability-detail',
            'title'             => __('Rent Manager Detail'),
            'description'       => __('Detail of property or unit that pulls data from Rent Manager'),
            'render_callback'   => 'rmcore_render_block',
            'category'          => 'rmwebpro-blocks',
            'icon'              => 'admin-home',
            'mode'              => 'edit',
            'keywords'          => array( 'detail', 'property', 'unit', 'rent manager', 'rmwebpro' ),
        ));
    }
}

add_action('acf/init', 'rmunitavailability_acf_init');

//Code to override Yoast's SEO meta tags	 Requires Yoast to be active

function add_rmua_meta_tags() {

	if(isset($_GET['pid']) || isset($_GET['uid'])){

		if(isset($_GET['pid'])) {
			$url_id = $_GET['pid'];
			$list_type = 'PropertyDetail';
			$id_type = 'propid';
			$title_property = 'pstreet1';
			$title_property_2 = 'pcsz';
			$description = 'propertyDescription';
			$id = 'ppid';
			$image = 'mainPropertyImage';
			$fallback_image = 'doesnotexist';
		}
		if(isset($_GET['uid'])) {
			$url_id = $_GET['uid'];
			$list_type = 'Detail_View';
			$id_type = 'unitID';
			$title_property = 'street1';
			$title_property_2 = 'csz';
			$description = 'unitDescription';
			$id = 'unitid';
			$image = 'mainUnitImage';
			$fallback_image = 'mainPropertyImage';
		}
        /* Replace with API call */
		$ogUAString = 'https://' . dbid() . '.ua.rentmanager.com/' . $list_type . '?' . $id_type . '=' . $url_id . '&id=' . $url_id . '&command=' . $list_type . '.aspx&corpid=' . dbid() . '&location=Default&mode=raw&template=rmwbdefault';

		$test = wp_remote_retrieve_body(wp_remote_get($ogUAString));
		$test = str_replace('&#10;',"", $test);
		$test = '[' . trim(substr($test,0,-2)) . '}]';
		$test = addcslashes($test, '"\\/');
		$test = str_replace('`','"',$test);
		$test = json_decode($test);

		$unit = $test[0];
		if(!empty($unit->{ $image })) {
			$imageInfo = getimagesize($unit->{ $image });
		}else if( !empty($unit->{ $fallback_image } ) ){
			$imageInfo = getimagesize($unit->{ $fallback_image} );
			$image = $fallback_image;
		}

		function get_string_between($string, $start, $end) {
			$string = ' ' . $string;
			$ini = strpos($string, $start);
			if ($ini == 0) return '';
			$ini += strlen($start);
			$len = strpos($string, $end, $ini) - $ini;
			return substr($string, $ini, $len);
		}

		add_filter('wpseo_title', function ($content) use ($unit, $title_property, $title_property_2) {
			return $unit->{ $title_property } . ' ' . $unit->{ $title_property_2 };
		});
		add_filter('wpseo_opengraph_url', function ($content) use ($unit) {
			$full_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			return $full_url;
		});

		add_filter( 'wpseo_opengraph_title', function( $content ) use ($unit, $title_property, $title_property_2) {
			return $unit->{ $title_property } . ' ' . $unit->{ $title_property_2 };
		}, 1);
		add_filter( 'wpseo_opengraph_image', function( $content ) use ($unit, $image) {
			return $unit->{ $image };
		}, 1);
		add_filter( 'wpseo_twitter_image', function( $content ) use ($unit, $image) {
					return $unit->{ $image };
			}, 1);
		add_filter( 'wpseo_canonical', function( $content ) use ($unit, $id) {
					$fullstring = $_SERVER['REQUEST_URI'];
					$parsedURL = get_string_between($fullstring, '/', '?');
					if(isset($_GET['pid'])) {
						$url_id_type = 'pid';
					}
					if(isset($_GET['uid'])) {
						$url_id_type = 'uid';
					}
					return site_url() . "/" . $parsedURL . "?" . $url_id_type . "=" . $unit->{ $id };
			}, 1);
		add_filter( 'wpseo_metadesc', function( $content ) use ($unit, $description) {
					return $unit->{ $description };
			}, 1);
		if(isset($imageInfo)) {
			add_action('wpseo_head',function() use ($imageInfo){
					echo '<meta property="og:image:height" content="' . $imageInfo[1] . '">';
					echo '<meta property="og:image:width" content="' . $imageInfo[0] . '">';
					echo '<meta property="og:image:type" content="image/jpeg">';
			}, 10);
		}

}}
add_action('init', 'add_rmua_meta_tags',1);

?>