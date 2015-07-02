<?php

defined('ABSPATH') or die('Photo Box');

if( !function_exists('photo_box_gallery_setting') ):
function photo_box_gallery_setting(){

	// define your backbone template;
	// the "tmpl-" prefix is required,
	// and your input field should have a data-setting attribute
	// matching the shortcode name
	
	// check options
	?>
	<script type="text/html" id="tmpl-gallery-photos-box-setting">
		<label class="setting">
			<span><?php _e('Type'); ?></span>
			<select data-setting="type">
				<option value="default">Default</option>
				<option value="photosbox">Photo Box</option>
			</select>
		</label>
		<label class="setting">
			<span><?php _e('Show Title'); ?></span>
			<select data-setting="show_title">
				<option value="1">Yes</option>
				<option value="0">No</option>
			</select>
		</label>
		<label class="setting">
			<span><?php _e('Slideshow Speed'); ?></span>
			<input data-setting="slideshow_speed" type="text" value="2500" style="width:100px;"/>
		</label>
	</script>
	<script>
		jQuery(document).ready(function(){
			// add your shortcode attribute and its default value to the
			// gallery settings list; $.extend should work as well...
			_.extend(wp.media.gallery.defaults, {
				type: 'default',
				show_title: 0,
				slideshow_speed: 2500
			});

			// merge default gallery settings template with yours
			wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
				template: function(view){
					return wp.media.template('gallery-settings')(view)
							 + wp.media.template('gallery-photos-box-setting')(view);
				}
			});
		});
	</script>
	<?php
}
endif;
add_action( 'print_media_templates', 'photo_box_gallery_setting' );
