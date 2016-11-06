<?php


global $mycity_bg_img, $MyCity_class;
$bg = get_theme_mod('events_footer_img');
if (isset($bg{2}))
    $mycity_bg_img = $bg;
?>
    <!DOCTYPE html>
<html <?php language_attributes(); ?> >
    <head>
        <?php
        global $MyCity_class, $mycity_dditional, $mycity_dditional2, $mycity_bg_img;

        if (function_exists("is_bbpress") && is_bbpress()) $mycity_dditional2 = " is_bbpress";

        if (defined("FRM_HAVE_DIALOG")) $mycity_dditional2 = " have_dialog";
        ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php if (is_single())
            mycity_fb_meta() //open graph;   ?>

        <?php if (get_theme_mod("site_Identity_layout", 's2') == 's2') $mycity_dditional .= " wide"; ?>
        <?php wp_head(); ?>
    </head>
    <a href="#" class="toptop"></a>
    <div class="anchor"><i class="fa fa-angle-double-up"></i></div>
<body id='hero' <?php body_class("inner_page innerpage $mycity_dditional 12 $mycity_dditional2"); ?>>
<?php
//Get background image
if (isset($mycity_bg_img) && substr_count($mycity_bg_img, "img/bg2.jpg")) $mycity_bg_img = "";
$bg = get_theme_mod('background_image');

if (strlen(get_header_image()) > 3) $bg = get_header_image();

if (strlen($mycity_bg_img) < 3 && strlen($bg) > 3) $mycity_bg_img = esc_attr($bg);

if (strlen($mycity_bg_img) < 3) $mycity_bg_img = get_template_directory_uri() . '/img/bg2.jpg';


if (isset($GLOBALS['mycity_paralax_hide']) && $GLOBALS['mycity_paralax_hide'] == true) {

} else {

    $mycity_id = (get_theme_mod('my_ok_video_url'));
    if (!(strlen($mycity_id) > 1 && is_front_page() && !is_single())) {


        if (!isset($_GET['showas'])) {
            ?>
            <div id="hero-bg" data-img="<?php echo esc_url($mycity_bg_img); ?>"></div>

            <?php
        }
    }
}

?>
    <div class="body_opacity"></div>

    <header class="1" id="header">


        <?php
        if (strlen(get_theme_mod('mycity_top_header_left') > 0 || strlen(get_theme_mod('mycity_top_header_right')) > 0)) { ?>
            <div id="top_line">
                <div class="container">
                    <?php //header top block
                    get_template_part("partials/header", "top"); ?>
                    <!-- End row -->
                </div>
                <!-- End container-->
            </div><!-- End top line-->

            <?php
        } ?>


        <div class="container navigate_full">
            <div class="row">
                <div class="col-md-12 clearfix map_header">
                    <a href="#" class="menu_xs hidden-md hidden-sm hidden-lg">
                        <i class="fa fa-bars fa-2x"></i>
                    </a>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                        <img
                            src="<?php echo esc_url(get_theme_mod('themeslug_logo', get_stylesheet_directory_uri() . '/img/logoin.png')); ?>"
                            alt="">
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <a href="#" class="weather">
                        <span></span></a>
                    <?php
                    $mycity_defaults = array(
                        'theme_location' => 'mycity_topmenu',
                        'menu' => '',
                        'container' => 'div',
                        'container_class' => '',
                        'container_id' => '',
                        'menu_class' => 'navigate head_nav',
                        'menu_id' => '',
                        'echo' => true,
                        'fallback_cb' => 'wp_page_menu',
                        'before' => '',
                        'after' => '',
                        'link_before' => '',
                        'link_after' => '',
                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth' => 0,
                        'walker' => new mycity_top_menu_walker());

                    if (@has_nav_menu('mycity_topmenu')) {
                        @wp_nav_menu($mycity_defaults);

                    } else {
                        $mycity_args = array(
                            'depth' => 0
                        , 'show_date' => ''
                        , 'date_format' => sanitize_text_field(get_option('date_format'))
                        , 'child_of' => 0
                        , 'exclude' => ''
                        , 'exclude_tree' => ''
                        , 'include' => ''
                        , 'title_li' => ''
                        , 'echo' => 1
                        , 'authors' => ''
                        , 'sort_column' => 'menu_order, post_title'
                        , 'sort_order' => 'ASC'
                        , 'link_before' => ''
                        , 'link_after' => ''
                        , 'meta_key' => ''
                        , 'meta_value' => ''
                        , 'number' => 5
                        , 'offset' => ''
                        , 'walker' => ''
                        );

                        ?>
                        <ul id="menu-topheader" class="navigate head_nav">
                            <?php
                            @wp_list_pages($mycity_args);
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

<?php

if (!isset($mycity_content_width)) $mycity_content_width = 1100;
get_sidebar();


?>


    <div class="header_section_popup"></div>
    <div class="site-overlay"></div>

    <div id="container">

        <!--div class="container page_info place_info">
            <div class="col-md-12 blog_category">
                <div class="open post_info single_h1">
                    <h1><?php the_title(); ?><span></span></h1>
                    <?php

        $short_desc = get_post_meta($post->ID, 'mycity_short_description', true);
        if (strlen(trim($short_desc)) > 2) {
            echo "<p>" . wp_kses_post($short_desc) . "</p>";
        }
        ?>
                </div>
            </div>

            <?php
        //get_template_part("partials/post","body-wide");


        ?>
        </div-->
        <?php ?>
        <!-------------------------------------------------------------->
        <div class="item_wide_container2" style="margin-top: 160px;">

            <div class="container <?php global $MyCity_class;
            echo esc_attr($MyCity_class->mycity_container_class()); ?>  ">
                <div class="row">
                    <div class="col-md-12 single_post_row">
                        <div class="place_li_cont">
                            <h1 style="color: #fff; text-align: center;"><?php the_title(); ?><span></span></h1>

                            <div class="post p_style_one open" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <div class="item_border"></div>
                                <div class="evo_popup" style="position: static;">


                                    <?php
                                    // Start the loop.
                                    while (have_posts()) : the_post();
                                        ?>
                                        <?php
                                        the_content();

                                        // End the loop.
                                    endwhile;
                                    ?>
                                    <?php

                                    while (have_posts()) :
                                        the_post();

                                        $start_date = get_post_meta(get_the_ID(), 'evcal_srow', true);
                                        $end_date = get_post_meta(get_the_ID(), 'evcal_erow', true);
                                        ?>
                                        <div class="evo_pop_body evcal_eventcard">
                                            <div class="evopop_top"
                                                 style="border-left-width: 3px; border-left-style: solid; border-left-color: rgb(32, 97, 119);">
                                                <span class="ev_ftImg"
                                                      style="background-image:url(http://tastecle.com/wp-content/uploads/2016/01/cleveland-fireworks-300x208.jpg)"></span><span
                                                    class="evcal_cblock" data-bgcolor="#206177" data-smon="march"
                                                    data-syr="2016">

                                                    <em class="evo_date">
                                                        <?php
                                                        if (date("d", $start_date) == date("d", $end_date)) {

                                                            ?>
                                                            <span
                                                                class="start"><?php echo esc_attr(date("d", $start_date)); ?>
                                                                <em></em></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span
                                                                class="start"><?php echo esc_attr(date("d", $start_date)); ?>
                                                                <em><?php echo date("d", $end_date); ?></em></span
                                                            <?php

                                                        } ?>
                                                        <?php
                                                        if (date("d", $start_date) == date("d", $end_date)) {

                                                            ?>
                                                            <span
                                                                class="end"> <?php echo esc_attr(date("M", $start_date)); ?></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span
                                                                class="end"> <?php echo esc_attr(date("M", $start_date)); ?>
                                                                <em><?php echo date("M", $end_date); ?></em></span>

                                                            <?php

                                                        }
                                                        ?>


                                                    </em>
                                                    <em
                                                        class="clear"></em></span>
                                            <em class="clear"></em></div>
                                            <div class="evo_metarow_fimg evorow evcal_evdata_img  evo_imghover"
                                                 data-imgheight="3692" data-imgwidth="5334"
                                                 style="height: 400px; background-image: url(&quot;<?php echo esc_url(mycity_get_thumbnail(get_the_id())); ?>&quot;);"
                                                 data-imgstyle="minmized" data-minheight="400" data-status="open"></div>
                                            <div
                                                class="evo_metarow_details evorow evcal_evdata_row bordb evcal_event_details">
                                                <div class="event_excerpt" style="display:none"><h3
                                                        class="padb5 evo_h3" <?php  esc_html_e('Event Details','mycity'); ?></h3>
                                                    <p></p></div>
                                                <span class="evcal_evdata_icons"><i
                                                        class="fa fa-align-justify"></i></span>
                                                <div class="evcal_evdata_cell ">
                                                    <div class="eventon_full_description">
                                                        <h3 class="padb5 evo_h3"><?php  esc_html_e('Event Details','mycity'); ?></h3>
                                                        <div class="eventon_desc_in" itemprop="description">
                                                            <?php


                                                            the_content(); ?>
                                                        </div>
                                                        <div class="clear"></div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="evo_metarow_time_location evorow bordb ">
                                                <div class="tb">
                                                    <div class="tbrow">
                                                        <div class="evcal_col50 bordr">
                                                            <div class="evcal_evdata_row evo_time">
                                                                <span class="evcal_evdata_icons"><i
                                                                        class="fa fa-clock-o"></i></span>
                                                                <div class="evcal_evdata_cell">
                                                                    <h3 class="evo_h3"><?php  esc_html_e('Time','mycity'); ?></h3>
                                                                    <?php

                                                                    $s = eventon_get_formatted_time($start_date);
                                                                    //var_dump($s);

                                                                    $lang = 'L1';
                                                                    $options_1 = get_option('evcal_options_evcal_1');
                                                                    $evopt1 = (!empty($options_1)) ? $options_1 : null;
                                                                    $evopt2 = get_option('evcal_options_evcal_2');

                                                                    /*$ll = eventon_get_custom_language($evopt2, 'evcal_lang_yrrnd','Year Around Event',$lang);
                                                                     var_dump($ll);*/

                                                                    $_is_end_date = true;
                                                                    $DATE_start_val = eventon_get_formatted_time($start_date);
                                                                    if (empty($end_date)) {
                                                                        $_is_end_date = false;
                                                                        $DATE_end_val = $DATE_start_val;
                                                                    } else {
                                                                        $DATE_end_val = eventon_get_formatted_time($end_date);
                                                                    }

                                                                    $ev_vals = get_post_meta(get_the_ID());
                                                                    $evopt2 = get_option('evcal_options_evcal_2');
                                                                    $evcal_lang_allday = eventon_get_custom_language($evopt2, 'evcal_lang_allday', 'All Day');

                                                                    //echo  eventon_get_formatted_time($start_date);
                                                                    $evoclass = new EVO_generator();
                                                                    $n = $evoclass->generate_time_($DATE_start_val, $DATE_end_val, $ev_vals,
                                                                        $evcal_lang_allday, '', '', $start_date, $end_date);

                                                                    echo $n['html_prettytime'];
                                                                    ?>
                                                                    <!--p>(Sunday) 7:00 pm - 10:00 pm</p-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="evcal_col50">
                                                            <div class="evcal_evdata_row evo_location">
                                                                <span class="evcal_evdata_icons"><i
                                                                        class="fa fa-map-marker"></i></span>
                                                                <div class="evcal_evdata_cell">
                                                                    <h3 class="evo_h3"> <?php  esc_html_e('Location','mycity'); ?></h3>
                                                                    <p class="evo_location_name">
                                                                        <?php echo get_post_meta(get_the_ID(), 'evcal_location_name', true); ?>
                                                                    </p>
                                                                    <p><?php echo get_post_meta(get_the_ID(), 'evcal_location', true); ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $thumbnail = wp_get_attachment_image(get_post_meta(get_the_ID(), 'evo_loc_img', true),
                                                'full');

                                            preg_match_all('#src="(.*?)"#si', $thumbnail, $thumb_url);

                                            ?>

                                            <?php if (isset($thumb_url[1][0]{1})) { ?>
                                            <div class="evo_metarow_locImg evorow bordb tvi"
                                                 style="height:400px;
                                                     background-image:url(<?php echo $thumb_url[1][0]; ?>)"
                                                 id="388_locimg">

                                                <?php if (get_post_meta(get_the_ID(), 'evcal_name_over_img', true) == 'yes') { ?>
                                                    <p class="evoLOCtxt">         <?php echo get_post_meta(get_the_ID(), 'evcal_location_name', true); ?>
                                                        <span><?php echo get_post_meta(get_the_ID(), 'evcal_location', true); ?></span>
                                                    </p>

                                                <?php } ?>
                                                </div><?php
                                            } ?>

                                            <div class="evo_metarow_gmap evorow evcal_gmaps bordb "
                                                 id="evc145910520056eb025f560f0490_gmap_evop"
                                                 style="height: 500px; position: relative; overflow: hidden; transform: translateZ(0px); background-color: rgb(229, 227, 223);"></div>


                                        </div>
                                        <?php

                                    endwhile;


                                    ?>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!------------------------------------------------------------------->
    </div>
<?php
//$latlng = '';
//var_dump(get_post_meta(get_the_ID(),'evcal_lat'));
$post_id = get_the_ID();
echo $lat = trim(get_post_meta($post_id, 'evcal_lat', true));
echo $lon = trim(get_post_meta($post_id, "evcal_lon", true));
$latlong = $lat . ',' . $lon;
?>
    <script>
        var geocoder;
        var test = 3;

        function getGeocoder() {
            return geocoder;
        }

        function initialize(map_canvas_id, address, mapformat, zoom_level, location_type, scrollwheel) {
            var map;
            geocoder = new google.maps.Geocoder();

            var latlng = new google.maps.LatLng(-34.397, 150.644);

            if (scrollwheel == false) {
                var myOptions = {
                    center: latlng,
                    mapTypeId: mapformat,
                    zoom: zoom_level,
                    scrollwheel: false,
                }
            } else {
                var myOptions = {
                    center: latlng,
                    mapTypeId: mapformat,
                    zoom: zoom_level
                }
            }


            var map_canvas = document.getElementById(map_canvas_id);
            map = new google.maps.Map(map_canvas, myOptions);


            // address from latlng
            if (location_type == 'latlng') {
                var latlngStr = address.split(",", 2);
                var lat = parseFloat(latlngStr[0]);
                var lng = parseFloat(latlngStr[1]);
                var latlng = new google.maps.LatLng(lat, lng);

                geocoder.geocode({'latLng': latlng}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {

                        var marker = new google.maps.Marker({
                            map: map,
                            position: latlng
                        });
                        //map.setCenter(results[0].geometry.location);
                        map.setCenter(marker.getPosition());
                        //console.log(results[0].geometry.location);
                    } else {
                        document.getElementById(map_canvas_id).style.display = 'none';
                    }
                });

            } else if (address == '') {
                console.log('t');
            } else {
                geocoder.geocode({'address': address}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {


                        //console.log('map '+results[0].geometry.location);
                        map.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location
                        });


                    } else {
                        document.getElementById(map_canvas_id).style.display = 'none';
                    }
                });
            }


        }


        function initialize_map() {

            initialize('evc145910520056eb025f560f0490_gmap_evop', '<?php echo get_post_meta(get_the_ID(), 'evcal_location', true); ?>', 'roadmap', 18, 'add', true);
        }
        jQuery(document).ready(function ($) {
            $(document).on("click", '.button_substribe', function (e) {
                e.preventDefault();
                $(".Subscribe_error").html(" ");
                var email = $("#subsribe .subsribe_email");
                email.removeClass('error');
                if (isValidEmailAddress(email.val())) {
                    var mylada = Ladda.create(document.querySelector('.button_substribe'));
                    mylada.start();
                    $.ajax({
                        url: "<?php echo esc_url(site_url()); ?>/wp-admin/admin-ajax.php",
                        type: 'POST',
                        data: "action=mycity_mailchimp_send&mail=" + email.val(),
                        success: function (date) {
                            $(".Subscribe_error").html(date);
                            mylada.stop();
                        }

                    });
                } else {
                    email.addClass('error');
                }
            });
        });
        function isValidEmailAddress(emailAddress) {
            var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
            return pattern.test(emailAddress);
        }
        jQuery('.page_info').css({
            height: jQuery(window).height() + 'px'
        });
        jQuery(document).ready(function ($) {

            $(window).scroll(function () {
                var scrollTop = jQuery(window).scrollTop();
                var height = 0;

                jQuery(".basic .style_list").each(function () {
                    height += $(this).height();
                });
                var ajaxheight = height - (jQuery(window).height() - 300);


                if (parseInt(jQuery(window).height() / 4.5) < parseInt(jQuery(window).scrollTop())) {
                    $('#hero-bg').addClass("fixid_notr");

                } else {
                    $('#hero-bg').removeClass("fixid_notr");
                }
            });
            /* $(window).resize(function () {
             jQuery('.page_info').css({
             height: jQuery(window).height() + 'px'
             });
             });
             $(".page_info").css("visibility", "visible");
             var catHeight = $('.blog_category').height();
             $('.blog_category').css({
             'margin-top': ((catHeight / 2) * (-1)) + 'px'
             })*/

        });

        /*----------------------Ajax  in categories-----------------------*/


    </script>
    <style>

        #hero {
            background: url("<?php echo $mycity_bg_img  ; ?>") !important;
            background-size: cover !important;
            background-repeat: no-repeat !important;

        }

        #hero-bg {
            background-position: 100% 100% !important;
            transform: translate3d(0px, 57px, 0px) !important;
            position: fixed !important;
        }

    </style>

<?php

get_footer();
?>