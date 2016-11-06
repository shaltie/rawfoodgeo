<?php

/**
 * return open graph
 */
function mycity_fb_meta()
{
    $img = get_template_directory_uri() . "/img/img.png";
    $small_img = wp_get_attachment_url(get_post_meta(get_the_ID(), '_small_img', true));
    $small_img = bfi_thumb(sanitize_text_field($small_img), array('width' => 250, 'height' => 250));

    ?>
    <meta property="og:url" content="<?php echo esc_attr(mycity_request_url()); ?>"/>
    <meta property='og:image' content="<?php echo esc_url($small_img); ?>"/>
    <meta property='og:type' content="video.movie"/>
    <meta property='og:title' content="<?php the_title(); ?>"/>
    <meta property='og:site_name' content='mycity'/>
    <meta property="og:description" content="<?php
    if (have_posts())
	{
        the_post();
        echo esc_html(strip_tags(get_the_excerpt()));
    }
    if(is_home() or is_front_page()){
        echo wp_kses_post(get_bloginfo('‘description’'));
    }
    ?>"/> <?php
}

?>