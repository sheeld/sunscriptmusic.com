<?Php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//load settings
$gallery_settings = unserialize(base64_decode(get_post_meta( $post->ID, 'awl_vg_settings_'.$post->ID, true)));
//print_r($gallery_settings);
$video_gallery_id = $post->ID;

//css
wp_enqueue_style( 'vg-font-awesome-css', plugin_dir_url( __FILE__ ).'css/font-awesome.min.css' );
wp_enqueue_style( 'wp-color-picker' );

//js
wp_enqueue_script('jquery');
wp_enqueue_script( 'vg-color-picker-js',  plugin_dir_url( __FILE__ ).'js/vg-color-picker.js', array( 'jquery', 'wp-color-picker' ), '', true  );
?>
<p class="video-settings">
	<label>Gallery Thumbnail Size</label></br></br>
	<?php if(isset($gallery_settings['gal_thumb_size'])) $gal_thumb_size = $gallery_settings['gal_thumb_size']; else $gal_thumb_size = "thumbnail"; ?>
	<select id="gal_thumb_size" name="gal_thumb_size" class="form-control">
		<option value="thumbnail" <?php if($gal_thumb_size == "thumbnail") echo "selected=selected"; ?>>Thumbnail – 150 × 150</option>
		<option value="medium" <?php if($gal_thumb_size == "medium") echo "selected=selected"; ?>>Medium – 300 × 169</option>
		<option value="large" <?php if($gal_thumb_size == "large") echo "selected=selected"; ?>>Large – 840 × 473</option>
		<option value="full" <?php if($gal_thumb_size == "full") echo "selected=selected"; ?>>Full Size – 1280 × 720</option>
	</select></br></br>
	<?php _e('Select gallery thumnails size to display into gallery', VGP_TXTDM); ?><a class="be-right" href="#">Go To Top</a>
</p>

<p class="video-settings">
	<label>Colums On Large Desktops</label></br></br>
	<?php if(isset($gallery_settings['col_large_desktops'])) $col_large_desktops = $gallery_settings['col_large_desktops']; else $col_large_desktops = "col-lg-2"; ?>
	<select id="col_large_desktops" name="col_large_desktops" class="form-control">
		<option value="col-lg-12" <?php if($col_large_desktops == "col-lg-12") echo "selected=selected"; ?>>1 Column</option>
		<option value="col-lg-6" <?php if($col_large_desktops == "col-lg-6") echo "selected=selected"; ?>>2 Column</option>
		<option value="col-lg-4" <?php if($col_large_desktops == "col-lg-4") echo "selected=selected"; ?>>3 Column</option>
		<option value="col-lg-3" <?php if($col_large_desktops == "col-lg-3") echo "selected=selected"; ?>>4 Column</option>
		<option value="col-lg-2" <?php if($col_large_desktops == "col-lg-2") echo "selected=selected"; ?>>6 Column</option>
		<option value="col-lg-1" <?php if($col_large_desktops == "col-lg-1") echo "selected=selected"; ?>>12 Column</option>
	</select></br></br>
	<?php _e('Select gallery column layout for large desktop devices', VGP_TXTDM); ?><a class="be-right" href="#">Go To Top</a>
</p>

<p class="video-settings">
	<label>Colums On Desktops</label></br></br>
	<?php if(isset($gallery_settings['col_desktops'])) $col_desktops = $gallery_settings['col_desktops']; else $col_desktops = "col-md-3"; ?>
	<select id="col_desktops" name="col_desktops" class="form-control">
		<option value="col-md-12" <?php if($col_desktops == "col-md-12") echo "selected=selected"; ?>>1 Column</option>
		<option value="col-md-6" <?php if($col_desktops == "col-md-6") echo "selected=selected"; ?>>2 Column</option>
		<option value="col-md-4" <?php if($col_desktops == "col-md-4") echo "selected=selected"; ?>>3 Column</option>
		<option value="col-md-3" <?php if($col_desktops == "col-md-3") echo "selected=selected"; ?>>4 Column</option>
		<option value="col-md-2" <?php if($col_desktops == "col-md-2") echo "selected=selected"; ?>>6 Column</option>
		<option value="col-md-1" <?php if($col_desktops == "col-md-1") echo "selected=selected"; ?>>12 Column</option>
	</select></br></br>
	<?php _e('Select gallery column layout for desktop devices', VGP_TXTDM); ?><a class="be-right" href="#">Go To Top</a>
</p>

<p class="video-settings">
	<label>Colums On Tablets</label></br></br>
	<?php if(isset($gallery_settings['col_tablets'])) $col_tablets = $gallery_settings['col_tablets']; else $col_tablets = "col-sm-4"; ?>
	<select id="col_tablets" name="col_tablets" class="form-control">
		<option value="col-sm-12" <?php if($col_tablets == "col-sm-12") echo "selected=selected"; ?>>1 Column</option>
		<option value="col-sm-6" <?php if($col_tablets == "col-sm-12") echo "selected=selected"; ?>>2 Column</option>
		<option value="col-sm-4" <?php if($col_tablets == "col-sm-4") echo "selected=selected"; ?>>3 Column</option>
		<option value="col-sm-3" <?php if($col_tablets == "col-sm-3") echo "selected=selected"; ?>>4 Column</option>
		<option value="col-sm-2" <?php if($col_tablets == "col-sm-2") echo "selected=selected"; ?>>6 Column</option>
	</select></br></br>
	<?php _e('Select gallery column layout for tablet devices', VGP_TXTDM); ?><a class="be-right" href="#">Go To Top</a>
</p>

<p class="video-settings">
	<label>Colums On Phones</label></br></br>
	<?php if(isset($gallery_settings['col_phones'])) $col_phones = $gallery_settings['col_phones']; else $col_phones = "col-xs-6"; ?>
	<select id="col_phones" name="col_phones" class="form-control">
		<option value="col-xs-12" <?php if($col_phones == "col-xs-12") echo "selected=selected"; ?>>1 Column</option>
		<option value="col-xs-6" <?php if($col_phones == "col-xs-6") echo "selected=selected"; ?>>2 Column</option>
		<option value="col-xs-4" <?php if($col_phones == "col-xs-4") echo "selected=selected"; ?>>3 Column</option>
		<option value="col-xs-3" <?php if($col_phones == "col-xs-3") echo "selected=selected"; ?>>4 Column</option>
	</select></br></br>
	<?php _e('Select gallery column layout for phone devices', VGP_TXTDM); ?><a class="be-right" href="#">Go To Top</a>
</p>

<p class="video-settings">
	<label>Width</label></br></br>
	<?php if(isset($gallery_settings['width'])) $width = $gallery_settings['width']; else $width = 700; ?>	
	<input type="number" class="form-control" id="width" name="width" placeholder="" value="<?php echo $width; ?>"></br></br>
	<?php _e('Set the video frame preview width. Default is 700.', VGP_TXTDM); ?><a class="be-right" href="#">Go To Top</a>
</p>

<p class="video-settings">
	<label>Height</label></br></br>
	<?php if(isset($gallery_settings['height'])) $height = $gallery_settings['height']; else $height = 480; ?>	
	<input type="number" class="form-control" id="height" name="height" placeholder="" value="<?php echo $height; ?>"></br></br>
	<?php _e('Set the video frame preview height. Default is 480.', VGP_TXTDM); ?><a class="be-right" href="#">Go To Top</a>
</p>

<p class="video-settings">
	<label>Z index</label></br></br>
	<?php 
	if(isset($gallery_settings['z_index'])) $z_index = $gallery_settings['z_index']; else $z_index = "default"; 
	if($z_index == "default") { $z_index_custom_value = 2100; } else  {
		if(isset($gallery_settings['z_index_custom_value'])) $z_index_custom_value = $gallery_settings['z_index_custom_value']; else $z_index_custom_value = 2100; 
	}
	?>		
	<input type="radio" class="form-control" id="z_index" name="z_index" value="default" <?php if($z_index == "default") echo "checked"; ?>> Default
	<input type="radio" class="form-control" id="z_index" name="z_index" value="custom" <?php if($z_index == "custom") echo "checked"; ?>> Custom
	<br><br>
	<input type="range" class="form-control" id="z_index_custom" name="z_index_custom" min="0" max="9999" step="10" placeholder="" value="<?php echo $z_index_custom_value; ?>" onchange="updateRange(this.value, this.id);">
	<br><br>
	<input type="text" id="z_index_custom_value" name="z_index_custom_value" value="<?php echo $z_index_custom_value; ?>" style="" readonly><br></br>
	<?php _e('Set the Z-index of video frame preview page overlay. Default is 2100.', VGP_TXTDM); ?><a class="be-right" href="#">Go To Top</a>
</p>

<p class="video-settings">
	<label><?php _e('Custom CSS', VGP_TXTDM); ?></label></br></br>
	<?php if(isset($gallery_settings['custom-css'])) $custom_css = $gallery_settings['custom-css']; else $custom_css = ""; ?>
	<textarea name="custom-css" id="custom-css" style="width: 100%; height: 120px;" placeholder="Type direct CSS code here. Don't use <style>...</style> tag."><?php echo $custom_css; ?></textarea><br><br>
	<?php _e('Apply own css on video gallery and dont use style tag', VGP_TXTDM); ?><a class="be-right" href="#">Go To Top</a>
</p>

<input type="hidden" name="vg-settings" id="vg-settings" value="vg-save-settings">

<style>
.video-settings {
	padding: 8px 0px 8px 8px !important;
	margin: 10px 10px 4px 0px !important;
	border-bottom: 1px dashed #00A0D2 !important;
}

.video-settings label {
	font-size: 13px !important;
	font-weight: bold;
}

.be-right {
	float: right !important;
}
</style>
<script>
//color-picker
(function( jQuery ) {
	jQuery(function() {
		// Add Color Picker to all inputs that have 'color-field' class
		jQuery('#cibc').wpColorPicker();
	});
})( jQuery );

// title size range settings.  on change range value
function updateRange(val, id) {
	jQuery("#" + id).val(val);
	jQuery("#" + id + "_value").val(val);	  
}	

// start pulse on page load
function pulseEff() {
   jQuery('#shortcode').fadeOut(600).fadeIn(600);
};
var Interval;
Interval = setInterval(pulseEff,1500);

// stop pulse
function pulseOff() {
	clearInterval(Interval);
}
// start pulse
function pulseStart() {
	Interval = setInterval(pulseEff,2000);
}

///on load zinx hide show
var zindex = jQuery('input[name="z_index"]:checked').val();
if(zindex == "default") {
	jQuery("#z_index_custom").val(2100);
	jQuery("#z_index_custom_value").val(2100);
}

// description font size hide show
jQuery(document).ready(function() {
	jQuery('#z_index').change(function(){
		var zindex = jQuery('input[name="z_index"]:checked').val();
		if(zindex == "default") {
			jQuery("#z_index_custom").val(2100);
			jQuery("#z_index_custom_value").val(2100);
		}
	});
});
</script>