<?php
/*
Plugin Name: Photos Box
Description: Display Gallery Popup
Plugin URI:
Author: Hoa Lu
Author URI:
Version: 1.0
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

define('WP_PB_PATH', dirname(__FILE__) ); 
define('WP_PB_PATH_INCLUDES', dirname(__FILE__).'/includes' ); 
define('WP_PB_URL', plugins_url('', __FILE__).'/' ); 
define('WP_PB_URL_IMAGES', WP_PB_URL.'images/' ); 



if( is_admin() ){
	require WP_PB_PATH_INCLUDES.'/admin.php';
	require WP_PB_PATH_INCLUDES.'/config.php';
} else {
	require WP_PB_PATH_INCLUDES.'/site.php';
}