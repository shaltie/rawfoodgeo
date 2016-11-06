<!--Similar Place-->
<?php 
 global $mycity_post_terms; //object of terms
?>
<div class="similar">
    <h3 class='edited' id='edited_Similarplaces20'>
        <?php esc_html_e('Similar places:', 'mycity'); ?>
    </h3>
    <?php   
    $mycity_args = array(
        'post_type' => array(
            'places'
        ),
        'tax_query' => array(array(
            'taxonomy' => 'places_categories',
            'terms' =>  sanitize_text_field ($mycity_post_terms[0]->term_id),
            'field' => 'id')
        )
    );
    /**
     * new WP_Query
     */
    $MyCity_ps_query = new WP_Query($mycity_args);
    if ($MyCity_ps_query->have_posts()):
		while ($MyCity_ps_query->have_posts()):
			$MyCity_ps_query->the_post();
	?>
		<div>
			<?php
			$mycity_img = get_template_directory_uri() . "/img/img.png";
			$mycity_small_img = wp_get_attachment_url(get_post_meta(get_the_ID(), '_small_img', true));
			$mycity_small_img = bfi_thumb($mycity_small_img, array('width' => 45, 'height' => 45));
			if (isset($mycity_small_img)) {
			?>
				<img property="schema:image" src="<?php echo esc_url($mycity_small_img); ?>" alt="<?php the_title(); ?>"/>
			
			<?php
			} ?>
			<a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a>
			<i class="fa fa-thumbs-o-up"></i>
			<?php echo esc_html(mycity_get_followers_count("-" . get_the_ID()));
			echo esc_html__(" followers ", "mycity")
			?>
		</div>
    <?php
		endwhile;
    else: 
	endif;
    wp_reset_postdata(); ?>
</div>