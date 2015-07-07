<?php
defined('ABSPATH') or die;

/* SECTIONS - FIELDS
------------------------------------------------------*/
if( !function_exists('photo_box_init_theme_opotion') ):
function photo_box_init_theme_opotion() {
	// 
	add_settings_section(
		'photo_box_display_section', 				// The ID to use for this section
		'Display Options',							// Title of this section
		'photo_box_display_section_display',		// Function Callback
		'photo_box-display-section'					// The ID use when render
	);
	add_settings_field('photo_box_display[disable_style]', 'Disable Style','photo_box_display_disable_style','photo_box-display-section','photo_box_display_section');
	add_settings_field('photo_box_display[autopopup_media]', 'Auto Popup Media','photo_box_display_autopopup_media','photo_box-display-section','photo_box_display_section');
	add_settings_field('photo_box_display[autopopup_times]', 'Auto Popup Times','photo_box_display_autopopup_times','photo_box-display-section','photo_box_display_section');
	//add_settings_field('photo_box_display[autohide]', 'Auto Hide','photo_box_display_autohide','photo_box-display-section','photo_box_display_section');
	
	register_setting( 'photo_box_settings','photo_box_display');
	
	wp_enqueue_style( 'photo-box-style-admin', WP_PB_URL. 'media/admin.css');
	
	if( preg_match('/options/i',$_SERVER['REQUEST_URI']) ){
		wp_enqueue_media();
		wp_register_script('photo-box-upload', WP_PB_URL. 'media/admin.js', array('jquery'), '1.0', true);
		wp_enqueue_script('photo-box-upload');
	}
}
endif;
add_action('admin_init', 'photo_box_init_theme_opotion');

/* CALLBACK
------------------------------------------------------*/
if( !function_exists('photo_box_setting_display') ):
function photo_box_setting_display(){ 
	extract(shortcode_atts(array(
		'disable_style'	=> 0,
		'autopopup_media' => 0,
		'autopopup_times' => 1000,
	), (array)get_option('photo_box_display')));
	
	
?>
	<div class="wrap photo_box_settings clearfix">
		<?php screen_icon() ?>
		<h2>Photo Box</h2>
		<?php photo_box_links(); ?>
		<div class="photo_box_advanced clearfix">
			<h3>Settings</h3>
			<form action="options.php" method="post">
				<?php settings_fields('photo_box_settings' ); ?>
				<p>
					<input value="1" type="checkbox" name="photo_box_display[disable_style]" id="photo_box_display_disable_style" <?php echo checked( 1, $disable_style, false );?>/>
					<label for="photo_box_display_disable_style">Disable Style</label>
				</p>
				<h4>Auto popup media (Home page)</h4>
				<p id="photo_box_display_image_thumb"><?php echo ($autopopup_media>0?wp_get_attachment_image($autopopup_media,'thumbnail','',array('height' => 150) ):'');?></p>
				<p>
					<input value="<?php echo $autopopup_media;?>" type="hidden" name="photo_box_display[autopopup_media]" id="photo_box_display_image_id" />
					<button id="upload_image_button">Choose Image</button>
					<button id="remove_image_button">Remove Image</button>
				</p>
				<p>
					<label for="photo_box_display_autopopup_times">Auto popup times</label>
					<input value="<?php echo $autopopup_times;?>" type="text" name="photo_box_display[autopopup_times]" id="photo_box_display_autopopup_times" />
				</p>
				<?php submit_button(); ?>
			</form>
		</div>
		<div class="photo_box_advanced clearfix">
			<p><a target="_blank" href="http://photoboxone.com/gallery/">Demo PhotoBox Full Version</a></p>
			<h4><a style="color: #f00; font-size: 18px;" target="_blank" href="http://photoboxone.com/download/">Download full version now !</a></h4>
		</div>
		<?php photo_box_links(); ?>
	</div>
<?php
}
endif;

if( !function_exists('photo_box_links') ):
function photo_box_links(){
?>
	<div class="photo_box_links clearfix">
		<ul>
			<li class="first"><a target="_blank" href="http://photoboxone.com/gallery/">Demo PhotoBox Full Version</a></li>
			<li><a target="_blank" href="http://photoboxone.com/documents/">Help</a></li>
			<li><a target="_blank" href="http://photoboxone.com/donate/">Donate</a></li>
		</ul>
	</div>
<?php
}
endif;