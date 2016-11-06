<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<?php
	global $MyCity_class, $mycity_dditional, $mycity_dditional2, $mycity_bg_img;

	if ( function_exists( "is_bbpress" ) && is_bbpress() ) {
		$mycity_dditional2 = " is_bbpress";
	}

	if ( defined( "FRM_HAVE_DIALOG" ) ) {
		$mycity_dditional2 = " have_dialog";
	}
	?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php if ( is_single() or ( is_home() || is_front_page() ) ) {
		mycity_fb_meta();
	} //open graph;   ?>

	<?php if ( get_theme_mod( "site_Identity_layout", 's2' ) == 's2' ) {
		$mycity_dditional .= " wide";
	} ?>
	<?php wp_head(); ?>
</head>
<a href="#" class="toptop"></a>
<div class="anchor"><i class="fa fa-angle-double-up"></i></div>
<body id='hero' <?php body_class( "inner_page innerpage $mycity_dditional 12 $mycity_dditional2" ); ?>>
<?php
//Get background image
if ( isset( $mycity_bg_img ) && substr_count( $mycity_bg_img, "img/bg2.jpg" ) ) {
	$mycity_bg_img = "";
}
$bg = get_theme_mod( 'background_image' );

if ( strlen( get_header_image() ) > 3 ) {
	$bg = get_header_image();
}

if ( strlen( $mycity_bg_img ) < 3 && strlen( $bg ) > 3 ) {
	$mycity_bg_img = esc_attr( $bg );
}

if ( strlen( $mycity_bg_img ) < 3 ) {
	$mycity_bg_img = get_template_directory_uri() . '/img/bg2.jpg';
}


if ( isset( $GLOBALS['mycity_paralax_hide'] ) && $GLOBALS['mycity_paralax_hide'] == true ) {

} else {

	$mycity_id = ( get_theme_mod( 'my_ok_video_url' ) );
	if ( ! ( strlen( $mycity_id ) > 1 && is_front_page() && ! is_single() ) ) {


		?>
		<div id="hero-bg" data-img="<?php echo esc_url( $mycity_bg_img ); ?>"></div>

		<?php

	}
}

?>
<div class="body_opacity"></div>

<header class="1" id="header">


	<div id="top_line">
		<div class="container">
			<?php //header top block
			get_template_part( "partials/header", "top" ); ?>
			<!-- End row -->
		</div>
		<!-- End container-->
	</div><!-- End top line-->


	<div class="container navigate_full">
		<div class="row">
			<div class="col-md-12 clearfix map_header">
				<a href="#" class="menu_xs hidden-md hidden-sm hidden-lg">
					<i class="fa fa-bars fa-2x"></i>
				</a>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
					<img
						src="<?php echo esc_url( get_theme_mod( 'themeslug_logo', get_stylesheet_directory_uri() . '/img/logoin.png' ) ); ?>"
						alt="">
					<i class="fa fa-angle-down"></i>
				</a>
				<a href="#" class="weather">
					<span></span></a>
				<?php
				$mycity_defaults = array(
					'theme_location'  => 'mycity_topmenu',
					'menu'            => '',
					'container'       => 'div',
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => 'navigate head_nav',
					'menu_id'         => '',
					'echo'            => true,
					'fallback_cb'     => 'wp_page_menu',
					'before'          => '',
					'after'           => '',
					'link_before'     => '',
					'link_after'      => '',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'depth'           => 0,
					'walker'          => new mycity_top_menu_walker()
				);


				if ( @has_nav_menu( 'mycity_topmenu' ) ) {
					@wp_nav_menu( $mycity_defaults );

				} else {
					$mycity_args = array(
						'depth'        => 0
					,
						'show_date'    => ''
					,
						'date_format'  => sanitize_text_field( get_option( 'date_format' ) )
					,
						'child_of'     => 0
					,
						'exclude'      => ''
					,
						'exclude_tree' => ''
					,
						'include'      => ''
					,
						'title_li'     => ''
					,
						'echo'         => 1
					,
						'authors'      => ''
					,
						'sort_column'  => 'menu_order, post_title'
					,
						'sort_order'   => 'ASC'
					,
						'link_before'  => ''
					,
						'link_after'   => ''
					,
						'meta_key'     => ''
					,
						'meta_value'   => ''
					,
						'number'       => 5
					,
						'offset'       => ''
					,
						'walker'       => ''
					);

					?>
					<ul id="menu-topheader" class="navigate head_nav">
						<?php
						@wp_list_pages( $mycity_args );
						?>
					</ul>

					<?php
				}
				?>

			</div>
		</div>
	</div>

</header>

<!-- for blur effect -->
<?php
mycity_get_menu_button();
?>
