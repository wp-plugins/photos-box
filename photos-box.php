<?php
/*
Plugin Name: Photos Box
Description: Photos Box is an advanced plugin with a list of options for gallery. View Popup, Slideshow Popup
Plugin URI: https://wordpress.org/plugins/photos-box
Author: Hoa Lu
Author URI: http://photosbox.tk/
Version: 1.0.6
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
	
	if( $action == 'edit' ){
		require WP_PB_PATH_INCLUDES.'/admin.php';
	}
	
	require WP_PB_PATH_INCLUDES.'/setting.php';
	
} else {
	require WP_PB_PATH_INCLUDES.'/site.php';
}