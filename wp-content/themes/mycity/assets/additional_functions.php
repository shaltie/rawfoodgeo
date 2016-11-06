<?php
global $MyCity_class;
/**
 * @return string url to ajax
 */
function mycity_get_ajax_uri()
{
    return plugins_url() . "/GeoCity";
}


/**
 * We get the number of follow Places
 *
 * @param int $id
 * @return array
 */
function mycity_get_visited($id)
{
    global $wpdb;
    $wpdb->hide_errors(); 
    $id = (int)$id;
    $sql = $wpdb->prepare("SELECT * FROM follow WHERE user1 = '%s' AND user2 < 0", $id);
    $followers = $wpdb->get_results($sql);
    $ids = array();
    
    $i = 0;
    foreach ($followers as $lover) {
        if($i > 0){
            $ids[] = $lover->user2 * -1;
        }
    $i++;
    }
	$ids=array_unique($ids);
    echo mycity_num2str(@count($ids), esc_html(__("Newbie", "mycity")), esc_html(__("One place followed",
        "mycity")), esc_html(__("% places followed", "mycity")));
    return $ids;
}

/**
 * @param $number
 * @param $zero
 * @param $one
 * @param $more
 * @return mixed
 */
function mycity_num2str($number, $zero, $one, $more)
{
    if ($number > 1) {
        $output = str_replace('%', number_format_i18n($number), (false === $more) ? '%' : $more);
    } elseif ($number == 0) {
        $output = (false === $zero) ? __('No', 'mycity') : $zero;
    } else { // must be one
        $output = (false === $one) ? __('One', 'mycity') : $one;
    }
    return esc_html($output);
}


global $mycity_onlineusers;
$id = get_current_user_id();
$mycity_onlineusers = get_option("onlineusers");

if (!$mycity_onlineusers) {
    add_option("onlineusers");
}
$mycity_onlineusers[$id] = time();
update_option("onlineusers", $mycity_onlineusers);

/**
 * Shows the number of users
 * @return mixed
 */
function mycity_get_users_online()
{
    global $mycity_onlineusers;
    foreach ($mycity_onlineusers as $lasttime) {
        if ($lasttime > time() - 120)
            $total++;
    }
    return $total;
}




/**
 * function returns the number of ttshowcase comments
 *
 * @param int $post_id
 * @return mixed
 */
function mycity_ttshowcase_coments_count($post_id)
{
    $comets_q = new WP_Query(array(
        'post_type' => 'ttshowcase',
        'post_status' => 'publish',
        "posts_per_page" => -1,
        "nopaging" => true,
        "orderby" => "menu_order",
        'meta_query' => array(array(
            'key' => '_insetr_post',
            'value' => $post_id,
        ))));

    return (int)$comets_q->post_count;
}



?>