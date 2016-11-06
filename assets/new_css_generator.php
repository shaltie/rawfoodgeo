<?php
/**
 * generator css code
 */
function mycity_new_css_generator()
{

    if (!defined('ABSPATH')) {
        /** Set up WordPress environment */
    $parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );    
    require_once( $parse_uri[0] . 'wp-load.php' );
    }


    global $wp_filesystem;

    //the existence check
    if (empty($wp_filesystem)) {
        require_once(ABSPATH . '/wp-admin/includes/file.php');
        WP_Filesystem();
    }


    $mycity_categories  = get_categories("taxonomy=places_categories&hide_empty=0");

    $places_categories = array();
    foreach ($mycity_categories  as $place_cat) {
        ?>
        .menu li a.<?php echo esc_html($place_cat->slug); ?>.activmap, .menu li a.<?php echo
        esc_html($place_cat->slug); ?>:hover, .menu li a.<?php echo esc_html($place_cat->
        slug); ?>:focus {
        background: <?php echo esc_html(get_option("fa_color_" . (int)$place_cat->
            term_id)); ?>;
        transition: 0.3s;
        }

        <?php
    }

    //get the file
    $con = $wp_filesystem->get_contents(get_template_directory() . "/css/main.css");


    $con = mycity_color_hack($con);
    preg_match_all("/#([A-z0-9]{6,6}?)/", $con, $arr);

    $colors = $arr[1];
    $colors = array_unique($colors);

    foreach ($colors as $k => $v) {

        $tmp_settingname = 'colors_m_' . $v;
        $color = get_theme_mod($tmp_settingname);
        if ($color) {
            $v = esc_attr($v);
            $color = esc_attr($color);

            echo "//$v have benn change to $color";
            $con = str_replace("#" . $v, $color, $con);
            //
            $con = str_replace('../', '', $con);
        }
    }
    if (is_single()) {
        $con .= "#container {margin-top: 150px;	}";
    }

    echo trim($con);
}