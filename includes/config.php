<?php
defined('ABSPATH') or die;

/* ADD SETTINGS PAGE
------------------------------------------------------*/
function photos_box_add_options_page() {
	add_options_page(
		'Photos Box Settings',			// The text to be displayed in the browser title bar
		'Photos Box',					// The text to be used for the menu
		'manage_options',				// The required capability of users to access this menu
		'photos-box-setting',			// The slug by which this menu item is accessible
		'photos_box_setting_display'	// The name of the function used to display the page content
	);
	
}
add_action('admin_menu','photos_box_add_options_page');