<?php 

/**
* Template Name: Places grid2
*/


if(substr_count($_SERVER["REQUEST_URI"],'register')) {
	 $pgs=get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'template-auth.php'
	));
	if ($pgs[0]->ID) {
	wp_safe_redirect(get_permalink($pgs[0]->ID));
	} else {
    wp_safe_redirect('wp-login.php');
	}
}

if(substr_count($_SERVER["REQUEST_URI"],'submit')) {
    $pgs=get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'template-add.php'
	));
	if ($pgs[0]->ID) {
	wp_safe_redirect(get_permalink($pgs[0]->ID));
	die();
	}
}

get_header();
get_sidebar();

global $mycity_noparalax;
$mycity_points = array();
 ?>

<div id="container">
	<div class="container page_info">
		<div class="col_md_12  page404">
			<h1><?php echo esc_html(__("404 Not found","mycity"))?></h1>
			<p class="lead visible-md visible-lg">
			<?php			
			if (current_user_can("administrator")) {
				?>

				<?php echo esc_html(__('Admin! For theme work correctly, you must activate all required plugins and add spetial pages with slug "register", "submit-place", "members" and other... For more information see documentation. OR just import Demo data (Admin -> Appearance -> Import demo data).',"mycity")); ?>
			
				<?php
			} else {
				echo esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'mycity' );;
			}
				
			?>
			</p>
		</div>
	</div>
</div>
<?php  get_footer(); ?>