<!--Mobile visibli-->
<div class="mobile_place">
    <div class="address">
        
    </div>
    <div class="similar">
        <h3 class='edited' id='edited_Similarplaces'>
            <?php esc_html_e('Similar places:', 'mycity'); ?>

        </h3>
        <?php
        $mycity_post_terms = wp_get_object_terms($post->ID, "places_categories");

        $mycity_termid = (int)$mycity_post_terms[0]->term_id;
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
        $MyCity_pmv_query = new WP_Query($mycity_args);

        if ($MyCity_pmv_query->have_posts()): 
			while ($MyCity_pmv_query->have_posts()): 
				$MyCity_pmv_query->the_post(); 
		?>
            <div>
                <?php
                if (has_post_thumbnail()) {
                    $mycity_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
                    ?>
                    <img src="<?php echo esc_url($mycity_thumb[0]); ?>" alt="<?php the_title(); ?>"/>
                    <?php
                } ?>
                <a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a>
                <i class="fa fa-thumbs-o-up"></i><?php
                echo esc_attr(mycity_get_followers_count("-" . get_the_ID()));
                ?> <?php echo esc_html__("followers", "mycity") ?>
            </div>

        <?php endwhile;
        else:
		endif;
        wp_reset_postdata(); ?>
    </div>
</div>