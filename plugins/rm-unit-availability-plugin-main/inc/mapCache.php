<?php

//bring in JavaScript, both mapping module and promises for es5
function init_rmmapcache_scripts(){

  wp_enqueue_script('rmmgc-js',plugin_dir_url( __FILE__ ).'inc/mapCache.js');
  wp_enqueue_script('es6-promise',plugin_dir_url( __FILE__ ).'inc/es6-promise.auto.min.js');
  wp_localize_script('rmmgc-js', 'WPURLS', array( 'ajaxlocation' => admin_url('admin-ajax.php') ));

}
add_action( 'init','init_rmmapcache_scripts');



class Address{
  public $address;
  public $lat;
  public $lng;
  public $status;
  public $fromDB;
}

class Output{
  public $status;
  public $result;
}

class AddressCollection{
  public $addresses = array();

  function process_addresses( $addresses ){
      global $wpdb;
      $table_name = $wpdb->prefix . "rmmgc";

      $results = $wpdb->get_results ( "
          SELECT address,lat,lng,time
          FROM $table_name", OBJECT_K );

      for( $i = 0; $i < sizeof( $addresses ) ; $i++ ){

        $this->process_address( $addresses[ $i ], $results );

      }
  }

  function process_address( $address, $results = null ){

    if( is_null( $results ) ) {
      global $wpdb;
      $table_name = $wpdb->prefix . "rmmgc";

      $results = $wpdb->get_results ( "
          SELECT address,lat,lng,time
          FROM $table_name", OBJECT_K );
    }

    $this_address = stripslashes( $address );
    $this_address = apply_filters( 'rmmgc_each_preprocessed_address', $this_address );
    $too_old = strtotime( date("Y-m-d", strtotime( '-29 days' ) ) );

    //loop through each address and see if there is a match, if not, create it
    if( isset( $results[ $this_address ] ) ){
      $then = strtotime( $results[ $this_address ]->time );
      if( $then < $too_old ){
        remove_address( $this_address ); //will be removed now, but used this last time
      }
      $addr = new Address();
      $addr->address = $this_address;
      $addr->lat = (float)$results[ $this_address ]->lat;
      $addr->lng = (float)$results[ $this_address ]->lng;
      $addr->status = 'OK';
      $addr->fromDB = true;
    }else{
      try{
        $new_addr_obj = add_address( $this_address );
        $addr = new Address();
        $addr->address = $this_address;
        $addr->lat = $new_addr_obj['lat'];
        $addr->lng = $new_addr_obj['lng'];
        $addr->status = 'OK';
        $addr->fromDB = false;
      }catch(Exception $e){
        $addr = new Address();
        $addr->address = $this_address;
        $addr->lat = null;
        $addr->lng = null;
        $addr->status = 'ERROR: ' . $e->getMessage();
      }
    }

    $this->addresses[ $this_address ] = $addr;
  }

}


function output( $output ){
  echo json_encode( $output );
  die();
}

/**
 * Primary ajax access function for this plugin, returning a dictionary of geocoded addresses that were provided
 */
function getAllGeocodesDict_func() {

  $collection = new AddressCollection();
  $output = new Output();

  try{

    if( !isset($_POST['addresses'])){
      throw new Exception("'addresses' not sent in post");
    }

    $my_addresses = $_POST['addresses'];
    $collection->process_addresses($my_addresses);
    $collection->addresses = apply_filters('rmmgc_finished_dictionary',$collection->addresses);

    $output->status = 'OK';
    $output->result = $collection->addresses;

  }catch (Exception $e){
    $output->status = 'ERROR';
    $output->result = 'Error getting geocoding dictionary: ' . $e->getMessage();
  }

  output( $output );

    // Always die in functions echoing ajax content
  die();
}
add_action( 'wp_ajax_getAllGeocodesDict', 'getAllGeocodesDict_func' );
add_action( 'wp_ajax_nopriv_getAllGeocodesDict', 'getAllGeocodesDict_func' );


/**
 *   Add a record in the database for this address after geocoding it
 */
function add_address( $address ){

  global $wpdb;
  $table_name = $wpdb->prefix . "rmmgc";

  $new_addr = geocode_address( $address );

  $new_obj = array(
      'time' => current_time( 'mysql' ),
      'address' => $address,
      'lat' => $new_addr[0],
      'lng' => $new_addr[1],
      'fromdb' => false
    );

  $wpdb->insert(
    $table_name,
    array(
        'time' => current_time( 'mysql' ),
        'address' => $address,
        'lat' => $new_addr[0],
        'lng' => $new_addr[1]
      )
  );

  return $new_obj;

}

/**
 * Remove address from db (i.e. too old)
 */
function remove_address( $address ){
  global $wpdb;
  $table_name = $wpdb->prefix . "rmmgc";

  $wpdb->delete(
    $table_name,
    array(
      "address" => $address
    )
    );
}

/**
 * Geocode address, it will throw exception if unable to geocode address
 */
function geocode_address( $address, $key = null){

    // url encode the address
    $address = urlencode( $address );

    //Optional provided key, to enable testing from backend
    if( is_null( $key ) ){
      $key = get_option('google_geocoding_api_key');
    }

    // google map geocode api url
    $rm_map_url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=$key";

    // get the json response
    $resp_json = file_get_contents($rm_map_url);

    // decode the json
    $resp = json_decode( $resp_json, true );

    // response status will be 'OK', if able to geocode given address
    if( $resp['status'] == 'OK' ){

        // get the important data
        $lati = $resp['results'][0]['geometry']['location']['lat'];
        $longi = $resp['results'][0]['geometry']['location']['lng'];
        $formatted_address = $resp['results'][0]['formatted_address'];


            // put the data in the array
            $data_arr = array();

            array_push(
                $data_arr,
                    $lati,
                    $longi,
                    $formatted_address
                );

            return $data_arr;

    }else{
      $result = "Geocoding error for: $address = " . $resp['status'];
      if( isset($resp['error_message']) ) $result .= " (" . $resp['error_message'] . ")";
      throw new Exception($result);
    }
}


/**--------------------------------------------------
 *           ADMIN SETUP, INTERFACE, COMMANDS
 *----------------------------------------------------*/

function reset_rmmgc_table(){
  global $wpdb;
  $table_name = $wpdb->prefix . "rmmgc";
  $wpdb->query("TRUNCATE $table_name");
  echo 'Success';
  die();
}
add_action( 'wp_ajax_reset_geocodes', 'reset_rmmgc_table' );



/**
 * Ajax handler to geocode address
 */
function geocode_address_ajax(){
  if( !isset( $_POST['address'] ) ){
    return;
  }

  $key = ( isset( $_POST['key'] ) ? $_POST['key'] : get_option('google_geocoding_api_key') );


  $address = $_POST['address'];
  try{
    $response = geocode_address( $address, $key );
    echo json_encode( $response );
  }catch (Exception $e){
    echo $e->getMessage();
  }
  die();
}
add_action( 'wp_ajax_geocode_address', 'geocode_address_ajax' );
add_action( 'wp_ajax_nopriv_geocode_address', 'geocode_address_ajax' );



register_activation_hook( __FILE__, 'rmmgc_install' );
function rmmgc_install(){
  //Create table
  //structure =  id,time,address,lat,lng

  global $wpdb;
  $table_name = $wpdb->prefix . "rmmgc";

  $charset_collate = $wpdb->get_charset_collate();
  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    address text NOT NULL,
    lat text NOT NULL,
    lng text NOT NULL,
    PRIMARY KEY  (id)
  ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );


}
//
// rmmgc_options[google_api_key]
//
//
//
// <?php
// create custom plugin settings menu
add_action('admin_menu', 'rmmgc_create_menu');

function rmmgc_create_menu() {

	//create new top-level menu
	add_menu_page('RM Map Cache settings', 'RM Map Cache', 'administrator', __FILE__, 'rmmgc_settings_page'  );

	//call register settings function
	add_action( 'admin_init', 'register_rmmgc_settings' );
}


function register_rmmgc_settings() {
	//register our settings
  register_setting( 'rmmgc-settings-group', 'google_api_key' );
  register_setting( 'rmmgc-settings-group', 'google_geocoding_api_key' );


}


function rmmgc_settings_page() {
  $currentKey = esc_attr( get_option('google_api_key') );
  $currentGeocodingKey = esc_attr( get_option('google_geocoding_api_key') );

echo '<div class="wrap"><h1>Map Cache</h1><form method="post" action="options.php">';
echo '<script>var ajaxURL = "' . admin_url('admin-ajax.php') . '";</script>';

settings_fields( 'rmmgc-settings-group' );
do_settings_sections( 'rmmgc-settings-group' );

$admin_url =  admin_url( 'admin-ajax.php' );

echo <<<HTML
    <table class="form-table" style="width:100%">
        <tr valign="top">
        <th scope="row">Google API Key - Map (HTTP Restrictions OK)</th>
        <td><input type="text" name="google_api_key" id="google_api_key" value="$currentKey" /></td>
        <td><button type="button" id="js-test-map-key">Test</button></td>
        </tr>
        <tr valign="top">
        <th scope="row">Google API Key - Geocoding (IP Restrictions OK)</th>
        <td><input type="text" name="google_geocoding_api_key" id="google_geocoding_api_key" value="$currentGeocodingKey" /></td>
        <td><button type="button" id="js-test-geocoding-key">Test</button></td>
        </tr>

    </table>
    <div id="map-canvas" style="width:300px;height:300px"></div>
    <h2>Usage</h2>
    <p>Access API key above using <code>get_option('google_api_key');</code></p>
    <p>Access Geocoding Key (you shouldn't need to) above using <code>get_option('google_geocoding_api_key');</code></p>
    <p>Create a geocacher object with an array of addresses, then ask it what the latitude and longitude of an address is.</p>
    <p>It handles geocoding it with google, and also caches it in your WordPress database.</p>
    <p><b>Example</b></p>
    <pre><code>
      var myPropertyAddresses = ['453 Meadowcrest Cir., Memphis, TN 38117','560 Ludwig Ave., Mason, OH 45040'];
      var myGeocacher = geocacher(myPropertyAddresses);
      myGeocacher.ready(function(){
          var childhoodHome = myGeocacher.getLatLng(myPropertyAddresses[0]);
          console.log(childhoodHome.lat); // 35.119056
          console.log(childhoodHome.lng); // -89.890636

      });
    </code></pre>
    <button type="button" onclick="reset_geocodes()" id="reset_rmmgc_button">Clear stored geocoded data</button>
    <script>

    jQuery('body').on('click','#js-test-map-key',function(){
      testMapKey( jQuery('#google_api_key').val() );
      jQuery( this ).attr('disabled','disabled');
    });

     jQuery('body').on('click','#js-test-geocoding-key',function(){
      testGeocodingKey( jQuery('#google_geocoding_api_key').val() );
    });



    function testGeocodingKey( key ){
      jQuery.ajax({
            url: '$admin_url',
            type: 'post',
            data: {
              action: 'geocode_address',
              address : '1600 Pennsylvania Ave NW, Washington, DC 20500',
              key : key
            },
            success:function(r) {
              alert( JSON.stringify(r) );
            },
            error: function(e){
              alert( JSON.stringify(e) );
            }
        });
      }


    function testMapKey( key ){

      var gMapsLoaded = false;
      window.gMapsCallback = function(){
          gMapsLoaded = true;
          jQuery(window).trigger('gMapsLoaded');
      }
      window.loadGoogleMaps = function( key ){
          if(gMapsLoaded) return window.gMapsCallback();
          var script_tag = document.createElement('script');
          script_tag.setAttribute("type","text/javascript");
          script_tag.setAttribute("src","https://maps.google.com/maps/api/js?sensor=false&callback=gMapsCallback&key=" + key);
          (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
      }
      function initialize(){
        var mapOptions = {
            zoom: 8,
            center: new google.maps.LatLng(47.3239, 5.0428),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
      }
      jQuery(window).bind('gMapsLoaded', initialize);
      window.loadGoogleMaps( key );
    }



    function reset_geocodes(){
    jQuery.ajax({
            url: ajaxURL,
            type: 'post',
            data: {
                'action':'reset_geocodes'
            },
            success:function(r) {
              console.log(r);
            },
            error: function(e){
                console.log(e);
            }
        });
      }
        </script>
HTML;
    submit_button();
    echo '</form></div>';

}

?>
