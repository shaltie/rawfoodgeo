<?php
$showas = (isset($_GET['showas'])) ? sanitize_text_field($_GET['showas']) : "";


if( get_theme_mod('site_Identity_modern','s2') == 's2'){
   get_template_part('partials/loop','masonry');
    } else {


global $mycity_is_index;

$mycity_cat = 0;
$category = @array_pop(get_the_category());

if(isset($category->cat_ID)) {
    $mycity_cat = @get_cat_ID($category->cat_name);

    if ($mycity_is_index) { // is the index page cat = 0
    $mycity_cat = 0;
    }

$category = get_category( get_query_var( 'cat' ) );
if (isset($category)) { $mycity_cat = $category->cat_ID; } else {$mycity_cat = 0;}

}




$posts_per_page = (int)esc_html(get_option('posts_per_page'));
$cats_arr = array();
if (!empty($GLOBALS['mycity_wp_infinitepaginate'])) {
    $cats_arr = $GLOBALS['mycity_wp_infinitepaginate'];
} else {
    $cats_arr = array(
        'paged' => 1,
        'offset' => 0,
        'showposts' => $posts_per_page,
        'cat' => esc_html($cat));
}
$custom_query = new WP_Query($cats_arr);
$i = 0;
$class = "";
$color = get_theme_mod("colors_m_DD3333", "DD3333"); //red to rgb
$mycity_int = hexdec($color);
$mycity_red_rgba = array(
    0 => 0xFF & ($mycity_int >> 0x10),
    1 => 0xFF & ($mycity_int >> 0x8),
    2 => 0xFF & $mycity_int);

if ($custom_query->have_posts()):
    while ($custom_query->have_posts()):
        $custom_query->the_post();
        $thumbnail = get_the_post_thumbnail(get_the_id(), 'mycity_panorama');
        preg_match_all('#src="(.*?)"#si', $thumbnail, $thumb_url);
        $thumb = get_template_directory_uri()."/img/blurbg.jpg";
        $opacity = "0.3";
        if (isset($thumb_url[1][0]))
            $thumb = $thumb_url[1][0];
        if (strlen($thumb) < 4) $opacity = 1;

        if ($i % 2 ) {

            $class = "red_background";
            $bg_style = "background: rgba(" . $mycity_red_rgba[0] . "," . $mycity_red_rgba[1] .
                "," . $mycity_red_rgba[2] . ",$opacity);";
        } else {
            $class = "black_background";
            $bg_style = "background: rgba(0,0,0,$opacity);";
        }



?>
<div class="se-slope">
    <div class="bright_slope <?php  echo sanitize_html_class($class); ?>"  data-style='<?php echo esc_attr($bg_style); ?>'>
		<img src="<?php echo esc_html($thumb); ?>" alt="" class="comments_img" rel="<?php echo get_the_ID(); ?>">
	</div>
    <article class="se-content">
        <div class="cb">
            <div class="comments_date fadeIn wow" rel=<?php echo get_the_ID(); ?> data-wow-duration="1s" data-wow-delay="0.5s" data-wow-offset="10">
                <div class="p_footer">
                    <ul>
                    <?php
                    $date = get_the_date('F');
                    if( !empty($date) ){ ?>
						<li>

                            <a href="#">
                                <p class="mounth pull-left"><?php echo get_the_date('F'); ?></p>
                                <p class="date pull-right"><?php echo get_the_date('d'); ?></p>
                            </a>
                        <?php } ?>
                        </li>
                        <div class="clear"></div>
                        <?php
                            $arr_tags = array();
                            $posttags = get_the_tags();
                            $i2 = 0;
                            if ($posttags)
							{ ?>
								<li class="tag_li">
									<i class="fa fa-tags"></i>
									<?php
										foreach ($posttags as $tag) {
											if ($i2 < 5) {
										?>
										<a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"><?php echo
											esc_attr($tag->name); ?></a>
										<?php
											if ($i2 < 1) {
												echo " , ";
											}
											} else {
												$arr_tags[] = '<a href="' . esc_url(get_tag_link($tag->term_id)) . '">' .esc_attr($tag->name) . '</a> , ';
											}
												$i2++;
											}
											if(  count($arr_tags) > 0) { ?>
											<a class="more_tags">...</a>
											<div class="more_tags_li">
												<?php
													$allowed_html = array('a' => array('href' => array(), 'title' => array()));
													$count = 0;
													foreach ($arr_tags as $tag) {
														echo wp_kses($tag, $allowed_html);
														if (count($arr_tags == $count + 1)) {
															echo wp_kses(str_replace(",", '', $tag), $allowed_html);
														}
														$count++;
													}

													?>
											</div>
											<?php
											}
											?>
								</li>
							<?php
                            }
                            ?>
                        <?php if(get_comments_number() > 0): ?>
                        <li><i class="fa fa-comments"></i> <?php comments_number();
                            ?>
                        </li>
                        <?php endif; ?>
                        <li> <i class="fa fa-globe"></i>
                            <?php	$views = (int)esc_attr(get_option("views_".$post->ID));
									echo esc_attr($views++);
                                    echo esc_html_e(' views', 'mycity');
                             ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="comments_content">
                <div class="post p_style_two noimage">
                    <div class="post_info">
                        <h2><a href="<?php echo esc_url(get_the_permalink()); ?>" data-url="<?php echo esc_url(get_the_permalink()); ?>" rel="<?php echo get_the_ID(); ?>" class="h_post"><?php if (is_sticky()) {
                            ?><i class='fa fa-exclamation'></i><?php } ?> <?php the_title(); ?></a><span></span></h2>
                        <div class="p_text">
                            <?php

                                $short_desc = get_post_meta( $post->ID, 'mycity_short_description' , true ) ;
                                if(strlen(trim($short_desc)) > 2) {
                                    echo wp_kses_post($short_desc);
                                }else {
                                    $text = esc_html(get_the_excerpt());
                                    $text = str_replace(array('&lt;','&gt;'),array('<','>'),$text);
                                    $text = strip_tags($text);
                                     $button = '<div class="clerfix"></div>
                                	<a href="'.esc_url(get_the_permalink()).'" class=" btn  btn-continue">'.esc_html__('Continue reading','mycity').'<i class="fa fa-angle-right"></i></a>';
                                    $text = preg_replace('/\[.*?\]/', $button, $text);
                                    echo wp_kses_post($text);
                                }


                                ?>
                        </div>
                    </div>
                    <a href="#" class="visible-xs pull-left com_a"><i class="fa fa-comments"></i></a>
                    <a href="#" class="visible-xs pull-left com_a"><i class="fa fa-calendar"></i><?php the_date(); ?></a>
                </div>
            </div>
        </div>
    </article>
</div>
<?php
    $i++;
    endwhile;
    else:
    ?>


<?php
    endif;
    wp_reset_postdata();
}
    ?>