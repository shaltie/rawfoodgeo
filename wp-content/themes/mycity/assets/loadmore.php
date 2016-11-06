<?php


function mycity_wp_s()
{
    global $wpdb, $MyCity_class, $mycity_query_grid;


    $paged = (int)sanitize_text_field($_POST['page_no']);
    $posts_per_page = (int)sanitize_text_field('posts_per_page');
    $terms = sanitize_text_field($_POST['terms']);
    $tag = "";
    if (strlen($tag) > 1) {
        $tag = sanitize_text_field($_POST['tag']);
    }
    # Load the posts

    $args = array(
        'showposts' => $posts_per_page,
        'paged' => $paged,
        'post__not_in' => $MyCity_class->get_empty_places()); //exlude empty post

    // var_dump($args);
    $mycity_query_grid = new WP_Query($args);


    if ($mycity_query_grid->have_posts()) : ?>

        <!-- .page-header -->
        <?php
        // Start the Loop.
        while ($mycity_query_grid->have_posts()) : $mycity_query_grid->the_post();
            $img = esc_url(get_template_directory_uri()) . "/img/pl3.jpg";
            $small_img = wp_get_attachment_url(get_post_meta(get_the_ID(), '_big_img', true));
            $img = bfi_thumb($small_img, array('width' => 200, 'height' => 200, 'crop' => true));

            
            $thumbnail = get_the_post_thumbnail(get_the_ID(), 'full');
            preg_match_all('#src="(.*?)"#si', $thumbnail, $thumb_url);       

           
            if (isset($thumb_url[1][0])) {
                $img = bfi_thumb($thumb_url[1][0], array('width' => 200, 'height' => 200, 'crop' => true));

            } 
            
            $except = get_the_excerpt();
            ?>
            <div
                class="pg style_list places_list_my">

                <div class="con clearfix">
                    <img class="wh200" src="<?php echo esc_html($img); ?>" alt="">
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
        
        <!-- .page-header -->
        <?php
    endif;

    wp_reset_postdata();

    exit;
    die();
}

add_action('wp_ajax_mycity_wp_s', 'mycity_wp_s'); // for logged in user
add_action('wp_ajax_nopriv_mycity_wp_s', 'mycity_wp_s'); // if user not logged in


/*-----------------------Ajax paginate places list------------------------------------------*/
/**
 * @return new places grid
 */
function mycity_wp_places_grid()
{
    global $wpdb, $MyCity_class, $mycity_query_grid;

    $paged = (int)sanitize_text_field($_POST['page_no']);
    $posts_per_page = (int)sanitize_text_field('posts_per_page');
    $terms = sanitize_text_field($_POST['terms']);
    $tag = "";
    if (strlen($tag) > 1) {
        $tag = sanitize_text_field($_POST['tag']);
    }
    # Load the posts

    $args = array(
        'post_type' => 'places',
        'showposts' => $posts_per_page,
        'paged' => $paged,
        'post__not_in' => $MyCity_class->get_empty_places()); //exlude empty post

    if (strlen($terms) > 1) {
        $args['tax_query'] = array(array(
            'taxonomy' => 'places_categories',
            'terms' => $terms,
            'field' => 'slug'));

    }
    //if isset tags
    if (strlen($tag) > 2) {
        $args['meta_query'] = array(array(
            'key' => '_tags',
            'value' => $tag,
            'compare' => 'RLIKE'));
    }


    // var_dump($args);
    $mycity_query_grid = new WP_Query($args);

    get_template_part('partials/loop', 'placegrid');
    wp_reset_postdata();

    exit;
    die();
}

add_action('wp_ajax_mycity_wp_places_grid', 'mycity_wp_places_grid'); // for logged in user
add_action('wp_ajax_nopriv_mycity_wp_places_grid', 'mycity_wp_places_grid'); // if user not logged in


/*-----------------------Ajax paginate places list------------------------------------------*/
/**
 * @return new places_lis
 */
function mycity_wp_places_list()
{

    global $wpdb, $MyCity_class, $mycity_query_my2;
    $paged = (int)sanitize_text_field($_POST['page_no']);
    $posts_per_page = (int)sanitize_text_field(get_option('posts_per_page'));
    $terms = sanitize_text_field($_POST['terms']);
    $tag = "";
    if (isset($_POST['tag'])) {
        $tag = sanitize_text_field($_POST['tag']);
    }


    # Load the posts


    $args = array(
        'paged' => $paged,
        'post_type' => 'places',
        'showposts' => $posts_per_page,
        'post__not_in' => $MyCity_class->get_empty_places()); //exlude empty post

    if (strlen($terms) > 1) {
        $args['tax_query'] = array(array(
            'taxonomy' => 'places_categories',
            'terms' => $terms,
            'field' => 'slug'));

    }

    if (strlen($tag) > 2) {
        $args['meta_query'] = array(array(
            'key' => '_tags',
            'value' => $tag,
            'compare' => 'RLIKE'));
    }


    if (isset($_POST['s']) && !empty($_POST['s'])) {
        $args['s'] = sanitize_text_field($_POST['s']);
    }

    //var_dump($args);

    $mycity_query_my2 = new WP_Query($args);


    get_template_part('partials/loop', 'placelist');
    wp_reset_postdata();

    exit;
    die();
}

add_action('wp_ajax_mycity_wp_places_list', 'mycity_wp_places_list'); // for logged in user
add_action('wp_ajax_nopriv_mycity_wp_places_list', 'mycity_wp_places_list'); // if user not logged in


/*-----------------------Ajax paginate------------------------------------------*/
$mycity_wp_infinitepaginate = "";
$GLOBALS['mycity_wp_infinitepaginate'] = "";
/**
 * @return categorias
 */
function mycity_wp_infinitepaginate()
{

    $paged = (int)sanitize_text_field($_POST['page_no']);
    $posts_per_page = (int)sanitize_text_field(get_option('posts_per_page'));

    if ($_POST['is_sticky'] == '1') {
        $ofset += 1;
    }
    $GLOBALS['mycity_wp_infinitepaginate'] = array(
        'paged' => $paged,
        'showposts' => $posts_per_page,
        'cat' => sanitize_text_field($_POST['cat']),
        'post_status' => 'publish',
        'post_type' => sanitize_text_field($_POST['posttype']));


    if (isset($_POST['masonry'])) {
        get_template_part('partials/loop', 'masonry');
    } else {
        get_template_part('partials/loop');
    }


    exit;
    die();
}

add_action('wp_ajax_infinite_scroll', 'mycity_wp_infinitepaginate'); // for logged in user
add_action('wp_ajax_nopriv_infinite_scroll', 'mycity_wp_infinitepaginate'); // if user not logged in


/**
 * Ajax paginate members
 * load new members
 */
function mycity_infinitepaginate2()
{


    $ofset_mebers = (int)sanitize_text_field($_POST['ofset_mebers']);
    $posts_per_page = (int)sanitize_text_field(get_option('posts_per_page'));


    $style = get_theme_mod("members_memberliststyle", "s1");


    $params = array(
        'role' => 'subscriber', //Subscriber role
        'orderby' => 'ID',
        'order' => 'ASC',
        'number' => 6,
        'offset' => $ofset_mebers);


    $uq = new WP_User_Query($params);
    if (!empty($uq->results)) {

        foreach ($uq->results as $GLOBALS['mycity_user']) {
            if ($style == "s1")
                get_template_part("partials/memberlist", "style1");
            if ($style == "s2")
                get_template_part("partials/memberlist", "style2");
            if ($style == "s3")
                get_template_part("partials/memberlist", "style3");


        }
    }

    exit;
    die();
}


add_action('wp_ajax_mycity_infinitepaginate2', 'mycity_infinitepaginate2');
// If you wanted to also use the function for non-logged in users (in a theme for example)
add_action('wp_ajax_nopriv_mycity_infinitepaginate2', 'mycity_infinitepaginate2');


?>