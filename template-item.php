<?php


    /**
    * Template Name: template-Item.php (Place)
    * Preview: http://mycity.vioo.ru/wp-content/themes/mycity_4/02.html
    */
	 $showas = (isset($_GET['showas'])) ? sanitize_text_field($_GET['showas']) : '';

	 $set = get_theme_mod("site_Identity_layout",'s2');
     //$set = 's1';

	 if ( ($set == 's2' || $showas =='wide') && $showas !='boxed' ) {
	 get_template_part("template","item-wide");
     } else {
	 global $mycity_dditional;
	 $mycity_dditional .= " boxed";
     get_header();




     ?>
      <?php
        get_sidebar();
        ?>
<div id="container">

    <!--header-->
    <div class="container page_info place_info place-boxed-info">
        <div class="col_md_12">
            <?php

				$mycity_img = esc_url(get_template_directory_uri()."/img/img.png");
                   $mycity_small_img = wp_get_attachment_url(get_post_meta(get_the_ID(), '_small_img', true));
                $mycity_small_img  = esc_url(bfi_thumb( $mycity_small_img, array(  'width' => 110, 'height' =>110 )));

                if( $mycity_small_img ) {
                   ?><img class="schema_image" property="schema:image"  src="<?php echo esc_url($mycity_small_img); ?>" alt="<?php the_title(); ?>" />
            <?php } ?>
            <h1><?php the_title(); ?></h1>
            <ul>
                <?php
                    global $mycity_post_terms;
                    $mycity_post_terms = wp_get_object_terms( (int)$post->ID, "places_categories");

                    $mycity_tags_io = @explode(",",get_post_meta((int)$post->ID, '_tags', TRUE));
                    foreach ($mycity_tags_io as $mycity_tag) {
                    	?>
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>places/?showas=list&tags=<?php echo esc_html($mycity_tag);?>"><?php echo esc_html($mycity_tag);?></a></li>
                <?php
                    }
                    ?>
            </ul>
        </div>
    </div>
</div>
<div class="container place-container-boxed">
    <div class="row">
        <!-- Left column-->
        <div class="col-md-3 mobile_none sidebar">
            <div>
                <!--map place point-->
                <div class="address">
                    <?php  echo esc_html(get_post_meta((int)$post->ID, '_adress', true));
                        $GLOBALS["mycity_post__ID"] = (int)$post->ID;
                        ?>
                    <span></span>
                </div>
                <div id="map_place" class="map_place"></div>
                <?php
                    if (current_user_can("edit_post",(int)$post->ID)) {
                    	?>
                <center><Br><br><a href='#' onclick='window.location="<?php echo esc_url( home_url( '/' ) ); ?>submit-place/<?php echo (int)esc_html($post->ID); ?>";return false' data-style="zoom-out" class='btn btn-primary ladda-primary' ><?php esc_html_e("Edit place","mycity");?></a></center>
                <?php
                    }

                    get_template_part("partials/place","similar");
                    ?>
            </div>
        </div>
        <!--content-->
        <div class="col-md-9 basic">
            <!--Header section-->
            <div class="header-section">
            <?php
            $big_img = wp_get_attachment_url(  get_post_meta($post->ID, '_big_img', true) );
                $params = array(  'width' => 1000, 'height' =>270 );
                $header_section = bfi_thumb( $big_img, $params );
            ?>
                <img src="<?php echo esc_url($header_section); ?>" alt="<?php the_title(); ?>">
            </div>

       <?php
                if (isset($_GET['form'])) {
                	get_template_part( 'template', 'add' );
                } else {
                	get_template_part( 'partials/place', 'body' );
                	?>

            <!-- partials/place', 'body' -->

            <?php
                }
                get_template_part("partials/place","checkins");

                get_template_part("partials/place","offer");

                ?>
            <?php
                get_template_part("partials/place","mobile-visibli");

                get_template_part("partials/place","instagram");
                ?>
        </div>
    </div>
    <?php
        $mycity_textInput = get_post_meta((int)$post->ID, '_myfield', true);
        ?>
    <script type="text/javascript">
        function initialize_map() {

        	//Map parametrs
            var mapOptions_place = {
        		scrollwheel: true,
                zoom: 14,
                center: new google.maps.LatLng(<?php echo esc_html($mycity_textInput); ?>),
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
              styles: global_map_styles
        		};
            //map
            var map_place = new google.maps.Map(document.getElementById("map_place"), mapOptions_place);
            //positions
            var point_place = new google.maps.LatLng(<?php echo esc_html($mycity_textInput); ?>);
            //markers
            var marker_place = className = 'Cafe';
            var marker_place = new google.maps.Marker({
                position: point_place,
                map: map_place,
                category: '',
                icon: '<?php echo esc_html(mycity_get_marker_by_id($mycity_post_terms[0]->term_id)); ?>',
                title: "point_place"
            });

        	jQuery.get(pluginsUrl+"/GeoCity/ajax.php?update_post_view=<?php echo (int)esc_html($post->ID);?>",function(d){ });
        	<?php
            $mycity_cordinats = get_post_meta((int)get_the_ID(), '_myfield', true);
            preg_match("/(.*?),(.*?)$/", $mycity_cordinats, $mycity_math);
            if (!isset($mycity_math[1]))
                $mycity_math[1] = 0;
            if (!isset($mycity_math[2]))
                $mycity_math[2] = 0;
            $mycity_location_latitude =  sanitize_text_field($mycity_math[1]);
            $mycity_location_longitude =  sanitize_text_field($mycity_math[2]);


            ?>
				var tag = "1";
                var clientid = "0436121e11394b04ada01c924e0b825a";
                var arr = new Array();
                var lat = "<?php echo @esc_html($mycity_location_latitude);?>";
                var lng = "<?php echo @esc_html($mycity_location_longitude);?>";

        		jQuery.ajax({
        			type:"GET",
        			dataType:"jsonp",
        			cache:true,
        			url:"https://api.instagram.com/v1/locations/<?php echo esc_html(get_post_meta(get_the_ID(), 'instaid',true));?>/media/recent?client_id="+clientid,
        			success:function(response){
        				try{
        					//console.log(response['data']);
        					jQuery.each(response['data'], function(index, elem) {

        						jQuery("#pbasicuse").append('<li>' +
        						'<a href="'+elem['link']+'" target=_blank><img width=100 src="'+elem['images']['low_resolution']['url']+'" alt="{{title}}" /></a>' +
        						'</li>');
        					});
        				}catch(e){}
        			}});
        }
    </script>
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {


        if($("p").is('.no_events')) {
            $('.no_events').parents(".ajde_evcal_calendar").remove();
        }
        });
        jQuery('#submit-review').click(function(e){
            e.preventDefault();
            jQuery('.modal_popup,#msity_rewiew').show();
        });
        // var docH = jQuery(document).height();
        // alert(docH);
    </script>
</div>
<div class="modal_popup">
</div>
<div id='msity_rewiew'>
    <a href="#" class="close_msity"><i class="fa fa-times"></i></a>
    <?php
    $mycity_short_code = get_theme_mod('my_Testimonials_form',
        "[show-testimonials-form subtitle='on' subtitle_url='on' rating='on' email='on' style='tt_simple' ]");
    echo do_shortcode($mycity_short_code);
    ?>
</div>
</div>
<script>

var height2 = jQuery(window).height()*1.4;
jQuery(document).ready(function ($) {

    setTimeout(function(){
           $('#hero-bg').css({
            minHeight: height2
    });
    },200);

	if ($('div').is("#hero-bg")) {
        var tranform = true;

		$(window).scroll(function () {
		  if(tranform == true) {
		        var current_pull = $('#hero-bg').css('transform');
		  }

         // console.log(current_pull + " " + $(window).scrollTop() );
          if($(window).scrollTop()  > (height2 / 1.3)) {
              $('#hero-bg').css({
                position: 'fixed',
                top: '-480px'
            });
            mycity_paralax_tr = false;

            tranform = false;
          } else {
             mycity_paralax_tr = true;
          }

		});
	}
});

</script>

<?php


    get_footer();
    }
    ?>