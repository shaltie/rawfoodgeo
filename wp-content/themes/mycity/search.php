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

        <div class=" searh_header <?php echo sanitize_html_class($MyCity_class->mycity_container_class()); ?> page_info place_info">
            <div class="start_descr">
                <div class="col_md_12">
                    <h1 class='edited' id='edited_Placeslisr2'><?php printf(esc_html(__('Search Results for: %s', 'mycity')), get_search_query()); ?></h1>

                    <p class='lead  edited '  id='edited_PlaceslisgridDes22'>
                        
                    </p>
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
                    global $MyCity; ?>


                        <div class="place_li_cont">

                            <?php if (have_posts()) : ?>
                            
                                <!-- .page-header -->
                                <?php
                                // Start the Loop.
                                while (have_posts()) : the_post();
                                    $img = esc_url(get_template_directory_uri()) . "/img/pl3.jpg";
                                    $small_img = wp_get_attachment_url(get_post_meta(get_the_ID(), '_big_img', true));
                                    $img = bfi_thumb($small_img, array('width' => 200, 'height' => 200, 'crop' => true));

                                    $except = get_the_excerpt();
                                    $thumbnail = get_the_post_thumbnail(get_the_ID(), 'full');
                                    preg_match_all('#src="(.*?)"#si', $thumbnail, $thumb_url);


                                    if (isset($thumb_url[1][0])) {
                                        $img = bfi_thumb($thumb_url[1][0], array('width' => 200, 'height' => 200, 'crop' => true));

                                    }


                                    ?>
                                    <div
                                        class="pg style_list places_list_my">

                                        <div class="con clearfix">
                                            <img class="wh200" src="<?php echo esc_html($img); ?>"  alt="">
                                            <div class="content_li">
                                                <h2>
                                                    <a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a>
                                                    <span></span>
                                                </h2>
                                                <span><?php echo esc_html(str_replace(array('<p>', '</p>'), array('', ''), $except)); ?></span>

                                            </div>
                                        </div>
                                    </div>

                          <?php
                                endwhile;
                            else :

                                ?>
                                <div class="page-header ph_mw800">
                                    <h1 class="page-title"> <?php esc_html_e('Nothing Found', 'mycity'); ?> </h1>
                                </div>
                                <!-- .page-header -->
                                <?php
                            endif;
                            ?>

                        </div>

                        <!--morebtn-->



                </div>
            </div>
        </div>
    </div>


    <script>



        /*----------------------Ajax  in categories-----------------------*/
        jQuery(document).ready(function ($) {

            winHeight = $(window).height() + 650;


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

                if ((scrollTop  + 600) > ajaxheight && ajax) {

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
                $.ajax({
                    url: "<?php echo esc_url(site_url()); ?>/wp-admin/admin-ajax.php",
                    type: 'POST',          
                    data: "action=mycity_wp_s&page_no=" + pageNumber ,    

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
    /*    jQuery('.place_info').css({
            height: jQuery(window).height() + 'px'
        });
*/
    </script>
    <style>
        .body_opacity {
            background: none !important;
        }
    </style>
<?php
get_footer();

?>