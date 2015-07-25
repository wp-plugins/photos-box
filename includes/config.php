<?php
/*
 * Au: http://photoboxone.com
 */
defined('ABSPATH') or die('<meta http-equiv="refresh" content="0;url='.WP_PB_URL_AUTHOR.'">');

/* ADD SETTINGS PAGE
------------------------------------------------------*/
if( !function_exists('photo_box_add_options_page') ){
	function photo_box_add_options_page() {
		add_options_page(
			'Photo Box Settings',			// The text to be displayed in the browser title bar
			'Photo Box',					// The text to be used for the menu
			'manage_options',				// The required capability of users to access this menu
			'photo-box-setting',			// The slug by which this menu item is accessible
			'photo_box_setting_display'	// The name of the function used to display the page content
		);
		
	}
}
add_action('admin_menu','photo_box_add_options_page');