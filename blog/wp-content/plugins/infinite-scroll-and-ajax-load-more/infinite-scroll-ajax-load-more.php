<?php
/**
 * Plugin Name: Infinite Scroll and Ajax Load More
 * Plugin URI: 
 * Description: Creating Load More button for WordPress Post. As an option will show you how to load more posts on scroll.
 * Version: 1.0.0
 * Author: Arpit Patel
 * Author URI: https://wordpress.org/support/users/arpit-patel/
 * Text Domain: wpajax
 * Domain Path: languages
 * 
 * @package Bliss loadmore
 * @category Core
 * @author blisswebsolution
 */
/**
 * Basic plugin definitions 
 * 
 * @package Bliss loadmore
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

global $wpdb;

/**
 * Basic Plugin Definitions 
 * 
 * @package Bliss AJAX loadmore
 * @since 1.0.0
 */
if( !defined( 'BLISS_AJAX_LOADMORE_VERSION' ) ) {
	define( 'BLISS_AJAX_LOADMORE_VERSION', '1.0.0' ); //version of plugin
}
if( !defined( 'BLISS_AJAX_LOADMORE_DIR' ) ) {
	define( 'BLISS_AJAX_LOADMORE_DIR', dirname( __FILE__ ) ); // plugin dir add like BLISS_AJAX_LOADMORE_DIR . '/templates/';
}
if( !defined( 'BLISS_AJAX_LOADMORE_ADMIN' ) ) {
	define( 'BLISS_AJAX_LOADMORE_ADMIN', BLISS_AJAX_LOADMORE_DIR . '/admin' ); // plugin admin dir
}
if( !defined( 'BLISS_AJAX_LOADMORE_URL' ) ) {
	define( 'BLISS_AJAX_LOADMORE_URL', plugin_dir_url( __FILE__ ) ); // plugin url
}
if( !defined( 'BLISS_AJAX_LOADMORE_IMG_URL' ) ) {
	define( 'BLISS_AJAX_LOADMORE_IMG_URL', BLISS_AJAX_LOADMORE_URL . 'images' ); // plugin image url
}
if( !defined( 'BLISS_AJAX_LOADMORE_TEXT_DOMAIN' ) ) {
	define( 'BLISS_AJAX_LOADMORE_TEXT_DOMAIN', 'wpajax' ); // text domain for doing language translation
}
//metabox prefix
if( !defined( 'BLISS_AJAX_LOADMORE_META_PREFIX' )) {
	define( 'BLISS_AJAX_LOADMORE_META_PREFIX', '_bliss_ajax_loadmore_' );
}
if( !defined( 'BLISS_AJAX_LOADMORE_PLUGIN_BASENAME' ) ) {
	define( 'BLISS_AJAX_LOADMORE_PLUGIN_BASENAME', basename( BLISS_AJAX_LOADMORE_DIR ) ); //Plugin base name
}
/**
 * Load Text Domain
 * 
 * This gets the plugin ready for translation.
 * 
 * @package Bliss AJAX loadmore
 * @since 1.0.0
 */
function bliss_ajax_loadmore_load_textdomain() {
	
 // Set filter for plugin's languages directory
	$bliss_ajax_loadmore_lang_dir	= dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	$bliss_ajax_loadmore_lang_dir	= apply_filters( 'bliss_ajax_loadmore_languages_directory', $bliss_ajax_loadmore_lang_dir );
	
	// Traditional WordPress plugin locale filter
	$locale	= apply_filters( 'plugin_locale',  get_locale(), 'bl-scroll' );
	$mofile	= sprintf( '%1$s-%2$s.mo', 'bl-scroll', $locale );
	
	// Setup paths to current locale file
	$mofile_local	= $bliss_ajax_loadmore_lang_dir . $mofile;
	$mofile_global	= WP_LANG_DIR . '/' . BLISS_AJAX_LOADMORE_PLUGIN_BASENAME . '/' . $mofile;
	
	if ( file_exists( $mofile_global ) ) { // Look in global /wp-content/languages/wp-ajax folder
		load_textdomain( 'bl-scroll', $mofile_global );
	} elseif ( file_exists( $mofile_local ) ) { // Look in local /wp-content/plugins/wp-ajax/languages/ folder
		load_textdomain( 'bl-scroll', $mofile_local );
	} else { // Load the default language files
		load_plugin_textdomain( 'bl-scroll', false, $bliss_ajax_loadmore_lang_dir );
	}
  
}

/**
 * Activation hook
 * 
 * Register plugin activation hook.
 * 
 * @package Bliss AJAX loadmore
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'bliss_ajax_loadmore_install' );

/**
 * Deactivation hook
 *
 * Register plugin deactivation hook.
 * 
 * @package Bliss AJAX loadmore
 * @since 1.0.0
 */
register_deactivation_hook( __FILE__, 'bliss_ajax_loadmore_uninstall' );

/**
 * Plugin Setup Activation hook call back 
 *
 * Initial setup of the plugin setting default options 
 * and database tables creations.
 * 
 * @package Bliss AJAX loadmore
 * @since 1.0.0
 */
function bliss_ajax_loadmore_install() {
	
	global $wpdb;
}

/**
 * Plugin Setup (On Deactivation)
 *
 * Does the drop tables in the database and
 * delete  plugin options.
 *
 * @package Bliss AJAX loadmore
 * @since 1.0.0
 */
function bliss_ajax_loadmore_uninstall() {
	
	global $wpdb;
}

/**
 * Load Plugin
 * 
 * Handles to load plugin after
 * dependent plugin is loaded
 * successfully
 * 
 * @package Bliss AJAX loadmore
 * @since 1.0.0
 */
function bliss_ajax_loadmore_plugin_loaded() {
 
	// load first plugin text domain
	bliss_ajax_loadmore_load_textdomain();
}

//add action to load plugin
add_action( 'plugins_loaded', 'bliss_ajax_loadmore_plugin_loaded' );

include( BLISS_AJAX_LOADMORE_ADMIN . '/bliss-loadmore-setting.php');
include( BLISS_AJAX_LOADMORE_DIR . '/public/bliss-ajax-loadmore-front.php');

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links' );

function add_action_links ( $links ) {
 $mylinks = array(
 '<a href="' . admin_url( 'options-general.php?page=bliss-ajax-loadmore' ) . '">Settings</a>',
 );
return array_merge( $links, $mylinks );
}

?>