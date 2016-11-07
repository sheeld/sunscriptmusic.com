<?php
/*
Plugin Name: Responsive Gallery Grid
Plugin URI: http://bdwm.be/rgg
Description: Converts the default wordpress gallery to a Google+ styled image gallery grid, where the images are scaled to fill the gallery container, while maintaining image aspect ratio's.
Author: Jules Colle, BDWM
Author URI: http://bdwm.be
Version: 2.0.4

Copyright 2013-2016 Jules Colle (email : jules@bdwm.be)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

define('RGG_VERSION', '2.0.4');

if (!function_exists('rgg_gallery_shortcode')) {

	require_once 'rgg-options.php';

	$all_settings = array();

	function rgg_gallery_shortcode($output, $attr) {
		global $all_settings, $rgg_options;

		$post = get_post();

		// image_size is deprecated, but if it is set and size is empty => size = image_size.
		if (!empty($attr['image_size']) && empty($attr['size'])) {
			$attr['size'] = $attr['image_size'];
		}
		
		// create settings based on the attributes set in the shortcode. 
		$settings_arr = shortcode_atts(array(
	        'type' => $rgg_options['type'],
	        'class' => $rgg_options['class'],
	        'rel' => $rgg_options['rel'],
	        'ids' => $rgg_options['ids'],
	        'margin' => intval($rgg_options['margin']),
	        'scale' => doubleval($rgg_options['scale']),
	        'maxrowheight' => intval($rgg_options['maxrowheight']),
	        'intime' => intval($rgg_options['intime']),
	        'outtime' => intval($rgg_options['outtime']),
	        'captions' => $rgg_options['captions'],
	
			// default params  that can be inherited from gallery_shortcode
			'order'      => 'ASC',
			'orderby'    => $rgg_options['orderby'],
			'id'         => $rgg_options['id'] == '' ? $post->ID : $rgg_options['id'],
			'size'       => $rgg_options['size'], // default changed from thumbnail to medium, because that makes more sense
			'include'    => $rgg_options['include'],
			'exclude'    => $rgg_options['exclude']
	    ), $attr);
		
		extract($settings_arr);
		
		if ($type == 'native') {
			// returning nothing will make gallery_shortcode take over
			return '';
		}
		
		/* code below is based on default gallery_shortcode (wp-includes/media.php) */
		/* BEGIN ------------------- */

		static $instance = 0;
		$instance++;
	
		if ( ! empty( $ids ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $orderby ) ) $orderby = 'post__in';
			$include = $ids;
		}
	
		// Allow plugins/themes to override the default gallery template. // NOT NEEDED ofcourse
		// $output = apply_filters('post_gallery', '', $attr);
		// if ( $output != '' ) return $output;
	
		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		$orderby = sanitize_sql_orderby( $orderby );
		if ( !$orderby ) unset( $orderby );
			
		$id = intval($id);
		if ( 'RAND' == $order )
			$orderby = 'none';
	
		if ( !empty($include) ) {
			$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	
			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( !empty($exclude) ) {
			$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		} else {
			$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		}
	
		if ( empty($attachments) )
			return '';
	
		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment )
				$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
			return $output;
		}
		
		/* ------------------------- END */
	
	
			
		$all_settings[] = $settings_arr;
		
		ob_start();
	?>
			<div class="rgg-imagegrid <?php echo $class ?>" rgg_id="<?php echo count($all_settings) ?>">
				
	<?php
		foreach ( $attachments as $mid => $attachment ) {
			$info = wp_get_attachment_image_src( $mid, 'large' );
			$link = $info[0];
			$title = get_post_field('post_excerpt', $mid);
			$title_esc = htmlentities($title, ENT_COMPAT, 'UTF-8');
			$a_title = $captions == 'title' ? "title=\"$title_esc\"" : '';
			$img = wp_get_attachment_image($mid, $size);
			echo "<a class=\"rgg-a\" rel=\"$rel\" $a_title>";
			echo $img;
			if ($captions == 'overlay' && !empty($title_esc)) {
				echo '<span class="rgg-caption"><span class="rgg-inner-caption">'.$title_esc.'</span></span>';
			}
			echo "</a>";
			// echo wp_get_attachment_link($mid, 'medium', true);
			// echo $link;
		}
	?>
			</div>
			<div style="clear:both"></div>
	<?php
		//possible solution to get rid of p-tags.
		//remove_filter( 'the_content', 'wpautop' );
		//add_filter( 'the_content', 'wpautop' , 12);
		// return ob_get_clean();
		
		// better solution to get rid of p-tags: [raw][/raw] : removed again, seemed to mess things up in some wordpress sites.
		return do_shortcode(ob_get_clean());
	}
	
	//remove_shortcode('gallery', 'gallery_shortcode');
	//add_shortcode('gallery', 'rgg_gallery_shortcode');
	add_filter( 'post_gallery', 'rgg_gallery_shortcode', 9, 2 );
	
	
	function rgg_register_scripts() {
		
		global $all_settings;
		if (count($all_settings) == 0) return;
		
		// enqueue scripts
		wp_enqueue_script('imagesloaded', plugins_url( 'js/jquery.imagesloaded.min.js' , __FILE__ ), array('jquery'), RGG_VERSION, false );
		wp_enqueue_script('gallerygrid', plugins_url( '/js/jquery.gallerygrid.js' , __FILE__ ), array('imagesloaded'), RGG_VERSION, false );
		wp_enqueue_script('rgg-main', plugins_url( '/js/main.js' , __FILE__ ), array('gallerygrid'), RGG_VERSION, false );
		
		// pass shortcode parameters to main script also
		wp_localize_script( 'rgg-main', 'rgg_params', $all_settings );	
	}
	
	function rgg_register_styles() {
			
		// enqueue css
		wp_register_style( 'rgg-style', plugins_url('css/style.css', __FILE__), false, RGG_VERSION );
		wp_enqueue_style( 'rgg-style' );
		
	}
	
	add_action('wp_footer', 'rgg_register_scripts');
	add_action('wp_head', 'rgg_register_styles');
}