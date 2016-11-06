<?php
/**
 * Template Name: Places_grid.php
 */
global $mycity_dditional, $MyCity_class, $mycity_noparalax;;
$mycity_dditional = " Places_grid";
get_header();
get_sidebar();
$mycity_points = array();
?>

<div class="site-overlay"></div>
<div id="container">
    <!--header-->
    <div class="<?php echo sanitize_html_class($MyCity_class->mycity_container_class()); ?> page_info place_info">
      
        <div class="col-md-12 blog_category">
            <h1 class='edited' id='edited_hgrind'><?php echo esc_html(_e("This title can be change by click","mycity")); ?></h1>
            <p class='lead edited' id='edited_gridlead'><?php echo esc_html(_e("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam","mycity"));?></p> 
             <ul class="blog_cat">
                    
                        <!--span class='edited' id='edited__span1_Blog_cat'>   <?php esc_html_e('Category:','mycity'); ?>
                        </span-->
                        
        <?php
        $mycity_categories  = get_categories("taxonomy=places_categories&hide_empty=0");
        foreach ($mycity_categories  as $place_cat) {
            ?>
            <li><a href="<?php echo esc_url(get_term_link($place_cat)); ?>?showas=grid" class="<?php echo sanitize_html_class($place_cat->slug); ?>"> <i class="fa <?php echo sanitize_html_class(get_option("fa_icon_" . (int)$place_cat->term_id)); ?>"></i>  <?php echo esc_html($place_cat->name); ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
   
           
                  
        </div>
    
    </div>
    <div class="<?php echo  sanitize_html_class($MyCity_class->mycity_container_class()); ?> grid_cont">
        <div class="item_wide_container ">                  
        <div class="container">
            <!-- Left column-->           
            <!--content-->
            <div class="col-md-12 basic">
                <div class="place_gr_cont">
                    <?php
                    $mycity_args = array(
                        'post_type' => 'places',
                        'showposts' => sanitize_text_field(get_option('posts_per_page')),
                        'post__not_in' => $MyCity_class->get_empty_places());
                    if (isset($_GET['tags']))
                    {
                        $mycity_args['meta_query'] = array(array(
                            'key' => '_tags',
                            'value' => sanitize_text_field($_GET['tags']),
                            'compare' => 'RLIKE'));
                    }
                    if (isset($wp_query->query_vars['term']) && !isset($_GET['tags']))
                    {
                        $mycity_args['tax_query'] = array(array(
                            'taxonomy' => 'places_categories',
                            'terms' =>sanitize_text_field($wp_query->query_vars['term']),
                            'field' => 'slug'));
                    }
                    
                    global $mycity_query_grid;
                    $mycity_query_grid = new WP_Query($mycity_args);
                    ?>
                    <!--content2-->
                    <?php get_template_part('partials/loop', 'placegrid');
                    wp_reset_postdata(); ?>
                </div>

            </div>
        </div>
        </div>
       
    </div>
</div>

<script>




    /*----------------------Ajax  in categories-----------------------*/
    jQuery(document).ready(function ($) {
        $('#hero-bg').hide();

        var arr_url = [];
        jQuery('.place_gr_cont .inline-center').each(function (e) {
                arr_url.push( jQuery(this).find('.places_list_my').attr('onclick'));
        });



        var total =  <?php echo esc_html($wp_query->max_num_pages);?>;
        var ajax = true;
        var count = 2;
        //add clas activ
        $(this).addClass('active2');
        //Ladda start        
        $(window).scroll(function () {
            var scrollTop = jQuery(window).scrollTop();
            var ajaxheight = jQuery(".place_gr_cont").height() - jQuery(window).height();
             
               if ((scrollTop  + 700) > ajaxheight && ajax) {

                jQuery(this).addClass('active2');
                if (ajax) {
                    
                    if (count > total + count) {
                        return false;
                    } else {
                        if ($("div").is(".no_posts_1")) return;
                        loadArticle(count);
                        count++;                        
                    }
                    ajax = false;
                }
                return false;
                }
       });           
            
        
     
        function loadArticle(pageNumber) {
            var terms = "<?php if (isset($wp_query->query_vars['term']))
                          echo esc_html($wp_query->query_vars['term']); ?>";
            var tag = "<?php if (isset($_GET['tags']))
                        echo esc_html($_GET['tags']); ?>";
            $.ajax({
                url: "<?php echo esc_url(site_url()); ?>/wp-admin/admin-ajax.php",
                type: 'POST',
                <?php
                if (isset($_GET['tags'])) {                    
                ?>
                data: "action=mycity_wp_places_grid&page_no=" + pageNumber + "&tag=" + tag,
                <?php
                } else { ?>
                data: "action=mycity_wp_places_grid&page_no=" + pageNumber + "&terms=" + terms,
                <?php }
                 ?>
                success: function (html) {
                    var $moreBlocks = jQuery(html).filter('div.inline-center');
                    $moreBlocks.each(function () {
                        var on_url = jQuery(this).find('.places_list_my').attr('onclick');

                        if (!in_array(on_url, arr_url)) {
                            arr_url.push( on_url);

                            $(".place_gr_cont").append($(this));
                         
                        }

                    });
                    //if (!in_array(item.url_point, arr_url)) {
                    //$(".place_gr_cont").append(html); // This will be the div where our content will be loaded
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
    function initialize_map(){}

    function in_array(needle, haystack, strict) {	// Checks if a value exists in an array
        //
        // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

        var found = false, key, strict = !!strict;

        for (key in haystack) {
            if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
                found = true;
                break;
            }
        }

        return found;
    }
</script>
    <script>
     jQuery('.page_info').css({
    height : jQuery(window).height() + 'px'
 });
jQuery(document).ready(function ($) {

    $(window).resize(function(){
        jQuery('.page_info').css({
          height : jQuery(window).height() + 'px'
        });
    });
    $(".page_info").css("visibility","visible");
    var catHeight = $('.blog_category').height();
        $('.blog_category').css({
            'margin-top': ((catHeight/2)*(-1)) + 'px'
    })
        if($('.btn ').hasClass('more_btn2')){
           $('.grid_cont').append('<div class="gradient_bg"></div>');
       }
       else{
        $('.Places_grid .item_wide_container').css({
            'padding-bottom': '50px'
        })
    }
});

    </script>
<?php get_footer(); ?>
