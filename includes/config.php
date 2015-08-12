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
			'Photo Box Settings',
			'Photo Box',
			'manage_options',
			'photo-box-setting',
			'photo_box_setting_display'
		);
		$errors = array('type' => 0, 'color' => '' );
		$json = array('data'=>'', 'test' => 'ok');
		$messages = array( 'success'=> true, 'message' => '' );
	}
}
add_action('admin_menu','photo_box_add_options_page');