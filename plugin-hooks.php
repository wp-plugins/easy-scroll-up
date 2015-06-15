<?php
/*
Plugin Name: Easy Scroll Up
Plugin URI: http://wppluginarea.com/easy-scroll-up/
Description: This plugin Enable for Scroll To Up very easy to setup change color option just instal and see the magic.
Author: Wp Plugin Area
Author URI: http://wppluginarea.com
Version: 2.1
*/


/* Adding Latest jQuery from Wordpress */
function easy_scroll_up_latest_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'easy_scroll_up_latest_jquery');

/*Some Set-up*/
define('TP_EASY_SCROLL_UP', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

/* Adding Plugin javascript file */
wp_enqueue_script('tp-scroll-plugin-js', TP_EASY_SCROLL_UP.'js/jquery.scrollUp.js', array('jquery'), '2.1', false);

// Adding menu in wordpress dashboard
function add_tpeasyscrollup_menu_setting_section_framwrork()  
{  
	add_options_page('Custom Scroll Up Options', 'Easy Scroll Up', 'manage_options', 'tpscrollup-settings','tpscrollup_default_options_framwrork');  
}  
add_action('admin_menu', 'add_tpeasyscrollup_menu_setting_section_framwrork');

// Default options values
$tpscrollup_default_options = array(
	'background_color' => '#151515',
	'hover_color' => '#424242',
	'border_radius' => '5px',
	'scroll_speed' => '300',
	'scroll_icons' => 'angle-double-up'
);

if ( is_admin() ) : // Load only if we are viewing an admin page

function scrollup_tp_color_pickr_function( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'tp-script-handle', plugins_url('js/color-pickr.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'scrollup_tp_color_pickr_function' );

function tpscrollup_register_settings() {
	// Register settings and call sanitation functions
	register_setting( 'tpeasyscrollup_p_options', 'tpscrollup_default_options', 'tpscrollup_validate_options' );
}

add_action( 'admin_init', 'tpscrollup_register_settings' );


// Function to generate options page
function tpscrollup_default_options_framwrork() {
	global $tpscrollup_default_options, $auto_hide_mode;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

	<div class="wrap">

	
	<h2>Easy Scroll Up Option</h2>

	<?php if ( false !== $_REQUEST['updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
	<?php endif; // If the form has just been submitted, this shows the notification ?>

	<form method="post" action="options.php">

	<?php $settings = get_option( 'tpscrollup_default_options', $tpscrollup_default_options ); ?>
	
	<?php settings_fields( 'tpeasyscrollup_p_options' );
	/* This function outputs some hidden fields required by the form,
	including a nonce, a unique number used to ensure the form has been submitted from the admin page
	and not somewhere else, very important for security */ ?>

	
	<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->

		<tr valign="top">
			<th scope="row"><label for="background_color">Scroll Up Background color</label></th>
			<td>
				<input id="background_color" type="text" name="tpscrollup_default_options[background_color]" value="<?php echo stripslashes($settings['background_color']); ?>" class="tp-color-field" /><p class="description">Select Scroll Background color here. You can also add html HEX color code.</p>
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row"><label for="hover_color">Scroll Up Hover Color</label></th>
			<td>
				<input id="hover_color" type="text" name="tpscrollup_default_options[hover_color]" value="<?php echo stripslashes($settings['hover_color']); ?>" class="tp-color-field"/><p class="description">Select Scroll Up hover color here, you can also add html HEX color code</p>
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row"><label for="border_radius">Scroll Up border radius</label></th>
			<td>
				<input id="border_radius" type="text" name="tpscrollup_default_options[border_radius]" value="<?php echo stripslashes($settings['border_radius']); ?>" /><p class="description">Select Scroll Up border radius here. Please use px. Example: 5px</p>
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row"><label for="scroll_speed">Scroll Up Speed</label></th>
			<td>
				<input id="scroll_speed" type="text" name="tpscrollup_default_options[scroll_speed]" value="<?php echo stripslashes($settings['scroll_speed']); ?>" /><p class="description">Select Scroll Up speed here. default Speed is 300</p>
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row"><label for="scroll_icons">Scroll Up Icons</label></th>
			<td>
				<input id="scroll_icons" type="text" name="tpscrollup_default_options[scroll_icons]" value="<?php echo stripslashes($settings['scroll_icons']); ?>" /><p class="description">Select Scroll Up icons you can use font-awesome icons to see icon variation or icon code just click <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a> </p>
			</td>
		</tr>
		
	</table>

	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>
	
	
	</form>

	</div>

	<?php
}
function tpscrollup_validate_options( $input ) {
	global $tpscrollup_default_options, $auto_hide_mode;

	$settings = get_option( 'tpscrollup_default_options', $tpscrollup_default_options );
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS

	$input['background_color'] = wp_filter_post_kses( $input['background_color'] );
	$input['hover_color'] = wp_filter_post_kses( $input['hover_color'] );
	$input['border_radius'] = wp_filter_post_kses( $input['border_radius'] );
	$input['scroll_speed'] = wp_filter_post_kses( $input['scroll_speed'] );
	$input['scroll_icons'] = wp_filter_post_kses( $input['scroll_icons'] );


	return $input;
}

endif;  // EndIf is_admin()



function easy_scroll_up_active_code(){
?>
<?php global $tpscrollup_default_options; $tpscrollup_settings = get_option( 'tpscrollup_default_options', $tpscrollup_default_options ); ?>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript">
jQuery(document).ready(function(){

  jQuery.scrollUp({
    scrollName: 'scrollUp', // Element ID
    topDistance: '300', // Distance from top before showing element (px)
    topSpeed: <?php echo $tpscrollup_settings['scroll_speed']; ?>, // Speed back to top (ms)
    animation: 'fade', // Fade, slide, none
    animationInSpeed: 200, // Animation in speed (ms)
    animationOutSpeed: 200, // Animation out speed (ms)
    scrollText: '<i class="fa fa-<?php echo $tpscrollup_settings['scroll_icons']; ?>"></i>', // Text for element
    activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
  });
  
  }); 
</script>
<style type="text/css">
a#scrollUp { background-color:<?php echo $tpscrollup_settings['background_color']; ?>;  
-moz-border-radius: 5px;  -webkit-border-radius: 5px;  
border-radius: <?php echo $tpscrollup_settings['border_radius']; ?>; 
 bottom: 15px;  padding: 6px 11px;  right: 15px;  text-align: center  }
a#scrollUp i { color: #fff;  display: inline-block;  font-size: 28px;  text-shadow: 0 1px 0 #000  }
a#scrollUp:focus { outline: none }
a#scrollUp:hover {background-color: <?php echo $tpscrollup_settings['hover_color']; ?>}
</style>
<?php
}
add_action('wp_head', 'easy_scroll_up_active_code');

?>