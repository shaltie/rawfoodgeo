<?php
global $mycity_dditional, $post, $wp_query;

if(isset($wp_query->tax_query->queried_terms['advert_category']['terms'][0]{1})){
    get_template_part('single-advert');
    die();
}

$mycity_dditional = " Single_page";
if (isset($_GET['lightversion']) || get_theme_mod("site_Identity_layout",'s2') == 's2')
{

 get_template_part("single","wide");
}
else
{
    get_header();
    if (!isset($mycity_content_width))
        $mycity_content_width = 1100;

    $mycity_thumbnail = get_the_post_thumbnail( (int)get_the_id(), 'panorama');
    preg_match_all('#src="(.*?)"#si', $mycity_thumbnail, $mycity_thumb_url);
    $mycity_thumb = "";
    if (isset($mycity_thumb_url[1][0]))
        $mycity_thumb = esc_url($mycity_thumb_url[1][0]);

    ?>

    <?php get_sidebar(); ?>
    <div class="site-overlay"></div>
    <div id="container" >
        <div class="open post_info single_h1">
                        <h1><?php the_title(); ?><span></span></h1>
                        <p class="post_info_p"><?php echo esc_html(_e("Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel, aliquid!","mycity"));?></p>
        </div>
    <div class="item_wide_container">
        <div class="container shortcodes">
            <div class="row">
                <div class="col-md-12 basic">
                    <div class="place_li_cont">
                        <div class="post p_style_one open"  id="post-<?php (int)the_ID(); ?>" <?php post_class(); ?>>



                        <div class="post_content">
                        <?php
						if( have_posts()):
							while ( have_posts() ) :
                                the_post();
                                the_content();
                            endwhile;
				        endif;
						the_content();
                        $mycity_content = wpautop($post->post_content);
                        $mycity_content = apply_filters('the_content', $mycity_content);
                        ?>
                        <!--subscribe-->
                        <?php
                        if (get_theme_mod('single_post_single_post_control') == false)
                        { ?>


                            <div class="Subscribe">
                                <div class="div">
                                    <h2 class='edited' id='edited_Subscribe'><?php echo esc_html__("Subscribe now", "mycity"); ?></h2>
                                        <form id="subsribe" action="">
                                            <input class="subsribe_email" type="text" placeholder='email@email.com'>
                                            <button type="submit"   data-style="zoom-out"  class="btn btn-danger button substribe ladda-button ladda-primary"><?php echo esc_html__("Subscribe", "mycity"); ?></button>

                                        </form>
                                </div>
                            </div>
                        <?php
                        }
                        if (!is_page()) { ?>
                            <div class="p_footer">
                            <?php $mycity_author_id = $post->post_author; ?>
                             <ul>
                                <li> <i class="fa fa-globe"></i>
                                    <?php $mycity_views = (int)esc_attr(get_option("views_".$post->ID));
                                    echo esc_attr($mycity_views++);
                                    update_option( "views_".$post->ID, (int)$mycity_views );
                            ?>  </li>
                                <li><i class="fa fa-tags"></i> <?php the_category(); ?></li>
                                <li><i class="fa fa-calendar"></i> <?php the_date('m.d.Y'); ?></li>
                                <li> <?php
                                    if (strlen(esc_html(the_author_meta('description', $post->post_author))) < 1)
                                    {
                                     ?>
                                        <i class="fa fa-user"></i>
                                        <?php
                                        $mycity_user_info = get_userdata( (int)$post->post_author);

                                        echo esc_html($user_info->display_name);


                                    }?>
                                </li>
                              </ul>

                            </div>

    <?php
    }

    $mycity_args = array(
        'before' => '<p>' . esc_html__('Pages:', "mycity"),
        'after' => '</p>',
        'link_before' => '',
        'link_after' => '',
        'next_or_number' => 'number',
        'nextpagelink' => esc_html__('Next page', "mycity"),
        'previouspagelink' => esc_html__('Previous page', "mycity"),
        'pagelink' => '%',
        'echo' => 0);
    wp_link_pages($mycity_args);
    ?>
             </div>
                        </div>
                        <?php
                     if (strlen(esc_html(the_author_meta('description', $post->post_author))) > 0)
                     {
                    ?>
                    <!--author-->
                    <div class="author">
                        <?php echo get_avatar(sanitize_text_field($post->post_author)); ?>
                        <a href="<?php echo '/members/'. esc_url($post->post_author); ?>">
                        <?php echo esc_html(the_author_meta('user_nicename', $post->post_author)); ?></a>
                        <span>
                            <?php echo esc_html(the_author_meta('description', $post->post_author)); ?>
                        </span>
                    </div>
                        <div class="post_content">

                        <?php
                         }
                         comments_template();

                         ?>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>function initialize_map(){}</script>
<script>


jQuery('.post_info ').css({
    height :( jQuery(window).height()- jQuery('header').outerHeight(true)) + 'px'
 });

jQuery(document).ready(function ($) {

    var height = (jQuery(window).height() -  jQuery('header').outerHeight(true)) ;
        height = height - 200;
        jQuery('.post_info ').css({
          height : height + 'px'
        });



    $(window).resize(function(){
        var height = (jQuery(window).height() -  jQuery('header').outerHeight(true)) ;
        height = height - 200;
        jQuery('.post_info ').css({
          height : height + 'px'
        });

    });

});



</script>
<?php
    get_footer();
}
?>