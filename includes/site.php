<?php
defined('ABSPATH') or die;
/*
 * 
 */
function photos_box_shortcode($val, $attr){
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
		
		// gallery_hp_shortcode
		'use_background' => 0,
		'show_title' => 1,
		'type' => '',
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
	if( count($attachments) ){
		$j = 0;
		
		$output .= '<div id="gallery-'.$instance.'" class="gallery-photos-box gallery galleryid-'.$id.' gallery-columns-'.$columns.' clearfix">';
		$output .= '<div class="gallery-row clearfix">';
		foreach($attachments as $i => $attachment){
			$j++;
			//var_dump($image);
			$output .= '<div class="gallery-image gallery-image-'.$j.'">';				
				$output .= '<a class="photosbox" rel="gallery'.$instance.'" title="'.$attachment->post_title.'" href="'.$attachment->guid.'">';
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
		$output .= '<br style="clear:both;" />';
		$output .= '</div>';
	}
	return $output;
}
add_filter('post_gallery', 'photos_box_shortcode', 10, 3);

/*
 * 
 */
if ( ! function_exists( 'main_setup' ) ) :
/**
 * Main setup.
 */
function photos_box_setup() {
	extract(shortcode_atts(array(
		'disable_style'	=> 0,
	), (array)get_option('photos_box_display')));
	
	// load script jquery colorbox
	wp_enqueue_style( 'photos-box-style', WP_PB_URL. 'media/colorbox.css');
	
	if( $disable_style == 0 )
		wp_enqueue_style( 'photos-box-style-site', WP_PB_URL. 'media/site.css');
	wp_enqueue_script( 'photos-box-script', WP_PB_URL. 'media/jquery.colorbox-min.js', array('jquery'), '' , false );
}
endif; // main_setup
add_action( 'after_setup_theme', 'photos_box_setup' );

function photos_box_setup_colorbox() {
	extract(shortcode_atts(array(
		'disable_style'	=> 0,
		'autopopup_media' => 0,
	), (array)get_option('photos_box_display')));
?><script type="text/javascript">
(function($){
	$('a.photosbox').each(function(){
		var rel = this.rel || '';
		//console.log(rel);
		$(this).colorbox({
			rel: rel,
			slideshow: true,
			slideshowAuto: false,
			maxWidth:"95%",
			maxHeight:"95%",
			photo: true,
			slideshowStart: " ",
			slideshowStop: " " 
		});
	});
	<?php if( is_home() && $autopopup_media>0 ):
		$image_attributes = wp_get_attachment_image_src($autopopup_media,'full');
	?>
	$('<a href="<?php echo $image_attributes[0];?>" >').colorbox({
		photo: true,
		maxWidth:"95%",
		maxHeight:"95%",
		open: true,
		onComplete: function(){
			// $('#cboxLoadedContent').append($('#autopopup-content a'));
		}
	});
	<?php endif;?>
})(jQuery);
</script><?php
}
add_action('print_footer_scripts', 'photos_box_setup_colorbox', 99 );