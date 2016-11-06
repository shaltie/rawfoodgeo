<?php

$mycity_hide_url = array( '' );
$mycity_out      = "";
if ( isset( $_GET['hide'] ) ) {
	$mycity_hide_url[] = sanitize_text_field( $_GET['hide'] );
	$mycity_hide_url   = explode( ',', sanitize_text_field( $_GET['hide'] ) );
}


?>

	<div class="container">
		<div class='row'>
			<div class="col-md-12">
				<div class="phone_email clearfix">
					<?php if ( get_theme_mod( 'item_page_phone', true ) ) { ?>
						<div class="phone_email_left">
							<?php
							$website = esc_attr( get_post_meta( $post->ID, '_meta_website', true ) );
							if ( strlen( $website ) > 2 ) { ?>
								<span><i class="fa fa-globe"></i><a rel="nofollow"
								                                    target="_blank"
								                                    href="<?php echo esc_url( $website ); ?>"><?php echo
										get_post_meta( $post->ID, '_meta_website', true ); ?></a>	</span>
								<?php
							}
							?>

							<span>
                                    <i class="fa fa-user"></i>
								<?php
								$mycity_views = (int) esc_html( get_option( "views_" . $post->ID ) );
								echo esc_html( $mycity_views ++ );
								?>

                                 </span>
						</div>
						<?php
					}
					$post_tmp  = get_post( $post->ID );
					$author_id = $post_tmp->post_author;

					if ( $author_id == get_current_user_id() || current_user_can( "edit_post", $post->ID ) ) {

						$pgs      = get_pages( array(
							'meta_key'   => '_wp_page_template',
							'meta_value' => 'template-add.php'
						) );
						$editlink = add_query_arg( 'page', $post->ID, get_permalink( $pgs[0]->ID ) );

						?>
						<a href='#' class="btn btn-success ladda btn-follow ladda-button ladda-primary"
						   data-style="zoom-out" id="Edit_place"
						   onclick='window.location="<?php echo esc_url( $editlink ); ?>";return false'> <?php esc_html_e( 'Edit place', 'mycity' ); ?></a>
						<?php
					}
					?>
					<a href="#" id="submit_rewiew"
					   class='btn btn-success ladda btn-follow ladda-button ladda-primary'><?php echo esc_html_e( "Submit review", "mycity" ); ?></a>
					<?php
					esc_html( mycity_follow_button( get_current_user_id(), $post->ID * - 1 ) ); ?>
				</div>
				<!--icon description block-->
				<div class="icon_descr_block">
					<?php
					get_template_part( "partials/place", "bubles" );
					?>
					<?php
					$mycity_small_content = true;
					$mycity_out           = get_the_content();
					$mycity_out           = preg_replace( '/\[.*?\](.*?)\[\/.*?\]/is', '', $mycity_out );
					$mycity_out           = preg_replace( '/\[.*?\](.*?)\[.*?\]/is', '', $mycity_out );

					if ( strlen( $mycity_out ) > 150 ) {
						$mycity_small_content = false;
					}
					$mycity_str = get_the_content();
					global $mycity_short_descr;
					?>
					<div class="bubble">
						<div>
							<?php

							if ( get_post_meta( $post->ID, 'smalldescr', true ) ) {
								echo '<p>' . wp_kses_post( get_post_meta( $post->ID, 'smalldescr', true ) ) . '</p>';
							} else {

								if ( $mycity_small_content || isset( $mycity_short_descr ) ) {
									if ( isset( $mycity_short_descr ) ) {
										$mycity_out = $mycity_short_descr;
									}
									echo '<p>' . wp_kses_post( $mycity_out ) . '</p>';

								} else {
									$mycity_post_terms = wp_get_object_terms( $post->ID, "places_categories" );
									$mycity_tags_io    = @explode( ",", get_post_meta( $post->ID, '_tags', true ) );
									echo '<p>' . esc_html( get_post_meta( $post->ID, '_adress', true ) ) . '</p>';
								}
							}
							?>
							<span></span>
						</div>
					</div>

				</div>
				<?php
				$mycity_textInput = get_post_meta( $post->ID, '_myfield', true );

				if ( get_theme_mod( 'performans_directories', true ) ):
					?>
					<a target="_blank "
					   href='<?php echo( 'http://maps.google.com/maps?daddr=' . $mycity_textInput ); ?>'
					   class="btn btn-success ladda btn-follow ladda-button ladda-primary"
					   data-style="zoom-out" id="get_directions"
					><?php esc_html_e( 'Get Directions', 'mycity' ); ?></a>


					<?php
				endif;
				if ( strlen( $mycity_out ) > 160 ) { ?>
					<div class="bubble2">
						<div>
							<?php

							/*  $content = get_the_content( null, false );

							  $content = apply_filters( 'the_content', $content );
							  $content = preg_replace('/\[.*?\](.*?)\[\/.*?\]/is', '',$content);
							  $content = preg_replace('/\[.*?\](.*?)\[.*?\]/is', '', $content);
							  echo $content;
							*/
							ob_start();
							the_content();
							$content = ob_get_clean();
							$content = preg_replace( '/\[featur.*?\](.*?)\[\/.*?\]/is', '', $content );
							$content = preg_replace( '/\[bigfeature.*?\](.*?)\[\/.*?\]/is', '', $content );

							// $content = preg_replace('/\[.*?\](.*?)\[.*?\]/is', '', $content);
							echo $content;
							?>
						</div>
					</div>
					<?php
				}
				?>


				<?php


				$mycity_count = 0;
				preg_match_all( '/\[feature\](.*?):(.*?)\[\/feature\]/is', $mycity_str, $mycity_features );
				if ( count( $mycity_features[1] ) > 1 ) { ?><!--Features info-->
				<div class="features_block clearfix">

					<div>
						<ul>
							<?php foreach ( $mycity_features[1] as $k => $v ) {


								echo "<li><b>" . wp_kses_post( $v ) . ":</b>";
								echo " " . wp_kses_post( $mycity_features[2][ $k ] ) . "<br></li>";
								$mycity_count ++;

							}
							?>

						</ul>
					</div>
				</div>

			<?php } ?>

				<?php
				if ( ! in_array( 'testimonials', $mycity_hide_url ) ) {
					get_template_part( "partials/place", "checkins" );
				}
				?>
				<?php
				$short_code = get_theme_mod( 'my_Testimonials_short',
					"[show-testimonials orderby='menu_order' order='ASC' layout='grid' options='theme:speech,info-position:info-left,text-alignment:left,columns:2,review_title:on,rating:on,quote-content:short,charlimitextra: (...),display-image:on,image-size:ttshowcase_small,image-shape:circle,image-effect:none,image-link:on']" );
				if ( ! in_array( 'testimonials', $mycity_hide_url ) ) {
					echo do_shortcode( $short_code );
				} ?>

				<div class="clear"></div>
				<div class="place_event">
					<?php
					if ( ! in_array( 'events', $mycity_hide_url ) ) {
						get_template_part( "partials/place", "eventon" );
					}
					?>
				</div>

			</div>
		</div>
	</div>
<?php

if ( strlen( get_post_meta( get_the_ID(), 'instaid', true ) ) > 3 && ! in_array( 'instagram', $mycity_hide_url ) ) {
	get_template_part( "partials/place", "tremula" );
}
?>

<?php
$mycity_post_insid       = str_replace( " ", "", get_post_meta( get_the_ID(), 'post_inside', true ) );
$mycity_post_street_view = str_replace( " ", "", get_post_meta( get_the_ID(), 'post_street_view', true ) );

if ( ( strlen( $mycity_post_insid ) > 5 || strlen( $mycity_post_street_view ) > 5 )
     && ! in_array( 'google', $mycity_hide_url )
) {

	?>

	<div class="bs-example">
		<?php
		$mycity_allowed_html = array(
			'b'      => array(),
			'iframe' => array(
				'class'           => array(),
				'src'             => array(),
				'width'           => array(),
				'height'          => array(),
				'frameborder'     => array(),
				'style'           => array(),
				'allowfullscreen' => array(),
			),
			'br'     => array(),
			'strong' => array()
		);
		?>


		<div class="google_place">
			<?php
			$inside = get_post_meta( get_the_ID(), 'post_inside', true );
			$street = get_post_meta( get_the_ID(), 'post_street_view', true );

			if ( strlen( $inside ) > 10 && strlen( $street ) > 10 ) {
				?>
				<ul class="gp_nav">

					<?php
					if ( $inside ) {
						?>
						<li class="tabs_controls_item">
							<a href="#" class="active"><i
									class="fa fa-location-arrow"></i><?php echo esc_html__( "Inside View", "mycity" ); ?>
							</a>
						</li>
					<?php } ?>
					<?php
					if ( strlen( $street ) > 10 ) {
						?>
						<li class="tabs_controls_item">
							<a href="#"><i class="fa fa-globe"></i><?php echo esc_html__( "Street View", "mycity" ); ?>
							</a>
						</li>
					<?php } ?>
				</ul>
			<?php } ?>
			<ul class="gp_content">
				<?php
				if ( strlen( $inside ) > 10 ):
					?>
					<li class="tabs_item active">

						<div class='google_view'>
							<?php
							echo $inside;
							?></div>

					</li>
					<?php
				endif; ?>
				<?php if ( strlen( $street ) > 4 ):
					?>
					<li class="tabs_item <?php if ( strlen( $inside ) < 10 ) {
						echo 'active';
					} ?>" style=''>

						<div class='google_view'>
							<?php
							echo $street;
							?></div>

					</li>
					<?php
				endif; ?>
			</ul>


		</div>


	</div>
<?php } ?>
<?php
if ( ! in_array( 'promo', $mycity_hide_url ) ) {
	get_template_part( "partials/place", "offer" );
}
?>
<?php
$mycity_views = (int) esc_html( get_option( "views_" . $post->ID ) );
update_post_meta( $post->ID, 'mycity_views', (int) $mycity_views );
?>