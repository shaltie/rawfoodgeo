<?php 
/*
Plugin Name: Jeba WP Preloader
Plugin URI: http://sohel.prowpexpert.com/
Description: This plugin add preloader in your wordpress site.
Author: Md Jahed
Author URI: http://prowpexpert.com/
Version: 1.0
*/

/* Adding Latest jQuery from Wordpress */
function jeba_preloader_plugin_wp() {
	wp_enqueue_script('jquery');
}
add_action('init', 'jeba_preloader_plugin_wp');

/*Some Set-up*/
define('jeba_PRELOADER_PLUGIN_WP', get_template_directory_uri()."/preloader/" );

function jeba_global_css_and_js_files() {
	wp_enqueue_script('jeba-preloader-global-active', jeba_PRELOADER_PLUGIN_WP.'js/active.js', array('jquery'));
	wp_enqueue_style('jeba-preloader-main-css', jeba_PRELOADER_PLUGIN_WP.'css/loaders.min.css');
	wp_enqueue_style('jeba-preloaders-main-css', jeba_PRELOADER_PLUGIN_WP.'css/style.css');
}
add_action('wp_enqueue_scripts', 'jeba_global_css_and_js_files');


function add_jebappreloader_options_framwrork()  
{  
	add_theme_page('Preloader Settings', 'Preloader Settings', 'manage_options', 'preloader-settings','jebapreloader_options_framwrork');  
}  
add_action('admin_menu', 'add_jebappreloader_options_framwrork');


add_action( 'admin_enqueue_scripts', 'jeba_add_color_picker' );
function jeba_add_color_picker( $hook ) {
 
    if( is_admin() ) {
		wp_enqueue_style('jeba-preloaderss-main-css', jeba_PRELOADER_PLUGIN_WP.'css/admin.css');
        // Add the color picker css file      
        wp_enqueue_style( 'wp-color-picker' );
         
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'custom-script-handle', plugins_url( '/js/color-pickr.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
    }
}

if ( is_admin() ) : // Load only if we are viewing an admin page

	function jebapreloader_register_settings() {
	// Register settings and call sanitation functions
		register_setting( 'jebapreloader_p_options', 'jebapreloader_options', 'jebapreloader_validate_options' );
	}

	add_action( 'admin_init', 'jebapreloader_register_settings' );

// Default options values
$jebapreloader_options = array(
	'preloader_bg_color' => '#000',
	'preloader_color' => '#fff',
	'preloader_type' => 'plane'
);

// Store values in array
$preloader_type = array(
	'rotating_plane' => array(
		'value' => 'plane',
		'label' => 'Rotating Plane'
	),
	'double_bounce' => array(
		'value' => 'bounce',
		'label' => 'Double Bounce'
	),
	'wave_preload' => array(
		'value' => 'wave',
		'label' => 'Wave'
	),
	'wave_preload1' => array(
		'value' => 'wave1',
		'label' => 'Wave1'
	),
	'wave_preload2' => array(
		'value' => 'wave2',
		'label' => 'Wave2'
	),
	'wave_preload3' => array(
		'value' => 'wave3',
		'label' => 'Wave3'
	),
	'wave_preload4' => array(
		'value' => 'wave4',
		'label' => 'Wave4'
	),
	'wave_preload5' => array(
		'value' => 'wave5',
		'label' => 'Wave5'
	),
	'wave_preload6' => array(
		'value' => 'wave6',
		'label' => 'Wave6'
	),
	'wave_preload7' => array(
		'value' => 'wave7',
		'label' => 'Wave7'
	),
	'wave_preload8' => array(
		'value' => 'wave8',
		'label' => 'Wave8'
	),
	'wave_preload9' => array(
		'value' => 'wave9',
		'label' => 'Wave9'
	),
	'wave_preload10' => array(
		'value' => 'wave10',
		'label' => 'Wave10'
	),
	'wave_preload11' => array(
		'value' => 'wave11',
		'label' => 'Wave11'
	),
	'wave_preload12' => array(
		'value' => 'wave12',
		'label' => 'Wave12'
	),
	'wave_preload13' => array(
		'value' => 'wave13',
		'label' => 'Wave13'
	),
	'wave_preload14' => array(
		'value' => 'wave14',
		'label' => 'Wave14'
	),
	'wave_preload15' => array(
		'value' => 'wave15',
		'label' => 'Wave15'
	),
	'wave_preload16' => array(
		'value' => 'wave16',
		'label' => 'Wave16'
	),
	'wave_preload17' => array(
		'value' => 'wave17',
		'label' => 'Wave17'
	),
	'wave_preload18' => array(
		'value' => 'wave18',
		'label' => 'Wave18'
	),
	'wave_preload19' => array(
		'value' => 'wave19',
		'label' => 'Wave19'
	),
	'wave_preload20' => array(
		'value' => 'wave20',
		'label' => 'Wave20'
	),
	'wave_preload21' => array(
		'value' => 'wave21',
		'label' => 'Wave21'
	),
	'wave_preload22' => array(
		'value' => 'wave22',
		'label' => 'Wave22'
	),
	'wave_preload23' => array(
		'value' => 'wave23',
		'label' => 'Wave23'
	),
	'wave_preload24' => array(
		'value' => 'wave24',
		'label' => 'Wave24'
	),
	'wave_preload25' => array(
		'value' => 'wave25',
		'label' => 'Wave25'
	)
);

// Function to generate options page
function jebapreloader_options_framwrork() {
	global $jebapreloader_options, $preloader_type, $preloader_animation_type;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

	<div class="wrap">

	
	<h2>Jeba Preloader Options</h2>

	<?php if ( false !== $_REQUEST['updated'] ) : ?>
	<div class="updated fade"><p><strong><?php esc_html_e( 'Options saved','mycity' ); ?></strong></p></div>
	<?php endif; // If the form has just been submitted, this shows the notification ?>

	<form method="post" action="options.php">

	<?php $settings = get_option( 'jebapreloader_options', $jebapreloader_options ); ?>
	
	<?php settings_fields( 'jebapreloader_p_options' );
	/* This function outputs some hidden fields required by the form,
	including a nonce, a unique number used to ensure the form has been submitted from the admin page
	and not somewhere else, very important for security */ ?>

	
	<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
	
	
		<tr valign="top">
			<th scope="row"><label for="background_color"> <?php esc_html_e( 'Preloader Style', 'mycity' ); ?></label></th>
			<td>
				<?php foreach( $preloader_type as $activate ) : ?>
				<input type="radio" class="box_bg" id="<?php echo esc_html($activate['value']); ?>" name="jebapreloader_options[preloader_type]" value="<?php echo esc_attr( $activate['value'] ); ?>" <?php checked( $settings['preloader_type'], $activate['value'] ); ?> />
				<label  class="box_text" for="<?php echo esc_html($activate['value']); ?>"><?php echo esc_html($activate['label']); ?></label>
				<?php endforeach; ?>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><label for="preloader_bg_color"> <?php esc_html_e( 'Preloader Background', 'mycity' ); ?></label></th>
			<td>
				<input id="preloader_bg_color" type="text" name="jebapreloader_options[preloader_bg_color]" value="<?php echo stripslashes($settings['preloader_bg_color']); ?>" class="color-field" /><p class="description">
                 <?php esc_html_e( 'Select preloader background color here. You can also add html HEX color code.', 'mycity' ); ?></p>
			</td>
		</tr>	

		<tr valign="top">
			<th scope="row"><label for="preloader_color"> <?php esc_html_e( 'Preloader color', 'mycity' ); ?></label></th>
			<td>
				<input id="preloader_color" type="text" name="jebapreloader_options[preloader_color]" value="<?php echo stripslashes($settings['preloader_color']); ?>" class="color-field" />
                <p class="description"> <?php esc_html_e( 'Select preloader color here. You can also add html HEX color code.', 'mycity' ); ?></p>
			</td>
		</tr>	

			
	</table>

	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

	</form>

	</div>

	<?php
}


function jebapreloader_validate_options( $input ) {
	global $jebapreloader_options, $preloader_type, $preloader_animation_type;

	$settings = get_option( 'jebapreloader_options', $jebapreloader_options );
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS

	$input['preloader_bg_color'] = wp_filter_post_kses( $input['preloader_bg_color'] );
	$input['preloader_color'] = wp_filter_post_kses( $input['preloader_color'] );

		
	// We select the previous value of the field, to restore it in case an invalid entry has been given
	$prev = $settings['layout_only'];
	// We verify if the given value exists in the layouts array
	if ( !array_key_exists( $input['layout_only'], $preloader_type ) )

		

	// We verify if the given value exists in the layouts array
	if ( !@array_key_exists( $input['layout_only'], $preloader_animation_type ) )
		$input['layout_only'] = $prev;	
	
	return $input;
}


endif;  // EndIf is_admin()

function jeba_background_color_change() {?>

<?php global $jebapreloader_options; $jebapreloader_settings = get_option( 'jebapreloader_options', $jebapreloader_options ); ?>

<style type="text/css">
	div.loader {background-color:<?php echo esc_attr($jebapreloader_settings['preloader_bg_color']); ?>}
</style>


<?php
}
add_action('wp_head', 'jeba_background_color_change');

function jeba_script_color_change() {?>

<?php global $jebapreloader_options; $jebapreloader_settings = get_option( 'jebapreloader_options', $jebapreloader_options ); ?>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelector('main').className += 'loaded';
    });
  </script>
<?php
}
add_action('wp_footer', 'jeba_script_color_change');
/* Including all files */
function jeba_dynamic_preloader_html() {?>
	<?php global $jebapreloader_options; $jebapreloader_settings = get_option( 'jebapreloader_options', $jebapreloader_options ); ?>
	
	
	<?php if($jebapreloader_settings['preloader_type'] == 'bounce') : ?>
	

	<div class="loader">
        <div class="loader-inner ball-grid-pulse">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>	
	
	
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave') : ?>
	
	<div class="loader">
        <div class="loader-inner ball-clip-rotate">
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave1') : ?>
	
	<div class="loader">
        <div class="loader-inner ball-clip-rotate-pulse">
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave2') : ?>
	
	 <div class="loader">
        <div class="loader-inner square-spin">
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave3') : ?>
	
	<div class="loader">
        <div class="loader-inner ball-clip-rotate-multiple">
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave4') : ?>
	
	<div class="loader">
        <div class="loader-inner ball-pulse-rise">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
    </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave5') : ?>
	
	<div class="loader">
        <div class="loader-inner ball-rotate">
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave6') : ?>
	
	 <div class="loader">
        <div class="loader-inner cube-transition">
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave7') : ?>
	
	 <div class="loader">
        <div class="loader-inner ball-zig-zag">
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave8') : ?>
	
	<div class="loader">
        <div class="loader-inner ball-zig-zag-deflect">
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave9') : ?>
	
	<div class="loader">
        <div class="loader-inner ball-triangle-path">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave10') : ?>
	
	<div class="loader">
        <div class="loader-inner ball-scale">
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave11') : ?>
	
	<div class="loader">
        <div class="loader-inner line-scale">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave12') : ?>
	
	<div class="loader">
        <div class="loader-inner line-scale-party">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave13') : ?>
	
	<div class="loader">
        <div class="loader-inner ball-scale-multiple">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave14') : ?>
	
	 <div class="loader">
        <div class="loader-inner ball-pulse-sync">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave15') : ?>
	
	<div class="loader">
        <div class="loader-inner ball-beat">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave16') : ?>
	
	<div class="loader">
        <div class="loader-inner line-scale-pulse-out">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave17') : ?>
	
	<div class="loader">
        <div class="loader-inner line-scale-pulse-out-rapid">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave18') : ?>
	
	<div class="loader">
        <div class="loader-inner ball-scale-ripple">
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave19') : ?>
	
	<div class="loader">
        <div class="loader-inner ball-scale-ripple-multiple">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave20') : ?>
	
	<div class="loader">
        <div class="loader-inner ball-spin-fade-loader">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave21') : ?>
	
	<div class="loader">
        <div class="loader-inner line-spin-fade-loader">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave22') : ?>
	
	<div class="loader">
        <div class="loader-inner triangle-skew-spin">
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave23') : ?>
	
	      <div class="loader">
        <div class="loader-inner pacman">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave24') : ?>
	
	 <div class="loader">
        <div class="loader-inner ball-grid-beat">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	<?php elseif($jebapreloader_settings['preloader_type'] == 'wave25') : ?>
	
	 <div class="loader">
        <div class="loader-inner semi-circle-spin">
          <div></div>
        </div>
      </div>
<?php else : ?>
		<div class="loader">
        <div class="loader-inner ball-pulse">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
	      

<?php endif; ?>
	

<?php

}
add_action('wp_footer', 'jeba_dynamic_preloader_html');


function jeba_get_data_from_preloader_settings() {?>

<?php global $jebapreloader_options; $jebapreloader_settings = get_option( 'jebapreloader_options', $jebapreloader_options ); ?>



<style type="text/css">
	div.loader-inner div{color:<?php echo esc_html($jebapreloader_settings['preloader_color']); ?>; background-color:<?php echo esc_html($jebapreloader_settings['preloader_color']); ?>}
</style>


<?php

}
add_action('wp_head', 'jeba_get_data_from_preloader_settings');

?>