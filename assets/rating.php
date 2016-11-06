<?php
/**
 * rating places
 * @param $pid
 * @return float
 */
function mycity_get_currentplace_rating($pid)
{
    $args = array('post_type' => 'ttshowcase', 'meta_query' => array(array('key' => '_insetr_post', 'value' => $pid)));

    $custom_query = new WP_Query($args);
    $arr_posts = array();
    if ($custom_query->have_posts()):
        while ($custom_query->have_posts()):
            $custom_query->the_post();
				$arr_posts[] = get_the_ID();
        endwhile;
    endif;

    $rating = 0;
    foreach ($arr_posts as $item) {
        $rating += (int)get_post_meta($item, '_aditional_info_rating', true);
    }
    if ($rating > 0) {
        $rating = $rating / count($arr_posts);
    }
    wp_reset_postdata();
    return (double)round($rating, 1);
}

?>