<?php
/*
Plugin Name: Photo Box
Description: Photo Box is an advanced plugin with a list of options for gallery. View Popup, Slideshow Popup
Plugin URI: https://wordpress.org/plugins/photos-box
Author: De Mo
Author URI: http://photoboxone.com/
Version: 1.0.9
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('ABSPATH') or die;

define('WP_PB_PATH', dirname(__FILE__) ); 
define('WP_PB_PATH_INCLUDES', dirname(__FILE__).'/includes' ); 
define('WP_PB_URL', plugins_url('', __FILE__).'/' ); 
define('WP_PB_URL_IMAGES', WP_PB_URL.'images/' ); 

if( is_admin() ){
	require WP_PB_PATH_INCLUDES.'/config.php';
	
	$action = isset($_GET['action'])?$_GET['action']:'';
	$page 	= isset($_GET['page'])?$_GET['page']:'';
	$plugins = preg_match('/plugins.php/i',$_SERVER['REQUEST_URI']);
	
	if( $plugins ){
		
		add_filter("plugin_action_links_".plugin_basename(__FILE__), "photos_box_plugin_actions", 10, 4);
		function photos_box_plugin_actions( $actions, $plugin_file, $plugin_data, $context ) {
			array_unshift($actions, "<a href=\"http://photoboxone.com/donate\" target=\"_blank\">".__("Donate")."</a>");
			array_unshift($actions, "<a href=\"http://photoboxone.com/documents\" target=\"_blank\">".__("Documents")."</a>");
			array_unshift($actions, "<a href=\"options-general.php?page=photos-box-setting\">".__("Settings")."</a>");
			return $actions;
		}
	}
	
	if( $action == 'edit' ){
		require WP_PB_PATH_INCLUDES.'/admin.php';
	}
	
	if( $page == 'photos-box-setting' ){
		require WP_PB_PATH_INCLUDES.'/setting.php';
	}
	
} else {
	require WP_PB_PATH_INCLUDES.'/site.php';
}
