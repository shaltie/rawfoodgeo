<?php
/**
 * Template Name: template-item-minimal.php (minimal)
 * Preview:
 */


$mycity_noheader = 1;


global $mycity_dditional, $mycity_bg_img, $post, $mycity_post_terms;

$mycity_dditional = " template-item-minimal";
$mycity_bg_img    = mycity_get_big_img( $post->ID );

get_header();
get_sidebar();

$mycity_textInput = get_post_meta( $post->ID, '_myfield', true );

$mycity_count2 = 0;
preg_match_all( '/\[bigfeature\](.*?):(.*?)\[\/bigfeature\]/is', get_the_content(), $mycity_bigfeatures );

if ( count( $mycity_bigfeatures[1] ) > 0 ) {
	foreach ( $mycity_bigfeatures[1] as $k => $v ) {
		$fmr_icon[]  = $mycity_bigfeatures[1][ $k ];
		$fmr_title[] = $mycity_bigfeatures[2][ $k ];
		$mycity_count2 ++;
	}

}


?>
<div class="site-overlay"></div>
<div id="container">
	<div class="header_section <?php if ( $mycity_count2 > 0 ) {
		echo "have_icons";
	} ?>" id="header_section">
		<?php
		//post link
		echo wp_kses_post( str_replace( 'rel="prev"', ' class="header_arrow __l" rel="prev" ', get_previous_post_link( ' %link', '<i  class="fa fa-caret-left" aria-hidden="true"></i> ' ) ) ) . "\n";
		echo wp_kses_post( str_replace( 'rel="next', ' class="header_arrow __r" rel="next ', get_next_post_link( ' %link', ' <i class="fa fa-caret-right" aria-hidden="true"></i>' ) ) );
		?>
		<div class="start_descrition">
			<h1><?php the_title(); ?><span></span></h1>
			<div class="phone_email_left phone_email_left2">
				<?php


				$phone = esc_html( get_post_meta( $post->ID, '_meta_phone', true ) );

				$phone_arr = explode( ',', $phone );

				if ( is_array( $phone_arr ) && isset( $phone_arr[1] ) ) {
					?>
					<span><i class="fa fa-phone"></i>
						<?php
						foreach ( $phone_arr as $number ) {
							$tel_format = str_replace( array( ' ', '(', ')', '-' ), array( '', '', '', '' ), $number )
							?>
							<a href="tel:<?php echo esc_html( $tel_format ); ?>"> <?php echo wp_kses_post( $number ); ?></a>
							<?php
						} ?>
                        </span>
					<?php
				} else {
					if ( strlen( $phone ) > 2 ) {
						$tel_format = str_replace( array( ' ', '(', ')' ), array( '', '', '' ), $phone )
						?>
						<span><i class="fa fa-phone"></i>
                                 <a href="tel:<?php echo esc_html( $tel_format ); ?>"> <?php echo wp_kses_post( $phone ); ?></a>
                            </span>
						<?php
					}
				}
				?>
			</div>
			<span>

				<?php
				$mycity_post_terms = wp_get_object_terms( $post->ID, "places_categories" );
				$mycity_tags_io    = @explode( ",", get_post_meta( $post->ID, '_tags', true ) );
				echo esc_html( get_post_meta( $post->ID, '_adress', true ) );
				?>
			</span>

			<?php if ( $mycity_count2 > 0 ) {
				?>
				<ul class="icons clearfix">
					<?php
					foreach ( $fmr_icon as $k => $v ) {
						echo "<li>";
						echo $fmr_icon[ $k ];
						echo $fmr_title[ $k ];
						echo "</li>";
					}
					?>
				</ul>
				<?php
			} ?>

		</div>
		<script>
			jQuery(document).ready(function ($) {
				var start_descrition_h = $('.template-item-minimal .start_descrition').height(),
					start_descrition_w = $('.template-item-minimal .start_descrition').width();
				$('.template-item-minimal .start_descrition').css({
					'margin-top': ((start_descrition_h / 2) * (-1)) + 'px'

				});
			});
		</script>
		<div class="header_section_popup"></div>
	</div>
	<script>
		jQuery('.template-item-minimal #header_section').css({
			height: jQuery(window).height() + 'px'
		});

	</script>
	<div class="item_wide_container">
		<?php if ( $mycity_count2 > 0 ) {
		} else {
			?>
			<div class="singlescroll">
				<div class="scroll_block">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/scroll.png"
					     class="animated infinite bounce"
					     alt="<?php esc_html_e( "Use your scrollwheel :)", "mycity" ); ?>">
				</div>
			</div>

			<?php
		}
		$mycity_arr_lat = explode( ',', $mycity_textInput );
		?>
		<?php
		if ( strlen( get_theme_mod( 'uber_client_id', '' ) ) < 2
		     || ( isset( $_GET['showrating'] ) && sanitize_text_field( $_GET['showrating'] ) == 1 )
		):
			?>
			<div class="clerfix"></div>
			<a href='' class="btn btn-success adda btn-follow" id="call_rating">
				<div class="uber_go2">

					<?php esc_html_e( 'Rating:', 'mycity' );
					echo esc_html( mycity_get_currentplace_rating( get_the_ID() ) * 2 );
					?>/10
				</div>
			</a>
			<?php
		else:

			if ( get_theme_mod( 'uber_unavailable_button', false ) != true && ( get_theme_mod( 'uber_more_button', false ) == false ) ) {
				$url        = 'https://m.uber.com/sign-up?client_id=' . esc_attr( get_theme_mod( 'uber_client_id', 'oOWfPjI2UhdD-nezsAvqhq8r1my12iHK' ) ) . '&pickup_latitude=' . esc_attr( $mycity_arr_lat[0] ) . '&pickup_longitude=' . esc_attr( $mycity_arr_lat[1] );
				$custum_url = get_theme_mod( 'uber_url_go' );
				if ( isset( $custum_url{8} ) ) {
					$url = $custum_url;
				}

				$text        = esc_html__( 'Go!', 'mycity' );
				$custum_text = get_theme_mod( 'uber_unavailable_text_2' );

				if ( isset( $custum_text{0} ) ) {
					$text = $custum_text;
				}

				?>
				<a href='<?php echo esc_url( $url ); ?>'
				   class="btn btn-success adda btn-follow ladda-button ladda-primary
                   <?php if ( get_theme_mod( 'uber_more_button', false ) == true ) { ?>
                   btn_scroll_down
                   <?php } ?>
                   " id="call_uber"
				   data-style="zoom-out">
					<?php echo esc_html( $text ); ?>
					<div class="uber_go"></div>
				</a>
				<?php
			} else {

				$text        = esc_html__( 'Go!', 'mycity' );
				$custum_text = get_theme_mod( 'uber_unavailable_text_2' );

				if ( isset( $custum_text{0} ) ) {
					$text = $custum_text;
				}


				?><a href='#'
				     class="btn btn-success adda btn-follow ladda-button ladda-primary
                   <?php if ( get_theme_mod( 'uber_more_button', false ) == true ) { ?>
                   btn_scroll_down
                   <?php } ?>
                   " id="call_uber"
				     data-style="zoom-out">
				<?php echo esc_html( $text ); ?>
				<div class="uber_go"></div>
				</a>
				<?php

			}
		endif; ?>


		<div class="item_border"></div>

		<?php get_template_part( "partials/place", "center" ); ?>


	</div>
</div>
<?php
$mycity_ex          = explode( ",", $mycity_textInput );
$mycity_textInput_l = ( $mycity_ex[0] ) . "," . ( $mycity_ex[1] );
?>
<script type="text/javascript">
	jQuery(document).ready(function ($) {

		if (navigator.geolocation && MyCity_map_init_obj.geolocation == false) {
			navigator.geolocation.getCurrentPosition(function (position) {
				var latitude = position.coords.latitude;
				var longitude = position.coords.longitude;
				var post_id = "<?php echo esc_attr( $post->ID ); ?>";

				<?php
				if (get_theme_mod( "uber_show_distance" ) == 1) {
				$str = get_theme_mod( "uber_show_distance_txt", "About XX min. from you (~ YY km)" );

				?>
				var str1 = "<?php echo esc_html( $str ); ?>";
				var km1 = getDistanceFromLatLonInKm(latitude, longitude,<?php echo esc_attr( $mycity_ex[0] );?>,<?php echo esc_attr( $mycity_ex[1] );?>);
				km1 = km1.toFixed(2);
				var tm1 = Math.round(km1 * 60 /<?php echo get_theme_mod( "uber_show_distance_speed", "15" ); ?>);

				str1 = str1.replace("YY", km1);
				str1 = str1.replace("XX", tm1);
				if (km1 < 100) jQuery('.uber_block_price').text(str1);
				<?php
				} else {?>
				$.ajax({
					url: "<?php echo esc_url( site_url() ); ?>/wp-admin/admin-ajax.php",
					type: 'POST',
					data: "action=mycity_uber_price&latitude=" + latitude + "&longitude=" + longitude + "&post_id=" + post_id,
					success: function (html) {
						$('.uber_block_price').text(html);
					}
				});
				<?php }
				?>


			});
		}
	});
	function initialize_map() {
		//Map parametrs2
		var mapOptions_place = {
			scrollwheel: true,
			zoom: 14,
			center: new google.maps.LatLng(<?php echo esc_html( $mycity_textInput_l ); ?>),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			mapTypeControl: false,
			mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
				position: google.maps.ControlPosition.BOTTOM_CENTER
			},
			panControl: false,
			panControlOptions: {
				position: google.maps.ControlPosition.TOP_RIGHT
			},
			zoomControl: false,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.LARGE,
				position: google.maps.ControlPosition.TOP_RIGHT
			},
			scaleControl: false,
			scaleControlOptions: {
				position: google.maps.ControlPosition.TOP_LEFT
			},
			streetViewControl: false,
			streetViewControlOptions: {
				position: google.maps.ControlPosition.LEFT_TOP
			},
			styles: [{
				"featureType": "poi",
				"stylers": [{"visibility": "off"}]
			}, {"stylers": [{"saturation": -70}, {"lightness": 37}, {"gamma": 1.15}]}, {
				"elementType": "labels",
				"stylers": [{"gamma": 0.26}, {"visibility": "off"}]
			}, {
				"featureType": "road",
				"stylers": [{"lightness": 0}, {"saturation": 0}, {"hue": "#ffffff"}, {"gamma": 0}]
			}, {
				"featureType": "road",
				"elementType": "labels.text.stroke",
				"stylers": [{"visibility": "off"}]
			}, {
				"featureType": "road.arterial",
				"elementType": "mycity",
				"stylers": [{"lightness": 20}]
			}, {
				"featureType": "road.highway",
				"elementType": "mycity",
				"stylers": [{"lightness": 50}, {"saturation": 0}, {"hue": "#ffffff"}]
			}, {
				"featureType": "administrative.province",
				"stylers": [{"visibility": "on"}, {"lightness": -50}]
			}, {
				"featureType": "administrative.province",
				"elementType": "labels.text.stroke",
				"stylers": [{"visibility": "off"}]
			}, {"featureType": "administrative.province", "elementType": "labels.text", "stylers": [{"lightness": 20}]}]
			, styles: MyCity_map_init_obj.global_map_styles
		};
		//map
		var map_place = new google.maps.Map(document.getElementById("map_place"), mapOptions_place);
		//positions
		var point_place = new google.maps.LatLng(<?php echo esc_html( $mycity_textInput ); ?>);
		//markers
		var marker_place = className = 'Cafe';
		var marker_place = new google.maps.Marker({
			position: point_place,
			map: map_place,
			category: '',
			icon: '<?php
				if ( isset( $mycity_post_terms[0]->term_id ) ) {
					echo esc_html( mycity_get_marker_by_id( $mycity_post_terms[0]->term_id ) );
				}
				?>',
			title: "point_place"
		});
		map_place.panTo(point_place);
		jQuery.get(pluginsUrl + "/GeoCity/ajax.php?update_post_view=<?php echo (int) esc_html( $post->ID ); ?>", function (d) {
		});
		<?php

		$mycity_cordinats = get_post_meta( get_the_ID(), '_myfield', true );
		preg_match( "/(.*?),(.*?)$/", $mycity_cordinats, $mycity_math );
		if ( ! isset( $mycity_math[1] ) ) {
			$mycity_math[1] = 0;
		}
		if ( ! isset( $mycity_math[2] ) ) {
			$mycity_math[2] = 0;
		}
		$mycity_location_latitude = sanitize_text_field( $mycity_math[1] );
		$mycity_location_longitude = sanitize_text_field( $mycity_math[2] );


		?>

	}
</script>
<script type="text/javascript">
	jQuery(document).ready(function ($) {
		jQuery(".header_arrow").show();
		if ($("p").is('.no_events')) {
			$('.no_events').parents(".ajde_evcal_calendar").remove();
		}

	});
</script>
<div class="modal_popup">
</div>
<div id='msity_rewiew'>


	<a href="#" class="close_msity"><i class="fa fa-times"></i></a>
	<?php
	$mycity_short_code = get_theme_mod( 'my_Testimonials_form',
		"[show-testimonials-form subtitle='on' subtitle_url='on' rating='on' email='on' style='tt_simple' ]" );
	echo do_shortcode( $mycity_short_code );
	?>
</div>
<?php

if ( isset( $_POST['_aditional_info_short_testimonial'] ) ) {
	?>
	<script>
		jQuery(document).ready(function ($) {
			$('.modal_popup, #msity_rewiew').fadeIn();
		});
	</script>
	<?php
}
if ( isset( $_GET['showevent'] ) ) {
	?>
	<script>
		jQuery(document).ready(function ($) {
			setTimeout(function () {
				$("#event_<?php echo (int) sanitize_text_field( $_GET['showevent'] ); ?>  .desc_trig ").click();
			}, 500);
			if ($(window).height() > 1000) {
				$('.template-item-minimal .item_wide_container').css({
					'top': '-200px'
				})
				$('.template-item-minimal footer').css({
					'padding-top': '80px',
					'margin-top': '-215px'
				})
			}
		});
	</script>
	<?php
	?>
	<?php
}


get_footer();
?>		