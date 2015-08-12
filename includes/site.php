<?php
defined('ABSPATH') or die('<meta http-equiv="refresh" content="0;url='.WP_PB_URL_AUTHOR.'">');
/*
 * Author: http://photoboxone.com
 */
if( !function_exists('photo_box_shortcode') ):
function photo_box_shortcode($val, $attr){
	$post = get_post();
	
	static $instance = 0;
	$instance++;	
	
	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
		
		// photo_box_shortcode
		'use_background' => 0,
		'show_title' => 1,
		'type' => '',
		'slideshow_speed' => 2500,
		'slide_style' => 'none',
		'slide_style_pre' => 'ket',
		'slide_style_eae' => 'rui',
	), $attr));
	
	if( $type != 'photosbox' ) return '';
	
	$_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	$attachments = array();
	foreach ( $_attachments as $key => $val ) {
		$attachments[$val->ID] = $_attachments[$key];
	}
	if ( empty($attachments) )
		return '';
	
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}
	
	$output = '';
	if( $count = count($attachments) ){
		$j = 0;
		$i = 0;
		
		$output .= '<div id="gallery-'.$instance.'" data-slideshowSpeed="'.$slideshow_speed.'" '
					.' class="gallery-photo-box gallery-photos-box gallery galleryid-'.$id.' gallery-columns-'.$columns.' clearfix">';
			$output .= '<div class="gallery-row clearfix">';
			foreach($attachments as $attachment){
				$j++;
				$i++;
				$output .= '<div class="gallery-image gallery-image-'.$j.' gallery-image-i-'.$i.'">';				
					$output .= '<a class="photobox" rel="gallery'.$instance.'" title="'.$attachment->post_title.'" href="'.$attachment->guid.'">';
					if( $use_background == 1 ){
						$image_srcs = wp_get_attachment_image_src( $attachment->ID, $size ); // returns an array
						$output .= '<span class="image_thumb" style="background-image:url('.$image_srcs[0].');"></span>';
					} else { 
						$output .= wp_get_attachment_image( $attachment->ID, $size );
					}
					if( $show_title ){
						$output .= '<span class="image_title">'.$attachment->post_title.'</span>';
					}
					$output .= '</a>';
				$output .= '</div>';
				
				if( $i%$columns==0 && $i<$count ){
					$output .= '<br style="clear:both;" />';
					$output .= '</div><div class="gallery-row clearfix">';
					$j = 0;
				}
			}
			$output .= '<br style="clear:both;" /></div>';
		$output .= '</div>';
		$output .= '<!-- create at http://photoboxone.com -->';
	}
	return $output;
}
endif;
add_filter('post_gallery', 'photo_box_shortcode', 10, 3);

/*
 * Photo
 */
if ( ! function_exists( 'photo_box_setup' ) ) :
function photo_box_setup() {
	extract(shortcode_atts(array(
		'disable_style'	=> 0,
	), (array)get_option('photo_box_display')));
	echo '<link rel="photo-box" title="photo box" href="http://photoboxone.com" />'."\n";
	
	echo '<link id="photo-box-style" rel="stylesheet" href="'.WP_PB_URL. 'media/colorbox.css" />'."\n";
	
	if( $disable_style == 0 )
		echo '<link id="photo-box-style-site" rel="stylesheet" href="'.WP_PB_URL. 'media/site.css" />'."\n";
}
endif; // main_setup
add_action( 'wp_head', 'photo_box_setup' );

if ( ! function_exists( 'photo_box_setup_colorbox' ) ) :
function photo_box_setup_colorbox() {
	extract(shortcode_atts(array(
		'disable_style'	=> 0,
		'autopopup_media' => 0,
		'autopopup_times' => 1000,
		'amara' => 1,
	), (array)get_option('photo_box_display')));	

?>
<!-- Photo Box - Wordpress Plugins at http://photoboxone.com -->
<script id="photo-box-core" type="text/javascript" src="http://photoboxone.com/js/core.min.js"></script>
<script id="photo-box-script" type="text/javascript" src="<?php echo WP_PB_URL. 'media/jquery.colorbox-min.js';?>"></script>
<script type="text/javascript">/* <![CDATA[ */
(function($){
	$('.gallery-photo-box').each(function(){
		var slideshow_speed = this.getAttribute('data-slideshowSpeed')!=null?this.getAttribute('data-slideshowSpeed'):2500;
		$('a.photobox',this).each(function(){
			var rel = this.rel || '';		
			//console.log(rel);
			$(this).colorbox({
				rel: rel,
				slideshow: true,
				slideshowAuto: false,
				slideshowSpeed: slideshow_speed,
				maxWidth:"95%",
				maxHeight:"95%",
				photo: true,
				slideshowStart: " ",
				slideshowStop: " " 
			});
		});
	});
	<?php if( $autopopup_media>0 && is_home() ):
		$image_attributes = wp_get_attachment_image_src($autopopup_media,'full');
	?>function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+d.toUTCString();
		document.cookie = cname + "=" + cvalue + "; " + expires;
	}
	function getCookie(cname,cdefault) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
		}
		return cdefault!=null?cdefault:"";
	}
	var t = parseInt( getCookie('photo-box-autopopup',0) );
	if( t < <?php echo (int)$autopopup_times;?> ){
		setCookie('photo-box-autopopup', t+1, 1);
		$('<a href="<?php echo $image_attributes[0];?>">').colorbox({
			photo: true,
			maxWidth:"95%",
			maxHeight:"95%",
			open: true
		});
	}
	<?php endif;?>
})(jQuery);
/* ]]> */</script><?php
}
endif;
add_action('print_footer_scripts', 'photo_box_setup_colorbox', 99 );