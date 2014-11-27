<?php
defined('ABSPATH') or die;

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
	add_settings_field('photos_box_display[disable_style]', 'Disable Style','photos_box_display_disable_style','photos_box-display-section','photos_box_display_section');
	add_settings_field('photos_box_display[autopopup_media]', 'Auto Popup Media','photos_box_display_autopopup_media','photos_box-display-section','photos_box_display_section');
	
	register_setting( 'photos_box_settings','photos_box_display');
	
	wp_enqueue_style( 'photos-box-style-admin', WP_PB_URL. 'media/admin.css');
	wp_enqueue_media();
	wp_register_script('photos-box-upload', WP_PB_URL. 'media/admin.js', array('jquery'), '1.0', true);
	wp_enqueue_script('photos-box-upload');

}
add_action('admin_init', 'photos_box_init_theme_opotion');

/* CALLBACK
------------------------------------------------------*/
function photos_box_setting_display(){ 
	extract(shortcode_atts(array(
		'disable_style'	=> 0,
		'autopopup_media' => 0,
	), (array)get_option('photos_box_display')));
	
	
?>
	<div class="wrap photos_box_settings clearfix">
		<?php screen_icon() ?>
		<h2>Photos Box</h2>
		<div class="photos_box_links clearfix">
			<ul>
				<li>
					<a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3N8HM67ZTCJD6">Donate to this Plugin</a>
				</li>
			</ul>
		</div>
		<br />
		<div class="photos_box_advanced clearfix">
			<h3>Settings</h3>
			<form action="options.php" method="post">
				<?php settings_fields('photos_box_settings' ); ?>
				
				<p>
					<input value="1" type="checkbox" name="photos_box_display[disable_style]" id="photos_box_display_disable_style" <?php echo checked( 1, $disable_style, false );?>/>
					<label for="photos_box_display_disable_style">Disable Style</label>
				</p>
				<h4>Auto Popup Media (Home page)</h4>
				<p id="photos_box_display_image_thumb"><?php echo ($autopopup_media>0?wp_get_attachment_image($autopopup_media,'thumbnail','',array('height' => 150) ):'');?></p>
				<p>
					<input value="<?php echo $autopopup_media;?>" type="hidden" name="photos_box_display[autopopup_media]" id="photos_box_display_image_id" />
					<button id="upload_image_button">Choose Image</button>
				</p>
				
				<?php submit_button(); ?>
			</form>
		</div>
		<div class="photos_box_advanced clearfix">
			<h3>Manual</h3>
			<p><img src="<?php echo WP_PB_URL_IMAGES.'screenshot-1.png';?>" alt="" /></p>
			<br />
			<br />
		</div>
		<div class="photos_box_links clearfix">
			<ul>
				<li>
					<a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3N8HM67ZTCJD6">Donate to this Plugin</a>
				</li>
			</ul>
		</div>		
	</div>
<?php
}
add_action('media_buttons', 'add_my_media_button');
function add_my_media_button() {
    echo '<a href="#" id="insert-my-media" class="button">Add my media</a>';
}