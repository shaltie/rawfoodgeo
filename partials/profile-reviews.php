<!--reviews-->
<div class="reviews">
    <?php
    global $mycity_profile;
    $mycity_the_query = new WP_Query(array('author__in' => (int)$mycity_profile->ID, 'post_type' => 'ttshowcase'));
    // The Loop
    if ($mycity_the_query->have_posts()) {
        while ($mycity_the_query->have_posts()) {
            $mycity_the_query->the_post();
            $mycity_meta = get_post_meta(get_the_id());
            ?>
            <div class="rev">
                <div class="user">
                    <a href="/members/<?php echo esc_attr($mycity_profile->ID); ?>" class="user_avatars">
                        <div class="user_go">
                            <i class="fa fa-link"></i>
                        </div>
   
                        
                            <?php
							$mycity_params = array('width' =>46, 'height' => 46, 'crop' => true );
							$mycity_img_url=  bfi_thumb(mycity_get_url_by_avatar(get_avatar($mycity_profile->ID,66)), $mycity_params);
						  ?>
                          
						   <img src="<?php echo esc_url($mycity_img_url); ?>"  alt="">
                    </a>
                </div>
                <div class="texts">
                    <div class="head_rev">
                 
                        <a href="<?php if (isset($mycity_meta['_insetr_post'][0]) && !empty($mycity_meta['_insetr_post'][0])) {
                               echo @esc_url(@get_the_permalink($mycity_meta['_insetr_post'][0])); 
                        }
                      ?>"><?php 
                      if (isset($mycity_meta['_insetr_post'][0]) && !empty($mycity_meta['_insetr_post'][0])) 
                      echo esc_url(get_the_title($mycity_meta['_insetr_post'][0])); ?></a>
                        <span><?php echo get_the_date(); ?></span></div>
                    <div
                        class="text_rev"><?php print_R(esc_html($mycity_meta['_aditional_info_short_testimonial'][0])); ?></div>
                </div>
            </div>
            <?php
        }
    } else {
        $mycity_comments = 0;
    }
    wp_reset_postdata();
    ?>
</div>
