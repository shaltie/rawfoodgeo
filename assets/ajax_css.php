<?php

add_action('wp_head','mycity_css_generator');
add_action('customize_preview_init','mycity_css_generator');
add_action('customize_render_section','mycity_css_generator');



function mycity_css_generator(){
  if (!current_user_can("administrator") || isset($wp_customize)){
    return;
    exit();
    }
    
    global $wp_filesystem;
    if (empty($wp_filesystem)) {
        require_once(ABSPATH . '/wp-admin/includes/file.php');
        WP_Filesystem();
    }
    $mycity_upload_dir = wp_upload_dir();
    $mycity_filename = trailingslashit($mycity_upload_dir['basedir']).'main.css';
    /*****************************************************************/
    $con = $wp_filesystem->get_contents(get_template_directory() . "/css/main.css");
    $con = mycity_color_hack($con);
    preg_match_all("/#([A-z0-9]{6,6}?)/", $con, $arr);
    $colors = $arr[1];
    $colors = array_unique($colors);
    foreach ($colors as $k => $v) {
    $tmp_settingname = 'colors_m_' .strtoupper($v);
    $color = get_theme_mod($tmp_settingname);
    if ($color) {
        $v = esc_attr($v);
        $color = esc_attr($color);
        
        $con = str_replace("#" . $v, $color, $con);
        $con = str_replace("#" . strtolower($v), $color, $con);
   
        $con = str_replace('../', get_template_directory_uri()."/", $con);
     }
    }
    if (is_single()) {
    $con .= "#container {
    margin-top: 150px;
    }";
    }
$name_fonts = sanitize_text_field(get_theme_mod('fonts_name', ''));
if (strlen($name_fonts) > 5) {
    $con .= "h1 {".
    wp_kses_post(str_replace(';', '!important;', $name_fonts)).
    "}";
}
$mycity_categories  = get_categories("taxonomy=places_categories&hide_empty=0");
$places_categories = array();

if (!isset($mycity_categories['errors']) && count($mycity_categories)>0) {
foreach ($mycity_categories  as $place_cat) {
$con .= ".menu li a.".esc_html($place_cat->slug).".activmap, .menu li a.". esc_html($place_cat->slug)
.":hover, .menu li a.".esc_html($place_cat->slug).":focus {
     background:".esc_html(get_option("fa_color_" . (int)$place_cat->
        term_id)).";transition: 0.3s;
    }";
}
}

    /*******************************************************************/
    $F = $wp_filesystem->put_contents($mycity_filename, $con, FS_CHMOD_FILE);
}




function mycity_css_generator_custumize(){
 /* if (!current_user_can("administrator")){
    return;
    exit();
    }*/
    
    global $wp_filesystem;
    if (empty($wp_filesystem)) {
        require_once(ABSPATH . '/wp-admin/includes/file.php');
        WP_Filesystem();
    }
    $mycity_upload_dir = wp_upload_dir();
    $mycity_filename = trailingslashit($mycity_upload_dir['basedir']).'main.css';
    /*****************************************************************/
    $con = $wp_filesystem->get_contents(get_template_directory() . "/css/main.css");
    $con = mycity_color_hack($con);
    preg_match_all("/#([A-z0-9]{6,6}?)/", $con, $arr);
    $colors = $arr[1];
    $colors = array_unique($colors);
    foreach ($colors as $k => $v) {
    $tmp_settingname = 'colors_m_' . strtoupper($v);
    $color = get_theme_mod($tmp_settingname);
    if ($color) {
        $v = esc_attr($v);
        $color = esc_attr($color);
        
        $con = str_replace("#" . $v, $color, $con);
        $con = str_replace("#" . strtolower($v), $color, $con);
   
        $con = str_replace('../', get_template_directory_uri()."/", $con);
     }
    }
    if (is_single()) {
    $con .= "#container {
    margin-top: 150px;
    }";
    }
$name_fonts = sanitize_text_field(get_theme_mod('fonts_name', ''));
if (strlen($name_fonts) > 5) {
    $con .= "h1 {".
    wp_kses_post(str_replace(';', '!important;', $name_fonts)).
    "}";
}
$mycity_categories  = get_categories("taxonomy=places_categories&hide_empty=0");
$places_categories = array();

if (!isset($mycity_categories['errors']) && count($mycity_categories)>0) {
foreach ($mycity_categories  as $place_cat) {
$con .= ".menu li a.".esc_html($place_cat->slug).".activmap, .menu li a.". esc_html($place_cat->slug)
.":hover, .menu li a.".esc_html($place_cat->slug).":focus {
     background:".esc_html(get_option("fa_color_" . (int)$place_cat->
        term_id)).";transition: 0.3s;
    }";
}
}

    /*******************************************************************/
    return $con;
}

?>