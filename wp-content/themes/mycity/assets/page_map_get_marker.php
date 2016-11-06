<?php

/**
 * @return maps point by term slug
 * @param $terms
 * @param string $ids
 * @return string
 */
function mycity_init_maps_point_by_term_slug($terms, $ids = "", $w = 110, $h = 110)
{
    ob_start();
    $args = array(
        'posts_per_page' => 30000000,
        'post_type' => array(
            'places'
        ),
        'tax_query' => array(array(
            'taxonomy' => 'places_categories',
            'terms' => sanitize_text_field($terms),
            'field' => 'id')
        )


    );

    if ($ids) {
        $args["post__in"] = $ids;
    }
    $MyCity_pmgm_query = new WP_Query($args);

    $points = array();
    if ($MyCity_pmgm_query->have_posts()):
        while ($MyCity_pmgm_query->have_posts()) {
            $MyCity_pmgm_query->the_post();
            $term_list = wp_get_post_terms(get_the_ID(), 'places_categories', array("fields" => "ids"));

            if (!in_array($terms, $term_list))
                continue;


            ob_start();

            $cordinats = esc_html(get_post_meta(get_the_ID(), '_myfield', true));
            /*coordinates*/

            preg_match("/(.*?),(.*?)$/", $cordinats, $math);
            if (!isset($math[1])) continue;
            $location_latitude = esc_attr($math[1]);
            $location_longitude = esc_attr($math[2]);
            if (strlen($location_latitude) < 5) continue;

            $img = esc_url(get_template_directory_uri()) . "/img/img.png";
            $small_img = esc_url(wp_get_attachment_url(get_post_meta(get_the_ID(), '_big_img', true)));
            $img = esc_html(bfi_thumb($small_img, array('width' => 300, 'height' =>190)));

            ?>

            {
            name: '<?php
            echo esc_html(get_the_title());
            ?>',
            location_latitude: '<?php
            echo esc_html($location_latitude);
            ?>',
            location_longitude:  '<?php
            echo esc_html($location_longitude);
            ?>',
            map_image_url: '<?php
            echo esc_url($img);
            ?>',
            name_point: '<?php
            echo esc_html(get_the_title());
            ?>',
            fa_icon: '<?php
            echo esc_attr( str_replace("\n", ' ',mycity_get_marker_by_id($terms))); ?>',
            km: '',
            time: '',
            fetaturesicon: '<?php
            $mycity_count2 = 0;
            preg_match_all('/\[bigfeature\](.*?):(.*?)\[\/bigfeature\]/is', get_the_content(), $mycity_bigfeatures);

            if (count($mycity_bigfeatures[1]) > 0) {
                foreach ($mycity_bigfeatures[1] as $k => $v) {
                    echo "" . $mycity_bigfeatures[1][$k] . "";
                    $mycity_count2++;
                }
            }
            ?>',
            description_point: '<?php
            $out = esc_html(get_the_excerpt());
            $out = iconv_substr($out, 0, 120, 'utf-8'); // $out = "324";
            $out = str_replace("\n", ' ',$out);
            if (strlen(get_the_title()) < 17)
                echo '<p>' . esc_attr($out) . '</p>';
            ?>',
            url_point: '<?php
            echo esc_url(get_permalink());
            ?>',
            moreinfo: '<?php esc_html_e("More info", "mycity"); ?>'
            }
            <?php
            $points[] = ob_get_clean();
        }
    else:
    endif;
    ob_start();
    echo implode(",", $points);
    wp_reset_postdata();
    return ob_get_clean();
}

?>