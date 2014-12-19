jQuery(document).ready(function($){
	
		
	var tgm_media_frame_img,
		clicked_on_imgbtn = false;
    $(document.body).on('click.tgmOpenMediaManager', '#upload_image_button', function(e){
        e.preventDefault();

        if ( tgm_media_frame_img ) {
            tgm_media_frame_img.open();
            return;
        }

        tgm_media_frame_img = wp.media.frames.tgm_media_frame = wp.media({
            className: 'media-frame tgm-media-frame',
            frame: 'select',
            multiple: false,
            title: 'Upload Image',
            library: {
                type: 'image'
            },

            button: {
                text:  'Use this image'
            }
        });

        tgm_media_frame_img.on('select', function(){
            var media_attachment = tgm_media_frame_img.state().get('selection').first().toJSON();
			//console.log(media_attachment);
			
            jQuery('#photos_box_display_image_id').val(media_attachment.id);
			jQuery('#photos_box_display_image_thumb').html('<img src="'+media_attachment.url+'" height=100 alt=""/>');
        });
        tgm_media_frame_img.open();
    });
	
	$('#upload_image_button').click(function() {
		formfield = jQuery('#photos_box_display_image_id').attr('name');
		clicked_on_imgbtn = true;
		tb_show('Add Image', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});


});