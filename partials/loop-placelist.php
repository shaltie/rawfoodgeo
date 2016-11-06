<?php
global $mycity_query_my2;

if ($mycity_query_my2->have_posts()) {
    // Start the loop.
    $cats_arr = array(); // count chald cats
    while ($mycity_query_my2->have_posts()) {
        $mycity_query_my2->the_post();

        //if not isset cordinats then exit
        $cordinats = get_post_meta(get_the_ID(), '_myfield', true);
        preg_match("/(.*?),(.*?)$/", $cordinats, $math);
        if (!isset($math[1]))
            $math[1] = 0;
        if (!isset($math[2]))
            $math[2] = 0;
        $location_latitude = $math[1];
        $location_longitude = $math[2];
        if (!$location_latitude) {
            continue;
        }
        //get images
        $img = esc_url(get_template_directory_uri()) . "/img/pl3.jpg";
        $small_img = wp_get_attachment_url(get_post_meta(get_the_ID(), '_big_img', true));
        $img = bfi_thumb($small_img, array('width' => 200, 'height' => 200, 'crop' => true));
		
        $except = get_the_excerpt();

        if (get_post_meta(get_the_ID(), 'smalldescr', true)) $except = get_post_meta(get_the_ID(), 'smalldescr', true);


        // object terms
        $obj_term = wp_get_post_terms(get_the_ID(), 'places_categories');
        $slug_this_cat = $obj_term[0]->slug;
        //cunt post in cats
        if (!isset($cats_arr[$slug_this_cat]) && empty($cats_arr[$slug_this_cat]))
            $cats_arr[$slug_this_cat] = 0;


        ?>
        <div
            data-marker="<?php echo esc_attr($slug_this_cat); ?>[<?php echo esc_attr($cats_arr[$slug_this_cat]); ?>]"
            class="pg style_list places_list_my">

            <div class="con clearfix">
                <a href="<?php  the_permalink(); ?>">
                <img class="wh200" src="<?php echo esc_html($img); ?>"  alt="">
                </a>
                <div class="content_li">
                    <h2>
                        <a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a>
                        <span></span>
                    </h2>
                    <span><?php echo esc_html(str_replace(array('<p>', '</p>'), array('', ''), $except)); ?></span>
                    <a href="<?php echo esc_url(get_the_permalink()); ?>" class="comm">
                        <i class="fa fa-comment-o"></i>
                        <?php
                        echo mycity_ttshowcase_coments_count(get_the_ID()) . " ";
                        esc_html_e('Comments', 'mycity');
                        ?>
                    </a>
                </div>
            </div>
        </div>
        <?php

        if (isset($cats_arr[ $slug_this_cat])) {
            $cats_arr[$slug_this_cat]++;
        }
        // End the loop.
    }
} else { ?>

    <?php
    unset($mycity_query_my2);
} ?>