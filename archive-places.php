<?php
//Geocity template have 3 templates to show categories.
//Webmaster can select basic template in template settings, but user can another if pass ?showas=map,?showas=list,?showas=grid,
if(isset($_POST['search_type']) && $_POST['search_type'] ==  '2'){
    wp_safe_redirect(get_home_url('/').'?s=' .$_POST['search']);

}




if (isset($_POST['search'])) {
    $mycity_args = array(
        'post_type' => 'places',
        's' => esc_html($_POST['search']),
        'show_posts' => 1
    );

    if(isset($_POST['search_type']) && $_POST['search_type'] ==  '2'){
        wp_safe_redirect(get_home_url('/').'?s=' .$_POST['search']);

    }



    $place = "";
    if(strlen(fmr_get_permalink_by_template('Places_map2.php')) > 1){
        $place = fmr_get_permalink_by_template('Places_map2.php');
    }
    if(strlen(fmr_get_permalink_by_template('Places_map.php')) > 1){
        $place = fmr_get_permalink_by_template('Places_map.php');
    }
    $place = 'place/';
    if(trim($_POST['cat_slug']) == '-1') {
       $url =  $place.'?showas=list&search='.  urlencode($_POST['search']);
    } else {
        $terms =  get_term_by( 'id',(int)$_POST['cat_slug'], 'places_categories');

        $url =  $place. esc_html($terms->slug).'/?showas=list&search='.  urlencode($_POST['search']);
    }

    wp_safe_redirect($url);
}
$mycity_placess = true;
$GLOBALS["mycity_placess"] = true;


$mycity_template = 'Places_map';
//if select new style map
if(get_theme_mod('map_style','s2') == 's1'){
    $mycity_template = 'Places_map_minimal';
}
if (isset($_GET['showas']) && sanitize_text_field($_GET['showas']) == 'list') $mycity_template  = 'Places_list';
if (isset($_GET['showas']) && sanitize_text_field($_GET['showas']) == 'grid') $mycity_template  = 'Places_grid';



get_template_part($mycity_template);

?>