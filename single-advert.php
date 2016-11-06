<?php
/**
 * Created by PhpStorm.
 * User: Pro
 * Date: 21.03.2016
 * Time: 21:36
 */
get_header();

// Start the Loop.?
?>

<?php
if (have_posts()):
    // Yep, we have posts, so let's loop through them.
    while (have_posts()) : the_post();
        // do your loop
       /* the_title();
        the_content();*/
    endwhile;
else :
    // No, we don't have any posts, so maybe we display a nice message
    // echo "<p class='no-posts'>" . __( "Sorry, there are no posts at this time." ) . "</p>";
endif;

while (have_posts()) : the_post();
    // do your loop

    ?>
    <div class="header_section_popup"></div>
    <div class="site-overlay"></div>

    <div id="container">

    <div class="container page_info place_info">
        <div class="col-md-12 blog_category">
            <div class="open post_info single_h1">
                <h1><?php the_title(); ?><span></span></h1>
                <?php

                $short_desc = get_post_meta($post->ID, 'mycity_short_description', true);
                if (strlen(trim($short_desc)) > 2) {
                    echo "<p>" . wp_kses_post($short_desc) . "</p>";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="item_wide_container">
        <div class="container container-fluid container-fluid_pad_off  shortcodes">
            <?php

            the_content();
            ?></div>
    </div>
    </div><?php
endwhile;


?> <script>
    jQuery(document).ready(function ($) {
        jQuery('.place_info').css('visibility', 'visible');
    });
   /* jQuery(document).ready(function ($) {
        jQuery('.page_info').css({
            height : jQuery(window).height() + 'px'
        });
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

    });


*/
    </script>
<?php
get_footer();