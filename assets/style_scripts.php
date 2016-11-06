<?php

add_action('wp_enqueue_scripts', 'mycity_style_scripts', 500);


function mycity_print_my_inline_script()
{

    ?>
    <script type="text/javascript">
        "use strict";
        var mycity_paralax_tr = true;
        var templateUrl = '<?php echo esc_url(get_template_directory_uri()); ?>';
        var pluginsUrl = '<?php echo esc_url(plugins_url()); ?>';
        var global_map_styles = <?php $s = get_theme_mod('map_stylemap_json', '[]');if ($s == "") {
            echo "[]";
        } else {
            echo $s;
        }  ?>;
        var
            marker, markers;
    </script>


    <?php

}

add_action('wp_head', 'mycity_print_my_inline_script', 8);


/**
 * We print the scripts and styles in the frontend
 */

function mycity_style_scripts()
{


    global $MyCity_class, $post, $mycity_bg_img, $wp_query, $wp_filesystem;

    if (empty($wp_filesystem)) {
        require_once(ABSPATH . '/wp-admin/includes/file.php');
        WP_Filesystem();
    }
    $enabel_bg_on_mobile = get_theme_mod('mobile_bg', true);

    $mycity_upload_dir = wp_upload_dir();

    $mycity_filename = trailingslashit($mycity_upload_dir['basedir']) . 'main.css';


    if (isset($post->ID) && get_post_type($post->ID) == 'places') {
        //  @setcookie('mycity_post_id', $post->ID, time() + 36000);
        setcookie('mycity_post_id_2', $post->ID, time() + 62208000, '/', $_SERVER['HTTP_HOST']);
        @$_COOKIE['mycity_post_id'] = (int)$post->ID;

    }
    if (is_single() || is_page()) {
        remove_theme_support('custom-background');
    }


    //   enqueue google_fonts
    wp_enqueue_style('mycity_fonts_google', $MyCity_class->google_fonts_url('Gloria+Hallelujah'));
    wp_enqueue_style('mycity_fonts_google_roboto', $MyCity_class->google_fonts_url('Roboto:400,100italic,100,300,300italic,400italic,500,500italic,700,700italic,900,900italic&#038;subset=latin,cyrillic,cyrillic-ext,latin-ext,greek-ext,greek,vietnamese'));
    $m = get_theme_mod('fonts_url');
    if (isset($m) && strlen(get_theme_mod('fonts_name')) > 3) {
        $url = explode('=', $m);

        wp_enqueue_style('mycity_fonts_google_custum', urldecode($MyCity_class->google_fonts_url($url[1])));

        if (preg_match('/font-family/', get_theme_mod('fonts_name'))) {


            $custom_css_f = " h1{
               " . str_replace(";", "", get_theme_mod('fonts_name')) . "   !important;
           }";
        } else {
            $custom_css_f = " h1{
                 font-family: '" . get_theme_mod('fonts_name') . "' !important;
           }";
        }

        wp_add_inline_style('mycity_fonts_google_custum', $custom_css_f);
    }


    /**
     * enqueue style
     */
    wp_enqueue_style('mycity_2bootstrap', get_template_directory_uri() .
        "/css/bootstrap.css");
    wp_enqueue_style('mycity_2bootstrap-tagsinput', get_template_directory_uri() .
        "/css/bootstrap-tagsinput.css");
    wp_enqueue_style('mycity_2style_avatar', get_template_directory_uri() .
        "/css/avatar.css");
    wp_enqueue_style('mycity_font-awesome', get_template_directory_uri() .
        "/css/font-awesome.css");
    wp_enqueue_style('mycity_ladda_min', get_template_directory_uri() .
        "/css/ladda.min.css");
    wp_enqueue_style('mycity_2master', get_template_directory_uri() .
        "/css/master.css");
    wp_enqueue_style('mycity_2master2', get_template_directory_uri() .
        "/css/master2.css");
    wp_enqueue_style('mycity_font_fmr', get_template_directory_uri() .
        "/css/font_fmr.css");


    $custom_css_f = " .tc-container  , .tickera{
        display: block !important;
    }";


    $showas = (isset($_GET['showas'])) ? sanitize_text_field($_GET['showas']) : '';


    $set = get_theme_mod("site_Identity_layout", 's2');
    if (($set == 's2' || $showas == 'wide') && $showas != 'boxed' && is_single()) {

    } else {
        //Get background image
        if (isset($mycity_bg_img) && substr_count($mycity_bg_img, "img/bg2.jpg")) $mycity_bg_img = "";
        $bg = get_theme_mod('background_image');

        if (strlen(get_header_image()) > 3) $bg = get_header_image();

        if (strlen($mycity_bg_img) < 3 && strlen($bg) > 3) $mycity_bg_img = esc_attr($bg);

        if (strlen($mycity_bg_img) < 3) $mycity_bg_img = get_template_directory_uri() . '/img/bg2.jpg';

        if (!wp_is_mobile() && $enabel_bg_on_mobile == false) {
            $custom_css_f .= "
        #hero-bg {
         display: none !important;
        }      
        body {
            background:  url(" . $mycity_bg_img . ")  !important;
            background-attachment: fixed !important;
            background-size: cover!important;
        } 
        ";
        }

    }

    if (wp_is_mobile() && $enabel_bg_on_mobile == false) {
        $custom_css_f .= "
        #hero-bg {
         display: none !important;
        }
        body {
            background:  none  !important;

        }
        ";
    }

    $color_s = get_theme_mod('colors_sidebar_w');
    if (!empty($color_s)) {
        $custom_css_f .= "
        .pushy .profile , .pushy , .pushy .side_menu li a {
            background:" . sanitize_text_field($color_s) . " !important;
        }
        ";
    }
    $color_s_i = get_theme_mod('colors_sidebar_i');
    if (!empty($color_s_i)) {
        $custom_css_f .= "
       .pushy .side_menu li a:hover i{
            background:" . sanitize_text_field($color_s_i) . " !important;
        }
        ";
    }
    $grid = false;
    if (isset($_GET['showas']) && $_GET['showas'] == 'grid')
        $grid = true;

    if (get_theme_mod('performans_small_h', true) && $grid == false) {
        $custom_css_f .= "
         .Places_list  .container-fluidcontainer-fluid_pad_off{
             max-height: 350px;
        }
        .Places_list  .container-fluidcontainer-fluid_pad_off.archive  .page_info h1 {
             padding-top: 30px;
        }
        .category  .page_info{
         max-height: 350px;

        }
        .category  .page_info .blog_category{
            margin-top: -50px !important;}
        ";
    }
    wp_add_inline_style('mycity_2master', $custom_css_f);


    if (get_theme_mod('site_Identity_fog') != false) {
        wp_add_inline_style('mycity_2master', ".infinite-background  {
        background:  none;
        }");
    }


    wp_enqueue_style('mycity_2animate', get_template_directory_uri() .
        "/css/animate.css");


    if ($wp_filesystem->exists($mycity_filename)) {
        $url = $mycity_upload_dir["baseurl"];
        if ($_SERVER['HTTPS'] == 'on'){
            $url=  str_replace('http://','https://',$url);
        }
        wp_enqueue_style('mycity_css_php_2', $url . "/main.css");

    } else {
        wp_enqueue_style('mycity_css_php_2', get_stylesheet_directory_uri() . "/css/main.css");
    }
    wp_enqueue_style('mycity_2adaptive', get_stylesheet_directory_uri() .
        "/css/adaptive.css");
    if (get_theme_mod('events_events_control') == false)
        wp_enqueue_style('mycity_2muevent', get_stylesheet_directory_uri() . "/css/myeventon.css");

    // add inlain style   


    //Get background image
    if (strlen($mycity_bg_img) < 3 && strlen(esc_attr(get_theme_mod('background_image'))) > 3) $mycity_bg_img = esc_attr(get_theme_mod('background_image'));
    if (strlen($mycity_bg_img) < 3) $mycity_bg_img = get_template_directory_uri() . '/img/bg2.jpg';
    $custom_css = ".page .ajde_evcal_calendar {
	display: block !important;
}";


    if (is_single()) {
        $custom_css .= "#container {
    margin-top: 150px;        
    ";
    }

    if (mycity_newBasename(false, true) == 'template-add.php') {
        $custom_css .= "
        #hero-bg {
         height: 1500px !important;
        }       
        ";
    }
    // single style
    if (is_single()):
        $custom_css .= "
      .post.p_style_one {        
         background: url(" . $MyCity_class->get_pots_image_url() . ") no-repeat;
         background-size: cover;
      }";
        if (!$MyCity_class->get_pots_image_url()) {
            $custom_css .= "
        .post.p_style_one {
            margin-top: -170px;
         }";


        }
    endif;


    wp_add_inline_style('mycity_css_php', $custom_css);


    //edit places
    $custom_css_2 = "";
    $draft_id = isset($wp_query->query_vars['page']) ? $wp_query->query_vars['page'] : "";
    $small_img = wp_get_attachment_image_src(get_post_meta($draft_id, '_small_img', true),
        'thumbnail');
    $custom_css_2 .= ".dropzone_add_img_1 {
           background-image:url(" . esc_url($small_img[0]) . ");
            background-size: 100%;

    }";

    $big_img = wp_get_attachment_url(get_post_meta($draft_id, '_big_img', true));
    $params = array('width' => 850, 'height' => 250);
    $header_section = bfi_thumb($big_img, $params);

    $custom_css_2 .= "   .dropzone_add_img_2 {
    background-image:url(" . esc_url($header_section) . ");
    background-size: 100%;
             } ";
    $custom_css_2 .= "
    /*body {
    background: none !important;
    }*/
    .body_opacity {
            background: rgba(0,0,0,1);
        }
    ";


    wp_add_inline_style('mycity_2adaptive', $custom_css_2);

    global $wp_customize;
    /**
     * Connect the styles
     *

     */

    if (is_user_logged_in() || isset($wp_customize)) {
        wp_enqueue_style('mycity_is_admin', get_template_directory_uri() .
            "/css/is_admin.css");

        if (isset($wp_customize))
            wp_add_inline_style('mycity_is_admin', mycity_css_generator_custumize());

    } else {
        wp_enqueue_style('mycity_is_not_admin', get_template_directory_uri() .
            "/css/is_not_admin.css");
    }

    /**
     * enqueue_script
     */

    if (is_singular()) wp_enqueue_script("comment-reply");

    //  if (!wp_is_mobile() && $enabel_bg_on_mobile == false) {
    wp_enqueue_script('mycity_asparagus', get_template_directory_uri() .
        "/js/asparagus.js", array("mycity_bootstrap_min", 'jquery'), 1, true);
    // }
    wp_enqueue_script('mycity_all_scr', get_template_directory_uri() .
        "/js/all_scr.js", array("mycity_bootstrap_min", 'jquery'), 1, true);

    wp_enqueue_script('mycity_wow', get_template_directory_uri() . "/js/wow.min.js");

    if (get_theme_mod('performans_scroll_hidde', false) != false)
        wp_enqueue_script('mycity_jquery_scroll', get_template_directory_uri() . "/js/jQuery.scrollSpeed.js");


    wp_enqueue_script('mycity_maps_googleapis',
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyCsbzuJDUEOoq-jS1HO-LUXW4qo0gW9FNs&libraries=places&callback=initialize_map',
        array('mycity_all_scr'), 3, true);
    wp_enqueue_script('mycity_bootstrap_min', get_template_directory_uri() .
        "/js/bootstrap.min.js", array("jquery"), 1, true);
    wp_enqueue_script('mycity_typed_min', get_template_directory_uri() .
        "/js/typed.min.js", array("jquery"), 1, true);
    wp_enqueue_script('mycity_bootstrap_min', get_template_directory_uri() .
        "/js/jquery.interactive_bg.min.js", array("jquery"), 1, true);

    wp_enqueue_script('mycity_dropzone', get_template_directory_uri() .
        "/js/dropzone.js", array(), 1, true);

    wp_register_script('mycity_map_init', get_template_directory_uri() .
        "/js/map_init.js");
    wp_enqueue_script('mycity_map_init');


    //script live edit

    wp_enqueue_script('mycity_tremula', get_template_directory_uri() . "/js/libs/tremula_new.js");


    if (current_user_can('administrator')) {
        wp_enqueue_script('mycity_admins', get_template_directory_uri() . '/js/admins.js', "",
            1, true);
    } else {

        if ($_SERVER['HTTP_HOST'] == 'city1.vioo.ru' && isset($_COOKIE['lang'])) {
            //this code work only on our demo page. Need for helping translate the theme
            wp_enqueue_script('mycity_hlptranslate', get_template_directory_uri() . '/js/help_translate.js', "",
                1, true);
            wp_enqueue_style('mycity_hlptranslatejs', get_template_directory_uri() .
                "/css/help_translate.css");
        }

    }
    //okvideo
    $id = esc_attr(get_theme_mod('my_ok_video_url'));
    if ((is_home() || is_front_page()) && strlen($id) > 1) {
        wp_enqueue_script('mycity_nokvideo', get_template_directory_uri() .
            "/js/okvideo.js", array(), 1, true);
    }

    /**
     * Get the value of an option and create a method for an object js
     */
    $options = get_option('mycity_theme_options');

    if (strlen($options['mycity_theme_options_body']) < 5) {
        $options['mycity_theme_options_body'] = "43.119596, 131.877330";
    }
    $options2 = explode(',', get_theme_mod('Coordinates_map'));

    //Coordinates_map
    if ((int)get_theme_mod('map_zoom_map') != 0) {
        $zum = (int)get_theme_mod('map_zoom_map');

    } else {
        $zum = 13;
    }
    $lat = isset($options2[0]) ? $options2[0] : "";
    $long = isset($options2[1]) ? $options2[1] : "";

    if (isset($_GET['lat']) && !empty($_GET['lat'])) {
        $lat = sanitize_text_field($_GET['lat']);
    }
    if (isset($_GET['long']) && !empty($_GET['long'])) {
        $long = sanitize_text_field($_GET['long']);
    }

    $glbal_style = '[]';
    $s = get_theme_mod('map_stylemap_json', '[]');
    if ($s == "") {
        $glbal_style = "[]";
    } else {
        $glbal_style = $s;
    }
    $gelocation = esc_attr(get_theme_mod('site_Identity_geolocation', false));
    if (!isset($_SERVER['HTTPS'])) $gelocation = true;
    wp_localize_script('mycity_map_init', 'MyCity_map_init_obj', array(
        //    var global_map_styles = <?php $s = get_theme_mod('map_stylemap_json', '[]');if ($s == "") {
        'theme_url' => esc_url(get_template_directory_uri()),
        'global_map_styles' => ($glbal_style),
        'lat' => $lat,
        'longu' => $long,
        'zum' => esc_attr($zum),
        'ajaxurl' => esc_url(site_url()) . '/wp-admin/admin-ajax.php',
        'direct' => get_template_directory_uri(),
        'weather_latitude' => esc_attr(get_theme_mod('weather_weather_latitude', '0')),
        'weather_longitude' => esc_attr(get_theme_mod('weather_weather_longitude', '0')),
        'weather_APPID' => esc_attr(get_theme_mod('weather_weather_APPID', '')),
        'hide_paralax' => esc_attr(get_theme_mod('performans_paralax_hidde', 'false')),
        'uber_dp' => esc_attr(get_theme_mod("uber_show_distance_speed", "15")),
        'uber_sd' => esc_attr(get_theme_mod("uber_show_distance")),
        'geolocation' => $gelocation,
        'weather' => esc_attr(get_theme_mod('weather_weather_control', 's2'))));


    wp_enqueue_script('mycity_bootstrap-tagsinput', get_template_directory_uri() .
        "/js/bootstrap-tagsinput.min.js", array(), 1, true);
    wp_enqueue_script('mycity_ladda.min', get_template_directory_uri() .
        "/js/ladda.min.js", array(), 1, true);
    wp_enqueue_script('mycity_masonry', "https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.min.js");
    if (current_user_can('administrator')) {
        @wp_enqueue_script('mycity_admins', get_template_directory_uri() . '/js/admins.js', "",
            1, true);
    }

}


//init scripts and style


/**
 * init admin scripts and style
 */
function mycity_style_scripts_admin()
{
    wp_enqueue_style('mycity_wp-color-picker');
    wp_enqueue_style('mycity_font-awesome', esc_url(get_template_directory_uri() . "/css/font-awesome.min.css"));

    wp_enqueue_script('mycity_custom-script-handle', get_template_directory_uri() .
        '/js/admins.js', array('wp-color-picker'), false, true);
    wp_enqueue_script('mycity_admincolor.js', get_template_directory_uri() .
        "/js/admincolor.js", array('wp-color-picker'), false, true);
    wp_enqueue_style('mycity_is_admin', get_template_directory_uri() .
        "/css/is_admin.css");
    wp_enqueue_style('mycity_maps_googleapis', "https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places");

    wp_enqueue_style('mycity_font_fmr', get_template_directory_uri() .
        "/css/font_fmr.css");

    wp_enqueue_style('mycity_font-awesome20', get_template_directory_uri() .
        "/css/font-awesome.css");

}

add_action('admin_enqueue_scripts', 'mycity_style_scripts_admin');

