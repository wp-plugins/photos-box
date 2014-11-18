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
	/*add_settings_section(
		'photos_box_display_section', 				// The ID to use for this section
		'Display Options',					// Title of this section
		'photos_box_display_section_display',		// Function Callback
		'photos_box-display-section'				// The ID use when render
	);
	add_settings_field('photos_box_display[show_on_home]',	'Show on home','photos_box_show_on_home_display','photos_box-display-section','photos_box_display_section');
	*/
	register_setting( 'photos_box_settings','photos_box_display');
	wp_enqueue_style( 'photos-box-style-admin', WP_PB_URL. 'media/admin.css');	
}
add_action('admin_init', 'photos_box_init_theme_opotion');

/* CALLBACK
------------------------------------------------------*/
function photos_box_setting_display(){ ?>
	<div class="wrap photos_box_settings">
		<?php screen_icon() ?>
		<h2>Photos Box:</h2>
		<br />
		<h3>Manual:</h3>
		<p>
			<img src="<?php echo WP_PB_URL_IMAGES.'photos-box-manual.png';?>" alt="" />
		</p>
		<br />
		<br />
		<br />
		<ul>
			<li>
				<a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3N8HM67ZTCJD6">Donate to support this Plugin</a>
			</li>
		</ul>
	</div>
<?php }

/* SECTION CALLBACK
------------------------------------------------------*/

function photos_box_text_display_section_display(){
	echo '<p>Text display on Breadcrumbs when breadcrumbs show. Notice to <code>%s</code> in some field</p>';
	global $text;
	$text = (array)get_option('photos_box_text_display');
}

function photos_box_display_section_display(){
	global $display;
	$display = (array)get_option('photos_box_display');
}

/* SETTING FIELDS CALLBACK
------------------------------------------------------*/
function photos_box_show_on_home_display(){
	global $display;
	$html =  '<input value="1" type="checkbox" name="photos_box_display[show_on_home]" id="photos_box_display[show_on_home]" '.checked( 1, $display['show_on_home'], false ).'/>';
	$html .= '<label for="photos_box_display[show_on_home]">Enabled</label>';
	echo $html;

}

