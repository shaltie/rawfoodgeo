<?php
global $MyCity_class;
get_header();
get_sidebar();


?>  <!--navigation swipe-->
<code></code>
    <div class="site-overlay"></div>
    <div id="container">
        <div class="container page_info place_info">
            <div class="col-md-12 blog_category">
                 <h1><?php $MyCity_class->get_fa_icons($category[0]->cat_name); ?></h1>
                <p class="lead"><?php echo esc_html($category[0]->description); ?> </p>
                <!--Blog category-->
                <ul class="blog_cat">
                    <li>
                        <span class='edited' id='edited__span1_Blog_cat'><?php esc_html_e('Category:', 'mycity'); ?></span>
                    </li>
                   <?php
                    echo wp_kses($MyCity_class->icon_converter(wp_list_categories('orderby=name&title_li=&echo=0')), array(
                        'a' => array('href' => array(), 'title' => array()),
                        'i' => array('class' => array()),
                        'ul' => array('class' => array()),
                        'li' => array('class' => array())));
                    ?>
                </ul>
            </div>
        </div>
        <div class="<?php echo  sanitize_html_class(mycity_container_class()); ?>  grid_cont">
            <div class="row cont">
                <div class="col-md-12 basic basic_t">
                    <div class="place_li_cont">
                        <?php
                        global $post;
                        global $wp_query;
                        if ($mycity_is_index) {
                            $mycity_cat = 0;
                        }
                        $mycity_paged = 0;
                        $mycity_posts_per_page = (int)esc_html(get_option('posts_per_page'));
                        ?>
                        <section class="se-container">
                            <?php
                            if (isset($wp_query->query["pagename"])) {
                                if ($wp_query->query["pagename"] == 'blogfeed') {
                                    $GLOBALS['mycity_wp_infinitepaginate'] = array('paged' => 1, 'showposts' => $mycity_posts_per_page);
                                    get_template_part('partials/loop');
                                } else {
                                    get_template_part('partials/loop');
                                }
                            } else {
                                // this is cat
                                $mycity_post_type = "";
                                if (isset($wp_query->query['post_type'])) {
                                    $mycity_post_type = esc_attr($wp_query->query['post_type']);
                                }
                                get_template_part('partials/loop');
                            }
                            wp_reset_postdata();
                            ?>
                        </section>
                    </div>
                   
                   
       			<?php
                $mycity_posts_per_page = (int)esc_html(get_option('posts_per_page'));                      

                     //if have post in onother pagt the show btn more
                if ( $MyCity_class->check_post_in_second_page(array(
                        'paged' => 2,
                        'offset' => 0,
                        'showposts' => $mycity_posts_per_page,
                        'cat' => sanitize_text_field($mycity_cat)))) {
                    ?>
                    <a href='#' class="more_btn2 btn btn-success ladda btn-follow ladda-button ladda-primary"
                       data-style="zoom-out"    id='yafollow' data-name='<?php esc_html_e('Load more', 'mycity'); ?>'> <?php esc_html_e('Load more',
                            'mycity'); ?>
                    </a>
            	<?php } ?>
                   
                    <div class="db_non">
                        <?php posts_nav_link('  ', '', ''); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
        jQuery(document).ready(function ($) { //addClass to categoty naw
            $('.categories li a').each(function () {
                var location = window.location.href;
                var link = this.href;
                if (location == link) {
                    $(this).addClass('active');
                }
            });
            $(".current-cat a").addClass('active');

        });
        /*----------------------Ajax  in categories-----------------------*/
        jQuery(document).ready(function ($) {
            var total =  <?php echo esc_html($wp_query->max_num_pages);?>;
            var ajax = true;
            var count = 2;
            $(document).on('click', '.more_btn2', function (e) {
                e.preventDefault();
                var mylada = Ladda.create(document.querySelector('.more_btn2'));
                mylada.start();
                $(this).addClass('active2');
                if (ajax) {
                    if (count > total + count) {
                        return false;
                    } else {
                        if ($("div").is(".no_posts_1")) return;
                        loadArticle(count);
                        mylada.stop();
                        count++;
                    }
                    ajax = false;
                }
                return false;

            });
            function loadArticle(pageNumber) {
                             

                var ofset = $(".place_li_cont .post").length;
                var posttype = "<?php if (isset($wp_query->query['post_type'])) echo esc_attr($wp_query->query['post_type']);?>";
                          var cat = "<?php
                if ($mycity_is_index) { // is the index page cat = 0
                echo 0;
                } else {
                 if (get_the_category()) {
                  echo esc_html($MyCity_class->ajax_get_the_category());
                   }
                } ?>";
                var is_sticky = "";
                $('.more_btn2').attr('disabled', true);
                $.ajax({
                    url: "<?php echo esc_url(site_url()); ?>/wp-admin/admin-ajax.php",
                    type: 'POST',
                    data: "action=infinite_scroll&page_no=" + pageNumber + "&ofset=" + ofset + "&cat=" + cat + "&is_sticky=" + is_sticky + "&posttype=" + posttype,
                    success: function (html) {
                        $(".place_li_cont .se-container").append(html); // This will be the div where our content will be loaded
                        $('.more_btn2').attr('disabled', false);
                        $('.more_btn2').removeClass('active2');
                        ajax = true;

                    }
                });
                return false;
            }

        });
    </script>
    <script>function initialize_map() {
        }</script>
    <script>new WOW().init();</script>
<?php get_footer();