<!--som_mob -->
<div class="similar">
    <h3><?php echo esc_html__("Similar places", "mycity") ?>:</h3>
    <?php

    /*
    *Similar places
    */
    global $mycity_post_terms;
    $mycity_args = array(
        'post_type' => array(
            'places'
        ),
        'tax_query' => array(array(
            'taxonomy' => 'places_categories',
            'terms' =>  sanitize_text_field($mycity_post_terms[0]->term_id),
            'field' => 'id')
        )
    );
    $MyCity_psmb_query = new WP_Query($mycity_args);
    if ($MyCity_psmb_query->have_posts()): while ($MyCity_psmb_query->have_posts()):
    $MyCity_psmb_query->the_post();
    ?>
    <div>
        <?php
        if (has_post_thumbnail()) {
            $mycity_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
            ?><img src="<?php echo esc_url($mycity_thumb[0]); ?>" alt="#"><?php
        }
        ?>
        <a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a>
        <i class="icon-heart"></i><?php echo mycity_get_followers_count("-" . get_the_ID()); ?>   <?php esc_html_e('likes', 'mycity'); ?>
    </div>
</div>

<?php wp_reset_postdata(); ?>