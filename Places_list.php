<?php
/**
 * Template Name: Places_list.php (Places list)
 */
global $mycity_dditional, $MyCity_class;
$mycity_dditional = " Places_list";
?>
<?php
get_header();
get_sidebar();
?>

    <div class="filter"><i class="fa fa-filter"></i></div>
    <div id="container">
        <!--header-->

        <div class="<?php echo sanitize_html_class($MyCity_class->mycity_container_class()); ?> page_info place_info">
            <div class="start_descr">
                <div class="col_md_12">
                    <h1 class='edited' id='edited_Placeslisr'><?php esc_html_e('Places list', 'mycity'); ?></h1>

                    <p class='lead edited' id='edited_PlaceslisgridDes2'><?php echo esc_html(_e("You can use all Bootstrap plugins purely through the
                        markup API without writing a single line of JavaScript. This is Bootstrap's first-class API and
                        should be your first consideration when using a plugin.","mycity"));?></p>
                </div>
            </div>
        </div>
        <div class="<?php echo sanitize_html_class($MyCity_class->mycity_container_class()); ?> contant grid_cont">
            <div class="row">
                <!-- Left column-->
                <div class="col-md-3">
                    <div class="sidebar">
                        <?php
                        get_template_part("partials/myAffix");
                        ?>
                    </div>
                </div>
                <!--content-->
                <div class="col-md-9 basic">
                    <?php
                    global $MyCity;


                    $mycity_args = array('post_type' => 'places','post_status'=>'publish',
                        'showposts' => sanitize_text_field(get_option('posts_per_page')),
                        'post__not_in' => $MyCity_class->get_empty_places(),
                        'paged' => 1

                        );



                    if (isset($_GET['tags'])) {
                        $mycity_args['meta_query'] = array(array(
                            'key' => '_tags',
                            'value' => sanitize_text_field($_GET['tags']),
                            'compare' => 'LIKE'));
                    }


                    if (isset($wp_query->query_vars['term']) && !isset($_GET['tags'])) {
                        $mycity_args['tax_query'] = array(array(
                            'taxonomy' => 'places_categories',
                            'terms' => sanitize_text_field($wp_query->query_vars['term']),
                            'field' => 'slug'));
                    }
                    if ( isset($_GET['search']) &&  !empty($_GET['search']) ) {
                     $mycity_args['s'] = sanitize_text_field($_GET['search']);
                    }


                    global $mycity_query_my2;

                    $mycity_query_my2 = new WP_Query($mycity_args);


                    if ($_GET['showas'] == 'list') {
                        ?>

                        <div class="place_li_cont">

                            <?php get_template_part('partials/loop', 'placelist');
                            wp_reset_postdata(); ?>

                        </div>

                        <!--morebtn-->

              <?php


                    } else { ?>
                        <div class="place_gr_cont">
                            <?php
                            if (have_posts()) {
                                the_post();
                                ?>
                                <!--place style one-->
                                <div class="pg style_one"
                                     onclick="location.href='<?php echo esc_url(get_the_permalink()); ?>';">
                                    <div class="p_cont">
                                        <h2><?php the_title(); ?><span></span></h2>
                                        <span><?php the_excerpt(); ?></span>
                                    </div>
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/pl3.jpg" alt="">

                                    <div class="dar_bg_frid"></div>
                                </div>
                      <?php } ?>

                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>


    <script>



        /*----------------------Ajax  in categories-----------------------*/
        jQuery(document).ready(function ($) {

         winHeight = $(window).height() + 650;

            setTimeout(function(){
              $('#hero-bg').css({
                 minHeight: winHeight
              });
            },300)


            var total =  <?php echo esc_html($wp_query->max_num_pages);?>;
            var ajax = true;
            var count = 2;
            $(window).scroll(function () {
                var scrollTop = jQuery(window).scrollTop();
                var height = 0;

                jQuery(".basic .style_list").each(function () {
                    height +=$(this).height();
                });
                var ajaxheight = height - (jQuery(window).height()  - 300);


                if( parseInt(jQuery(window).height()/ 4.5)   < parseInt(jQuery(window).scrollTop()) ){
                 $('#hero-bg').addClass("fixid_notr");

               } else {
                $('#hero-bg').removeClass("fixid_notr");
               }

              if ((scrollTop ) > ajaxheight && ajax) {

                jQuery(this).addClass('active2');
                if (ajax) {

                    if (count > total + count) {
                        return false;
                    } else {
                        if ($("div").is(".no_posts_1")) return;
                        //$('.places_list_my').length
                        loadArticle(count);
                        count++;
                    }
                    ajax = false;
                }
                return false;
                }
            });



            function loadArticle(pageNumber) {

                var s = "<?php echo  ( isset($_GET['search']) &&  !empty($_GET['search'])) ? esc_html($_GET['search']) : ""; ?>";
                var terms = "<?php if(isset($wp_query->query_vars['term']))  echo esc_html($wp_query->query_vars['term']); ?>";
                var tag = "<?php if(isset($_GET['tags'])  )echo esc_html($_GET['tags']) ;?>";
                $.ajax({
                    url: "<?php echo esc_url(site_url()); ?>/wp-admin/admin-ajax.php",
                    type: 'POST',
                    <?php
        if (isset($_GET['tags'])) {
        ?>
                    data: "action=mycity_wp_places_list&page_no=" + pageNumber + "&tag=" + tag+"&s="+s,
                    <?php
        } else { ?>
                    data: "action=mycity_wp_places_list&page_no=" + pageNumber + "&terms=" + terms+"&s="+s,
                    <?php }
        ?>

                    success: function (html) {

                        $(".place_li_cont").append(html); // This will be the div where our content will be loaded
                        $('.more_btn2').removeClass('active2');
                        ajax = true;
                        if ($(window).width() < 992) {
                            $(".comments_img").each(function (i) {
                                var comImg = $(this).parent().height();
                                $(this).height(comImg);

                            });
                        }
                    }
                });
                return false;
            }
        });
    </script>
    <script>
        function initialize_map() {
        }

    </script>
       <script>
        jQuery('.place_info').css({
            height: jQuery(window).height() + 'px'
        });

    </script>
    <style>
        .body_opacity {
            background: none !important;
        }
    </style>
    <?php
get_footer();

?>