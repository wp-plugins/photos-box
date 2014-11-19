<?php
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

/* SECTIONS - FIELDS
------------------------------------------------------*/
function photos_box_init_theme_opotion() {
	// 
	add_settings_section(
		'photos_box_display_section', 				// The ID to use for this section
		'Display Options',					// Title of this section
		'photos_box_display_section_display',		// Function Callback
		'photos_box-display-section'				// The ID use when render
	);
	add_settings_field('photos_box_display[disable_style]', 'Disable Style','photos_box_disable_style_display','photos_box-display-section','photos_box_display_section');
	
	register_setting( 'photos_box_settings','photos_box_display');
	
	wp_enqueue_style( 'photos-box-style-admin', WP_PB_URL. 'media/admin.css');	
}
add_action('admin_init', 'photos_box_init_theme_opotion');

/* CALLBACK
------------------------------------------------------*/
function photos_box_setting_display(){ 
	extract(shortcode_atts(array(
		'disable_style'	=> 0,
	), (array)get_option('photos_box_display')));
	
?>
	<div class="wrap photos_box_settings">
		<?php screen_icon() ?>
		<h2>Photos Box:</h2>
		<br />
		<h3>Settings:</h3>
		<form action="options.php" method="post">
			<?php settings_fields('photos_box_settings' ); ?>
			
			<input value="1" type="checkbox" name="photos_box_display[disable_style]" id="photos_box_display[disable_style]" <?php echo checked( 1, $disable_style, false );?>/>
			<label for="photos_box_display[disable_style]">Disable Style</label>

			<?php submit_button(); ?>
		</form>
		<br />
		<h3>Manual:</h3>
		<p><img src="<?php echo WP_PB_URL_IMAGES.'photos-box-manual.png';?>" alt="" /></p>
		<br />
		<br />
		<br />
		<ul>
			<li>
				<a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3N8HM67ZTCJD6">Donate to this Plugin</a>
			</li>
		</ul>
	</div>
<?php
}
