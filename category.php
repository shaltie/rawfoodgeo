<?php
/**
 * Template Name: template-category
 * Preview:
 */
 

global $mycity_dditional,$MyCity_class,$post,$mycity_is_index;
$showas = (isset($_GET['showas'])) ? sanitize_text_field($_GET['showas']) : "";
$GLOBALS['mycity_showas'] = $showas;
$mycity_dditional = " Category_page";
$mycity_cat = 0;
$mycity_category = get_category( get_query_var( 'cat' ) );
if(isset($mycity_category->cat_ID)) {
  $mycity_cat = $mycity_category->cat_ID;  
} else {
    $mycity_cat = 0;
}
$mycity_template = 'Places_map';
if (isset($_GET['showas']) && sanitize_text_field($_GET['showas']) == 'list')
    $mycity_template = 'Places_list';
if (isset($_GET['showas']) &&  sanitize_text_field($_GET['showas']) == 'grid')
    $mycity_template = 'Places_grid';
if ($post->post_type == 'places') {
    get_template_part($mycity_template);
} else {
 if( get_theme_mod('site_Identity_modern','s2') == 's2' || $showas == 'masonry' )
    {
        $mycity_dditional .= " masonry_news";
    }  else {
        $mycity_dditional = " Category_page";
    }                                   
global $post;
global $wp_query;
 //blogfeed
if ($mycity_is_index) { // is the index page cat = 0
     $mycity_cat = 0;
}
$mycity_paged= 0;
$mycity_paged = (int)esc_html(get_option('posts_per_page'));
                        /*-----------------------------------------------*/  
    get_header();
    ?>
    <?php
    get_sidebar();
    ?>
    <!--navigation swipe-->
    <div class="site-overlay"></div>
    <div id="container">
        <div class="container page_info ">
            <div class="col-md-12 blog_category">
                 <?php 
                 if(get_theme_mod('site_Identity_single_post_typed_news_2',false) != false){
                 $mycity_new_arr = array('paged' => 1, 'showposts' => 1,   'cat' => $mycity_cat ) ;  
                    $mycity_custom_query = new WP_Query($mycity_new_arr);
                    if ($mycity_custom_query->have_posts()):
                        while ($mycity_custom_query->have_posts()):
                        $mycity_custom_query->the_post();
                        ?>
                         <h1>
                         <?php the_title(); ?>
                         </h1>  
                         <p class="lead">
                         <?php   
                             $mycity_text = esc_html(get_the_excerpt());
                                $mycity_text = str_replace(array('&lt;','&gt;'),array('<','>'),$mycity_text);
                                $mycity_text = strip_tags($mycity_text);
                                echo wp_kses_post($mycity_text);
                                  ?>
                         </p>             <a href="<?php echo esc_url(get_the_permalink()); ?>" class=" btn  btn-continue"><?php esc_html_e('Continue reading','mycity'); ?><i class="fa fa-angle-right"></i></a> 
                                 <?php
                        endwhile;
                    endif;    
                     
                 ?>
                 <?php
	              } else {         
                 ?>
                <h1><?php   
                if(is_home()){
                    echo esc_attr(get_bloginfo('name'));
                 
                    
                } else {
                    single_cat_title();
                }
                 ?></h1>  
                <p class="lead">
                    <?php 
                      if(is_home())
                             bloginfo('description');
                    if(isset($mycity_category->description)) 
                      echo esc_html($mycity_category->description); ?>
                    
                </p>
                <?php
                }
                ?>
                
                  
                <?php
                $mycity_defaults = array(
                    'theme_location' => 'posts_category_menu',
                    'menu' => '',
                    'container' => 'div',
                    'container_class' => '',
                    'container_id' => '',
                    'menu_class' => 'navigate head_nav',
                    'menu_id' => '',
                    'echo' => true,
                    'fallback_cb' => 'wp_page_menu',
                    'before' => '',
                    'after' => '',
                    'link_before' => '',
                    'link_after' => '',
                    'items_wrap' => '<ul id="%1$s" class="blog_cat">%3$s</ul>',
                    'depth' => 0,
                    'walker' => new mycity_top_menu_walker());

                if (has_nav_menu('posts_category_menu')) {
                    wp_nav_menu($mycity_defaults);

                 } else{               
                ?>
                <?php  
                
                              
                 if(get_theme_mod('site_Identity_single_hide_cat',false) == false){?>
                <ul class="blog_cat">
                <?php 
                $mycity_cat_list = @wp_list_categories('orderby=name&title_li=&echo=0');
                $mycity_cat_arr = @explode('</li>',$mycity_cat_list);               
                if( @count($mycity_cat_arr)  <= 2  ) {
                        ?>
                         <li><a>
                       </a>
                        </li>
                        <?php
                } else {?>
                    <li>
                    </li>
                    <?php
                    echo @wp_kses($MyCity_class->icon_converter($mycity_cat_list), array(
                        'a' => array('href' => array(), 'title' => array()),
                        'i' => array('class' => array()),
                        'ul' => array('class' => array()),
                        'li' => array('class' => array())));
                } ?>
                </ul>
                
                
                <?php
                } }
                ?>
            </div>
        </div>
        <div class="<?php echo sanitize_html_class($MyCity_class->mycity_container_class()); ?>  grid_cont">
            <div class="row cont">
                <div class="col-md-12 basic basic_t">
                    <div class="place_li_cont">
                        <?php
                        ?>
                        <section class="se-container">
                            <?php
							
                            if (isset($wp_query->query["pagename"])) {
                                if ($wp_query->query["pagename"] == 'blogfeed') {
                                    $GLOBALS['mycity_wp_infinitepaginate'] = array('paged' => 1, 'showposts' => $mycity_paged);                             
                                } 
								 
                            } else {
                                // this is cat
                                $mycity_post_type = "";
                                if (isset($wp_query->query['post_type'])) {
                                    $mycity_post_type = esc_attr($wp_query->query['post_type']);
                                }
								                            

							}
							if( get_theme_mod('site_Identity_modern','s2') == 's2'  || $showas == 'masonry')
                              {
                                ?>
                                    <div id="container_1" class="transitions-enabled clearfix">
                                        <?php get_template_part('partials/loop','masonry'); ?>
                                    </div>   
                                <?php
                              }  else {
                                     get_template_part('partials/loop');
                              } 	
                            wp_reset_postdata();
                            ?>                        
                        </section>
                    </div>
                    <!--morebtn-->
                    <div  class="dn_non">
                        <?php posts_nav_link('  ', '', ''); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div id='ad_ajax'>
    <?php get_template_part("partials/category", "post_content"); ?>
	</div>
<script>
var res = jQuery('#hero-bg').attr('data-img');    
    var pic = new Image();   
    pic.src = res ; 
     jQuery('#hero-bg').css('background-image', 'url(' + res + ')');                
    jQuery('#hero-bg').fadeIn(0);
jQuery('.Category_page .page_info').css({
    height : jQuery(window).height() + 'px'
 });
jQuery(document).ready(function ($) {
    $(window).resize(function(){
        jQuery('.Category_page .page_info').css({
          height : jQuery(window).height() + 'px'
        });
    });
	$(".Category_page.wide .page_info").css("visibility","visible");
    var catHeight = $('.blog_category').height();
        $('.blog_category').css({
            'margin-top': ((catHeight/2)*(-1)) + 'px'
    })
});
function bright_slope(){
     jQuery(".bright_slope ").each(function (i) {
     	jQuery(this).attr("style",jQuery(this).data("style") );
     });
}
        jQuery(document).ready(function ($) { //addClass to categoty naw
        bright_slope();
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
            $(window).scroll(function () {
            var scrollTop = jQuery(window).scrollTop();
            var ajaxheight = jQuery(".place_li_cont").height() - jQuery(window).height();
               
               if ((scrollTop + 700) > ajaxheight && ajax) {             
                jQuery(this).addClass('active2');
                if (ajax) {
                    if (count > total + count) {
                        return false;
                    } else {
                        if ($("div").is(".no_posts_1")) return;
                        loadArticle(count);                      
                        count++;
                        bright_slope();
                        setTimeout(function(){
                            bright_slope();
                        },1000);
                    }
                    ajax = false;
                }
                return false;
                }
            });
            function loadArticle(pageNumber) {
                
                var ofset = $(".place_li_cont .post").length;
                var posttype = "<?php
                if (isset($wp_query->query['post_type']))
                echo esc_attr( sanitize_text_field ($wp_query->query['post_type']));
                ?>";
                var cat = "<?php
                if ($mycity_is_index) { // is the index page cat = 0
                echo 0;
                } else {
                 if (get_the_category()) {
                  echo esc_html($mycity_cat);
                   }
                } ?>";
                var is_sticky = "";
                $('.more_btn2').attr('disabled', true);
                $.ajax({
                    url: "<?php echo esc_url(site_url()); ?>/wp-admin/admin-ajax.php",
                    type: 'POST',
                    <?php
                    if(get_theme_mod('site_Identity_modern','s2') == 's2' || $showas == 'masonry' ) { ?>
                    data: "action=infinite_scroll&page_no=" + pageNumber + "&ofset=" + ofset + "&cat=" + cat + "&is_sticky=" + is_sticky + "&posttype=" + posttype+"&masonry=true",
                   <?php } else {
                    ?>
                        data: "action=infinite_scroll&page_no=" + pageNumber + "&ofset=" + ofset + "&cat=" + cat + "&is_sticky=" + is_sticky + "&posttype=" + posttype,
                    <?php                    
                   }
                   ?>
                    success: function (html) {
                        <?php 
                        if( get_theme_mod('site_Identity_modern','s2') == 's2' || $showas == 'masonry'){                                 
                        ?>
                        var $moreBlocks = jQuery(html).filter('div.box');
                        $(".place_li_cont #container_1").append($moreBlocks); // This will be the div where our content will be loaded
                        $(".place_li_cont #container_1").masonry( 'appended', $moreBlocks );   
                        <?php
                        } else {
                        ?>
                        
                     
                            $(".place_li_cont .se-container").append(html); // This will be the div where our content will be loaded
                        <?php
                        }                        
                        ?>                
                        $('.more_btn2').attr('disabled', false);
                        $('.more_btn2').removeClass('active2');
                        ajax = true;
                    }
                });
                return false;
            }
        });
 	function initialize_map() {
        }
 jQuery('#hero-bg').css({
    height : jQuery(window).height() * 1.5 + 'px'
 });
    </script>
 <?php  get_footer();  } ?>