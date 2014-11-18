<?php


function photos_box_gallery_setting(){

	// define your backbone template;
	// the "tmpl-" prefix is required,
	// and your input field should have a data-setting attribute
	// matching the shortcode name
	?>
	<script type="text/html" id="tmpl-gallery-photos-box-setting">
		<label class="setting">
			<span><?php _e('Type'); ?></span>
			<select data-setting="type">
				<option value="default">Default</option>
				<option value="photosbox">Photos Box</option>
			</select>
		</label>
		<?php /*/?>
		<label class="setting">
			<span><?php _e('Use Background'); ?></span>
			<select data-setting="use_background">
				<option value="0">No</option>
				<option value="1">Yes</option>
			</select>
		</label>
		<?php /*/?>
	</script>
	<script>
		jQuery(document).ready(function(){
			// add your shortcode attribute and its default value to the
			// gallery settings list; $.extend should work as well...
			_.extend(wp.media.gallery.defaults, {
				type: 'default',
				use_background: 0
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
add_action('print_media_templates', 'photos_box_gallery_setting' );
