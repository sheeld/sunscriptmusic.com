<?php

define('RGG_PLUGIN', 'rgg_plugin');
define('RGG_OPTIONS', RGG_PLUGIN.'_options');
define('RGG_TEXT_DOMAIN', RGG_PLUGIN.'_text_domain');

define('RGG_DEFAULT_TYPE', 'rgg');
define('RGG_DEFAULT_CLASS', '');
define('RGG_DEFAULT_REL', 'lightbox-gallery-1');
define('RGG_DEFAULT_DATAREL', 'lightbox-gallery-1');
define('RGG_DEFAULT_IDS', '');
define('RGG_DEFAULT_MARGIN', 2);
define('RGG_DEFAULT_SCALE', 1.1);
define('RGG_DEFAULT_MAXROWHEIGHT', 200);
define('RGG_DEFAULT_INTIME', 100);
define('RGG_DEFAULT_OUTTIME', 100);
define('RGG_DEFAULT_CAPTIONS', 'title');
define('RGG_DEFAULT_ORDERBY', 'menu_order');
define('RGG_DEFAULT_ID', '');
define('RGG_DEFAULT_SIZE', 'large');
define('RGG_DEFAULT_INCLUDE', '');
define('RGG_DEFAULT_EXCLUDE', '');
define('RGG_DEFAULT_ADMIN_LOCATION', 'admin.php');

$rgg_options = get_option(RGG_OPTIONS);
if (!is_array($rgg_options)) $rgg_options = array();

if(isset($_POST['reset'])) {
	update_option(RGG_OPTIONS, $rgg_options);
	$rgg_options['settings_saved'] = 0;
}

// this setting will only be 0 as long as the user has not saved any settings. Once the user has saved the RGG settings, this value will always remain 1.
if (!key_exists('settings_saved',$rgg_options)) $rgg_options['settings_saved'] = 0;

if ($rgg_options['settings_saved'] == 0) {
	$rgg_options['type'] = RGG_DEFAULT_TYPE;
	$rgg_options['class'] = RGG_DEFAULT_CLASS;
	$rgg_options['rel'] = RGG_DEFAULT_REL;
	$rgg_options['data-rel'] = RGG_DEFAULT_DATAREL;
	$rgg_options['ids'] = RGG_DEFAULT_IDS;
	$rgg_options['margin'] = RGG_DEFAULT_MARGIN;
	$rgg_options['scale'] = RGG_DEFAULT_SCALE;
	$rgg_options['maxrowheight'] = RGG_DEFAULT_MAXROWHEIGHT;
	$rgg_options['intime'] = RGG_DEFAULT_INTIME;
	$rgg_options['outtime'] = RGG_DEFAULT_OUTTIME;
	$rgg_options['captions'] = RGG_DEFAULT_CAPTIONS;
	$rgg_options['orderby'] = RGG_DEFAULT_ORDERBY;
	$rgg_options['id'] = RGG_DEFAULT_ID;
	$rgg_options['size'] = RGG_DEFAULT_SIZE;
	$rgg_options['include'] = RGG_DEFAULT_INCLUDE;
	$rgg_options['exclude'] = RGG_DEFAULT_EXCLUDE;
	$rgg_options['admin_location'] = RGG_DEFAULT_ADMIN_LOCATION;
}


add_action('ninja_forms_display_before_field_function','wrap_input_field_before');
add_action('ninja_forms_display_after_field_function','wrap_input_field_after');

function wrap_input_field_before() { echo '<div class="resizable_input_wrapper">'; }
function wrap_input_field_after() { echo '</div>'; }

add_action( 'admin_enqueue_scripts', 'load_page_options_wp_admin_style' );
function load_page_options_wp_admin_style() {
	wp_register_style( 'page_options_wp_admin_css', plugins_url('css/admin-style.css',__FILE__), false, RGG_VERSION );
	wp_enqueue_style( 'page_options_wp_admin_css' );
}


add_action('admin_menu', 'rgg_admin_add_page');
function rgg_admin_add_page() {
	global $rgg_options;
	if ($rgg_options['admin_location'] != 'admin.php') {
		add_submenu_page( $rgg_options['admin_location'], 'RGG Options', 'RGG Options', 'manage_options', RGG_PLUGIN, 'rgg_options_page', 200 );
	} else {
		add_menu_page( 'RGG Options', 'RGG Options', 'manage_options', RGG_PLUGIN, 'rgg_options_page', '', 200 );
	}
	//add_submenu_page( RGG_PLUGIN, 'Afstanden berekenen', 'Afstanden berekenen', 'manage_options', RGG_PLUGIN.'2', 'rgg_distances_page');
}

function rgg_options_page() {
	global $rgg_options;
	
	// Include in admin_enqueue_scripts action hook
	wp_enqueue_media();
	//wp_enqueue_script( 'custom-background' );
	wp_enqueue_script( 'rgg-image-upload', plugins_url('framework/js/bdwm-image-upload.js',__FILE__), array('jquery'), '1.0.0', true );

	if (isset($_POST['reset'])) {
	    echo '<div id="message" class="updated fade"><p><strong>Settings restored to defaults</strong></p></div>';
	} else if ($_REQUEST['settings-updated']) {
	    echo '<div id="message" class="updated fade"><p><strong>Settings updated</strong></p></div>';
	}

?>

<div class="wrap rgg-admin-wrap">
<?php screen_icon(); ?>
<h2>RGG Options</h2>
<form action="options.php" method="post">
<?php settings_fields(RGG_OPTIONS); ?>

<h3>General Settings</h3>

<p>Responsive Gallery Grid Pro is available now. <a href="http://bdwm.be/rgg/responsive-gallery-grid-pro/" target="_blank">Get it here!</a></p>

<?php
	
	bdwm_input_select('admin_location', array(
		'label' => 'Admin Menu Location',
		'description' => 'Make your WordPress admin interface less bloated by adding the RGG settings page to a submenu',
		'options' => array(
			'admin.php'=> 'New top level menu',
			'index.php' => 'Dashboard', 'upload.php' => 'Media', 'themes.php'=>'Appearance', 'plugins.php'=>'Plugins', 'tools.php'=>'Tools', 'options-general.php'=>'Settings'),
		'default' => RGG_DEFAULT_ADMIN_LOCATION
	));

    // For Dashboard: add_submenu_page( 'index.php', ... ); Also see add_dashboard_page()
    // For Posts: add_submenu_page( 'edit.php', ... ); Also see Also see add_posts_page()
    // For Media: add_submenu_page( 'upload.php', ... ); Also see add_media_page()
    // For Links: add_submenu_page( 'link-manager.php', ... ); Also see add_links_page()
    // For Pages: add_submenu_page( 'edit.php?post_type=page', ... ); Also see add_pages_page()
    // For Comments: add_submenu_page( 'edit-comments.php', ... ); Also see add_comments_page()
    // For Custom Post Types: add_submenu_page( 'edit.php?post_type=your_post_type', ... );
    // For Appearance: add_submenu_page( 'themes.php', ... ); Also see add_theme_page()
    // For Plugins: add_submenu_page( 'plugins.php', ... ); Also see add_plugins_page()
    // For Users: add_submenu_page( 'users.php', ... ); Also see add_users_page()
    // For Tools: add_submenu_page( 'tools.php', ... ); Also see add_management_page()
    // For Settings: add_submenu_page( 'options-general.php', ... ); Also see add_options_page()
    // For Settings in the Network Admin pages: add_submenu_page( 'settings.php', ... );

?>

<h3>Gallery Settings</h3>
<p>Default settings for each gallery. You can always overwrite these default options by modifying the <a href="http://bdwm.be/rgg/shortcode-parameters" target="_blank">shortcode parameters</a>.</p>

	<input type="hidden" value="1" id="<?php echo RGG_OPTIONS.'_settings_saved' ?>" name="<?php echo RGG_OPTIONS.'[settings_saved]' ?>">
<?php

	bdwm_input_select('type', array(
		'label' => 'Type',
		'description' => 'The gallery type. Note: if you choose the native gallery all the other options will be ignored!',
		'options' => array('rgg'=> 'Responsive Gallery Grid', 'native' => 'Native Gallery'),
		'default' => RGG_DEFAULT_TYPE
	));
	
	bdwm_input_field('class', array(
		'label' => 'Class',
		'description' => 'Additional CSS class(es) that will be appended to the CSS class of the gallery container. If you wish to add multiple classes, seperate them with a space.',
		'default' => RGG_DEFAULT_CLASS
	));
	
	bdwm_input_field('rel', array(
		'label' => 'Rel',
		'description' => ' 	An additional CSS class you would like to add to the gallery container.',
		'default' => RGG_DEFAULT_REL
	));

	bdwm_input_field('data-rel', array(
		'label' => 'Data-Rel',
		'description' => ' 	An additional CSS class you would like to add to the gallery container.',
		'default' => RGG_DEFAULT_DATAREL
	));
	
	bdwm_input_field('margin', array(
		'label' => 'Margin',
		'description' => 'A positive integer value indicating the number of pixels you want to appear between the images in the Responsive Gallery.',
		'default' => RGG_DEFAULT_MARGIN
	));	
	
	bdwm_input_field('scale', array(
		'label' => 'Scale',
		'description' => 'A positive decimal value indicating the factor by which the image-size is multiplied on mouse over.',
		'default' => RGG_DEFAULT_SCALE
	));	

	bdwm_input_field('maxrowheight', array(
		'label' => 'Max Row Height',
		'description' => 'A positive integer value indicating the maximum height, in pixels, of each row in the Responsive Gallery Grid.',
		'default' => RGG_DEFAULT_MAXROWHEIGHT
	));	
	
	bdwm_input_field('intime', array(
		'label' => 'Animation In time',
		'description' => 'A positive integer value indicating the time, in milliseconds, it will take for the mouse over animation to complete.',
		'default' => RGG_DEFAULT_INTIME
	));
	
	bdwm_input_field('outtime', array(
		'label' => 'Animation Out Time',
		'description' => ' 	A positive integer value indicating the time, in milliseconds, it will take for the mouse out animation to complete.',
		'default' => RGG_DEFAULT_OUTTIME
	));
	
	bdwm_input_select('captions', array(
		'label' => 'Captions',
		'description' => 'Choose how you want the captions to be displayed. (Download <a href="http://bdwm.be/rgg/responsive-gallery-grid-pro/">RGG Pro</a> for more options.)',
		'options' => array('title' => 'As title attribute', 'off' => 'Don\'t show captions'),
		'default' => RGG_DEFAULT_CAPTIONS
	));
	
	bdwm_input_select('orderby', array(
		'label' => 'Gallery Order',
		'description' => 'Choose which default order you would like to use for the gallery images',
		'options' => array('menu_order' => 'Use the order you chose manually', 'ID' => 'Order by media ID', 'title' => 'Order by title', 'date' => 'Order by the date and time the image was uploaded', 'modified' => 'Order by the date and time the image was last modified', 'rand' => 'Random order'),
		'default' => RGG_DEFAULT_ORDERBY
	));
	
	$image_sizes = array();
	$registered_image_sizes = get_intermediate_image_sizes();
	
	foreach ($registered_image_sizes as $image_size) {
		$image_sizes[$image_size] = $image_size;
	}
	
	$image_sizes['full'] = 'full';
	
	bdwm_input_select('size', array(
		'label' => 'Image Size',
		'description' => 'The size of the images to load as the tiles of the grid.',
		'options' => $image_sizes,
		'default' => RGG_DEFAULT_SIZE,
	));

submit_button();

?>
	<h3>Advanced Settings</h3>
	<p>In normal circumstances, the parameters below should only be set directly in the shortcode, or not set at all. They are mainly here for completeness and in most cases you should only use them as a refence.</p>
<?php

	bdwm_input_field('ids', array(
		'label' => 'IDs',
		'description' => 'A comma seperated list of media IDs.<br>This is generated by WordPress if you create a Gallery with Add Media. If this parameter is omitted, the gallery will show all images that are attached to the current post.',
		'default' => RGG_DEFAULT_IDS
	));
	
	bdwm_input_field('include', array(
		'label' => 'Include',
		'description' => 'A comma seperated list of media IDs of additional images to include in the gallery.',
		'default' => RGG_DEFAULT_INCLUDE
	));
	
	bdwm_input_field('exclude', array(
		'label' => 'Exclude',
		'description' => 'A comma seperated list of media IDs of images to exclude from the gallery.',
		'default' => RGG_DEFAULT_EXCLUDE
	));
	
	bdwm_input_field('id', array(
		'label' => 'Post ID',
		'description' => 'A valid Post ID. This will only be used if the ids parameter is omitted.<br>Fills the gallery with all images attached to the post with the provided ID.<br>Default value is the ID of the post in which the gallery is inserted.',
		'default' => RGG_DEFAULT_ID
	));

?>

 
<?php submit_button(); ?>
</form></div>

<h3>Restore Default Settings</h3>
<form method="post" id="reset-form" action="">
	<p class="submit">
 		<input name="reset" class="button button-secondary" type="submit" value="Restore defaults" >
		<input type="hidden" name="action" value="reset" />
	</p>
</form>
<script>
	(function($){
		$('#reset-form').submit(function() {
			return confirm('Are you sure you want to reset the plugin settings to the default values? All changes you have previously made will be lost.');
		});
	}(jQuery))
</script>
 
<?php
}


function bdwm_image_field($slug, $args) {
	
	global $rgg_options;
	
	$defaults = array(
		'title'=>'Image',
		'description' => '',
		'choose_text' => 'Choose an image',
		'update_text' => 'Use image',
		'default' => ''
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract($args);
	$label; $description; $choose_text; $update_text; $default;
	
	if (!key_exists($slug, $rgg_options)) {
		$rgg_options[$slug] = $default;
	}
	
?>
    <span class="label"><?php echo $label; ?></span>
<?php
	if ($description) {
?>
    <p><?php echo $description; ?></p>
<?php
	}
?>
	<p>
		<div class="image-container" id="default-thumbnail-preview_<?php echo $slug ?>">
<?php
	if ($rgg_options[$slug] != '') {
		$img_info = wp_get_attachment_image_src($rgg_options[$slug], 'full');
		$img_src = $img_info[0];
?>
			<img src="<?php echo $img_src ?>" height="100">
<?php
	}
?>
		</div>
		<a class="choose-from-library-link" href="#"
			data-field="<?php echo RGG_OPTIONS.'_'.$slug ?>"
			data-image_container="default-thumbnail-preview_<?php echo $slug ?>"
		    data-choose="<?php echo $choose_text; ?>"
		    data-update="<?php echo $update_text; ?>"><?php _e( 'Choose image' ); ?>
		</a>
		<input type="hidden" value="<?php echo $rgg_options[$slug] ?>" id="<?php echo RGG_OPTIONS.'_'.$slug ?>" name="<?php echo RGG_OPTIONS.'['.$slug.']' ?>">
	</p>
<?php
	
}

function bdwm_input_field($slug, $args) {
	global $rgg_options;
	
	$defaults = array(
		'label'=>'',
		'desription' => '',
		'default' => ''
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract($args);
	
	$label; $description; $default;
	
	if (!key_exists($slug, $rgg_options)) {
		$rgg_options[$slug] = $default;
	}
	
?>	
	<p>
		<span class="label"><?php echo $label ?></span>
		<span class="field"><input type="text" data-default-value="<?php echo $default ?>" value="<?php echo $rgg_options[$slug] ?>" id="<?php echo RGG_OPTIONS.'_'.$slug ?>" name="<?php echo RGG_OPTIONS.'['.$slug.']' ?>"></span>
		<span class="description"><?php echo $description ?><?php if (!empty($default)) echo ' (Default: '.$default.')' ?></span>
	</p>
<?php

}

function bdwm_input_select($slug, $args) {
	global $rgg_options;
	
	$defaults = array(
		'label'=>'',
		'desription' => '',
		'options' => array(), // array($name => $value)
		'default' => '',
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract($args);
	
	$label; $description; $options; $default;
	
	if (!key_exists($slug, $rgg_options)) {
		$rgg_options[$slug] = $default;
	}
	
	// $first_element = array('-1' => '-- Select --');
	// $options = array_merge($first_element, $options);
	
?>	
	<p>
		<span class="label"><?php echo $label ?></span>
		<span class="field">
			<select id="<?php echo RGG_OPTIONS.'_'.$slug ?>" data-default-value="<?php echo $default ?>" name="<?php echo RGG_OPTIONS.'['.$slug.']' ?>">
<?php
	foreach($options as $value => $text) {
?>
				<option value="<?php echo $value ?>" <?php echo $rgg_options[$slug]==$value?'selected':'' ?>><?php echo $text ?></option>
<?php 
	}
?>
			</select>			
		</span>
		<span class="description"><?php echo $description ?><?php if (!empty($default)) echo ' (Default: '.$options[$default].')' ?></span>
	</p>
<?php

}

function bdwm_checkbox($slug, $args) {
	global $rgg_options;
	
	$defaults = array(
		'label'=>'',
		'desription' => '',
		'default' => '',
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract($args);
	
	$label; $description; $default;
	
?>	
	<p>
		<span class="label"><?php echo $label ?></span>
		<span class="field">
			
			<input type="checkbox" data-default-value="<?php echo $default ?>" name="<?php echo RGG_OPTIONS.'['.$slug.']' ?>" value="1" <?php checked('1', $rgg_options[$slug]) ?>>
		</span>
		<span class="description"><?php echo $description ?><?php if (!empty($default)) echo ' (Default: '.$default.')' ?></span>
	</p>
<?php
}




function rgg_get_thumbnail_src ($post_id=0, $size="thumbnail") {
	global $rgg_options;
	if ($post_id == 0) {
		global $post;
	} else {
		$post = get_post($post_id);
	}
	
	if ( has_post_thumbnail($post->ID)) {
	   $img_info = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ));
	} else if (key_exists('default_thumbmail', $rgg_options) && $rgg_options['default_thumbmail'] != '') {
		$img_info = wp_get_attachment_image_src($rgg_options['default_thumbmail']);
	} else {
		return '';
	}
	
	return $img_info;
}

function rgg_the_post_thumbnail ($post_id=0, $size="thumbnail") {
	$info = rgg_get_thumbnail_src($post_id,$size);
	if ($info == '') {
		echo '';
	} else {
?>
	<img width="<?php echo $info[1] ?>" height="<?php echo $info[2] ?>" src="<?php echo $info[0] ?>" class="attachment-<?php $size ?> wp-post-image" alt="">
<?php
	}
}

add_action('admin_init', 'rgg_admin_init');
function rgg_admin_init(){
	
	
register_setting( RGG_OPTIONS, RGG_OPTIONS, 'rgg_options_sanitize' );
add_settings_section('rgg_main', 'Main Settings', 'rgg_section_text', RGG_PLUGIN);
add_settings_field('rgg_text_string', 'Plugin Text Input', 'rgg_setting_string', RGG_PLUGIN, 'rgg_main');
}

function rgg_section_text() {
echo '<p>Main description of this section here.</p>';
}

function rgg_setting_string() {
	
}

function rgg_options_sanitize($input) {
	return $input;
}