<?php
/* Plugin Name: Facebook Overlay
Plugin URI: simplistics.ca
Description: Allows users to upload facebook profile photo with selected overlay image
Version: 1.0
Author: Simplistics
Author URI: simplistics.ca
*/

session_start();
/* DB TABLE CREATION 
--------------------------*/
function generate_db_table(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'facebook_users';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = 'CREATE TABLE '. $table_name .'(
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        first_name varchar(100),
        last_name varchar(100),
        email varchar(100),
        PRIMARY KEY (id)
    )'.$charset_collate.';';

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );   
}
register_activation_hook( __FILE__, 'generate_db_table' );


/* INCLUDES 
---------------- */

// generate acf fields to upload overlay image options 
require_once  plugin_dir_path(__FILE__) . 'includes/back-end-config.php';
//grab the sdk helper for facebook related functionality.
require_once plugin_dir_path(__FILE__) . 'phpsdk/src/Facebook/autoload.php'; 


//require all of the files needed into the function that generates the shortcode.
function fb_overlay_init(){
    //fb login logic
    
    require_once plugin_dir_path(__FILE__) .'includes/facebook-login.php';

    //is there a token present? if so, load the overlay view and logic. if not, load the sign-in modal.
    //sign in modal

   
    if ($needToLogin){
        require_once plugin_dir_path(__FILE__) .'views/sign-in-modal.php';
    }
    else {
        require_once plugin_dir_path(__FILE__) . 'includes/get-profile-picture.php';
        require_once plugin_dir_path(__FILE__) . 'views/overlay-interface.php';
    }

    
}
add_shortcode('facebook_overlay', 'fb_overlay_init');



