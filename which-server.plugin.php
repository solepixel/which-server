<?php
/**
 * Plugin Name: Which Server
 * Plugin URI: https://github.com/solepixel/which-server/
 * Description: Helps you identify which server you are working on.
 * Version: 1.0.0
 * Author: Brian DiChiara
 * Author URI: http://www.briandichiara.com
 */

define('WSP_VERSION', '1.0.0');
define('WSP_OPT_PREFIX', 'wsp_');
define('WSP_PATH', plugin_dir_path( __FILE__ ));
define('WSP_DIR', plugin_dir_url( __FILE__ ));

add_action( 'init', 'wsp_init' );

/**
 * wsp_init()
 * 
 * @return void
 */
function wsp_init(){
	add_action( 'admin_bar_menu', 'wsp_admin_bar_menu' );
	add_action( 'wp_enqueue_scripts', 'wsp_resources' );
}

/**
 * wsp_get_server()
 * 
 * @return
 */
function wsp_get_server(){
	return $_SERVER['SERVER_ADDR'];
}

/**
 * wsp_admin_bar_menu()
 * 
 * @return void
 */
function wsp_admin_bar_menu(){
	global $wp_admin_bar;
	
	$addr = wsp_get_server();
	$local = ($addr == '127.0.0.1');
	
	$which_server = array(
		'parent'	=> 'top-secondary', // puts it on the right side.
		'id'		=> 'wsp',
		'title'		=> '<span>'.( $local ? 'L' : 'R' ).'</span>',
		'href'		=> '#', // eventually link to options page
		'meta'		=> array(
			'title' => $addr
		)
	);
	
	$wp_admin_bar->add_menu($which_server);
}

/**
 * wsp_resources()
 * 
 * @return void
 */
function wsp_resources(){
	wp_register_style( 'wsp-style', WSP_DIR.'which-server.css', array( 'admin-bar' ), WSP_VERSION, 'screen' );
	wp_register_script( 'wsp-local', WSP_DIR.'which-server-local.js', array( 'jquery' ), WSP_VERSION );
	
	wp_localize_script( 'wsp-local', 'wsp_vars', array(
		'no_admin_bar' => ( !is_admin_bar_showing() ),
		'server_ip' => wsp_get_server(),
		'options_page' => '#' // coming soon.
	));
	
	wp_enqueue_style( 'wsp-style' );
	wp_enqueue_script( 'wsp-local' );
}
