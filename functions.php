<?php

/**
 * Class MyCity
 */
class MyCity_class
{
    public function __construct()
    {
        // Include required files
        $this->includes();
        /**
         * Hooks
         */
        //live edit
        add_action('wp_head', array($this, 'mycity_buffer_start'));
        add_action('wp_footer', array($this, 'mycity_buffer_end'));
        // widgets
        add_action('widgets_init', array($this, 'mycity_arphabet_widgets_init'));
        add_action('after_setup_theme', array($this, 'mycity_crucial_setup'));
        add_action('current_screen', array($this, 'mycity_my_theme_add_editor_styles'));
        //update key in ttshowcase
        add_action('save_post', array($this, 'mycity_add_ttshowcase_post'));
        add_action('wp_head', array($this, 'mycity_wp_head'), 20);
        /**
         * filters
         * */
        add_filter('body_class', array($this, 'mycity_add_body_class'));
        add_filter('bp_get_add_friend_button', array($this, 'mycity_my_add_friend_link_text'));
        add_filter('the_category', array($this, 'the_category_filter'));

        add_filter('term_description', array($this, 'mycity_clear_term_description_image_shortcode'));
        add_filter('preprocess_comment', array($this, 'mycity_check_coments'));
        add_filter('wp_title', array($this, 'mycity_title_2'), 900);
        add_filter('get_the_excerpt', array($this, 'mycity_cutoff_the_excerpt'), 900);
        //theme support
        $this->theme_support_setting();
        $this->redirect_to_edit_places();
    }

    /**
     * require files and function
     */
    function includes()
    {
        //# Part 1. Includes
        require get_template_directory() . '/assets/BFI_Thumb.php';
        require get_template_directory() . '/assets/widgets.php';
        require get_template_directory() . '/assets/mailchimp.php';

        require get_template_directory() . '/assets/loadmore.php';
        require get_template_directory() . '/assets/optimizator.php';
        require get_template_directory() . '/assets/fa.php';
        require get_template_directory() . '/assets/fmr.php';
        require get_template_directory() . '/assets/rates.php';
        require get_template_directory() . '/assets/category_template.php';
        require get_template_directory() . '/assets/color.php';
        require get_template_directory() . '/assets/metabox.php';
        require get_template_directory() . '/assets/page_map_get_marker.php';

        require get_template_directory() . '/assets/follow.php';
        require get_template_directory() . '/assets/admin_extra.php';
        require get_template_directory() . '/assets/tgm.php';
        require get_template_directory() . '/assets/customizer.php';
        require get_template_directory() . '/assets/rating.php';
        require get_template_directory() . '/assets/http.php';
        require get_template_directory() . '/assets/facebook.php';
        require get_template_directory() . '/assets/new_css_generator.php';
        require get_template_directory() . '/assets/color_hack.php';
        require get_template_directory() . '/assets/get_menu_button.php';
        require get_template_directory() . '/assets/avatar_uploader.php';
        require get_template_directory() . '/assets/additional_functions.php';
        //  custom Walker to menu WP
        require get_template_directory() . '/assets/class-top_menu.php';
        require get_template_directory() . '/assets/simple_html_dom.php';
        //ajax uber
        require get_template_directory() . '/assets/uber_ajax.php';
        require get_template_directory() . '/assets/style_scripts.php';
        require get_template_directory() . '/assets/ajax_css.php';
        require get_template_directory() . '/assets/langs.php';
        require get_template_directory() . '/assets/shortcode.php';
        require get_template_directory() . '/assets/VC_MAP.php';
        require get_template_directory() . '/assets/instagram.php';


    }

    /**
     * theme support setting
     */
    function theme_support_setting()
    {
        add_theme_support('custom-background');
        add_theme_support("title-tag");
        add_theme_support('automatic-feed-links');
        add_theme_support("custom-header", array());
        add_theme_support('post-thumbnails');
        add_post_type_support('places', array('comments'));
        add_image_size("mycity_panorama", 1111, 400, true);
        add_image_size("mycity_square200", 200, 200, true);
        add_image_size("mycity_squarex320x201", 320, 201, true);
        set_post_thumbnail_size(1111, 400, true);
        register_nav_menus(array('usermenu' => esc_html__('Main left menu', "mycity"), 'mycity_topmenu' =>
            'Header menu', 'posts_category_menu' => esc_html__('posts category menu', "mycity")));
    }
    /************************************************************
     *                           Hooks Action
     ************************************************************/

    /**
     * /If the admin click the Edit button and if the place has forwarded it to the desired location
     */
    protected function redirect_to_edit_places()
    {
        /*if (isset($_GET['post'])) {
            if (get_post_type($_GET['post']) == 'places') {

                $pgs = get_pages(array(
                    'meta_key' => '_wp_page_template',
                    'meta_value' => 'template-add.php'
                ));
                $editlink = add_query_arg('page', (int)$_GET['post'], get_permalink($pgs[0]->ID));

                wp_safe_redirect(esc_url($editlink));
            }
        }*/
    }

    /**
     * Performs sql query and RETURN it
     * @param string $sql
     * @return mixed
     */
    public static function mycity_q($sql)
    {
        global $wpdb;
        $wpdb->hide_errors();
        return $wpdb->query($sql);
    }

    /**
     * Live edit on site
     * @param $buffer
     * @return mixed
     */
    function mycity_replace_edited_section($buffer)
    {
        $all_options = wp_load_alloptions();
        $my_options = array();
        foreach ($all_options as $name => $value) {
            if (strstr($name, 'edited_')) {
                $buffer = preg_replace("#id='" . $name . "'.*?>([^<]*?)<#", "id='" . $name .
                    "' data-original='$1'>" . $value . "<", $buffer);
                $buffer = preg_replace("#id='" . $name . "'>([^<]*?)<#", "id='" . $name . "' data-original='$1'>" .
                    $value . "<", $buffer);
            }
        }
        $buffer = preg_replace("#body.custom-background { background-image: url\('(.*?)'\)#",
            ".custom-background { background-image: url('$1')!important", $buffer);
        //if (!current_user_can("administrator")){
        $buffer = preg_replace("#\[fa(.*?)\]#", '<i class="fa fa$1"></i>', $buffer);
        //}
        $buffer = preg_replace("#\[fmr-icon-(.*?)\]#", '<i class="fmr fmr-icon-$1"></i>', $buffer);
        $buffer = str_replace('F !important; }</style>);</script>', 'F !important; }</style>");</script>', $buffer); //slider revolution small bug fix

        $buffer = preg_replace("#fa fmr#", 'fmr fmr', $buffer);


        //HTTPS
        
        /*if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') { //HTTPS
            $buffer = str_replace('http://', 'https://', $buffer);
        }*/
        return $buffer;
    }
    /**
     * Cut shortcodes
     * @param string $param preg replace
     * @return mixed
     */

    /**
     *buffer start
     */
    function mycity_buffer_start()
    {
        ob_start(array($this, "mycity_replace_edited_section"));
    }

    /**
     *buffer end
     */
    function mycity_buffer_end()
    {
        ob_end_flush();
    }

    /**
     *Register fields for widgets
     */
    function mycity_arphabet_widgets_init()
    {
        register_sidebar(array(
            'name' => esc_html__('Left menu area', "mycity"),
            'id' => 'left_menu_widget',
            'before_widget' => '<div>',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="rounded">',
            'after_title' => '</h2>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer area', "mycity"),
            'id' => 'mycity_footer',
            'before_widget' => '<div class="col-md-3">',
            'after_widget' => '</div>',
            'before_title' => '<h2>',
            'after_title' => '</h2>',
        ));
    }

    /**
     * Specify the domain for translation
     *
     * language translator for mycity
     */
    function mycity_crucial_setup()
    {
        load_theme_textdomain('mycity', get_template_directory() . '/languages');

    }
    /************************************************************
     *                           Filters
     ************************************************************/

    /**
     * add editor styles
     */
    function mycity_my_theme_add_editor_styles()
    {
        add_editor_style('editor_styles.css');
    }

    function mycity_wp_head($head)
    {
        echo '<!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->';
    }

    /**
     * add custom body class
     * @param string $classes
     * @return array
     */
    function mycity_add_body_class($classes)
    {
        global $post, $wp_query;
        if (isset($post)) {
            $classes[] = $post->post_type . '-' . $post->post_name;

            if (get_post_meta($post->ID, 'mycity_hide_header', false)) {
                $classes[] = " small_header ";
            }
            if (get_post_type($post->ID) == 'advert' || isset($wp_query->tax_query->queried_terms['advert_category']['terms'][0]{1})) {
                $classes[] = " small_header ";
                $classes[] = " wider ";
                $classes[] = " Single_page ";
            }
            if (get_theme_mod("site_Identity_layout", 's2') != 's2') {
                $classes[] = " boxed_style ";
            }
            $s = trim(get_search_query());
            if (isset($s{0})) {
                $classes[] = " Places_list  wide   ";
            }
        }

        $mycity_user_info = sanitize_text_field(get_theme_mod('site_Identity_layout', 's1'));
        //if($mycity_user_info == 's1')
        $classes[] = " wide";


        //var_dump( $classes);
        return sanitize_html_class($classes);
    }

    /**
     * @param $button
     * @return mixed
     */
    function mycity_my_add_friend_link_text($button)
    {
        $button['link_class'] .= " btn btn-primary";
        return $button;
    }

    /**
     *  replace the [fa]
     * @param $cats
     * @return string
     */
    public function the_category_filter($cats)
    {
        $item = $cats;
        preg_match_all("#\[fa(.*?)\]#", $item, $arr);
        if (isset($arr[1][0])) {
            foreach ($arr[1] as $new_arr) {
                $item = str_replace("[fa" . $new_arr . "]", '', $item);
            }
        }
        return sanitize_text_field($item);
    }

    /**
     * @param $value
     * @return mixed
     */
    function mycity_clear_term_description_image_shortcode($value)
    {
        $out = str_replace("<p>", "", $value);
        return str_replace("</p>", "", $out);
    }

    /**
     * Function limits for comments to 200 characters, and check for empty and cut all tags ntml
     *
     * @param string $commentdata array of comments
     * @return mixed
     */
    function mycity_check_coments($commentdata)
    {
        $coment = preg_replace("/<.*?>/", "", $commentdata['comment_content']);
        if (strlen($coment) < 1) {
            wp_die(esc_html__('Comment is empty', 'mycity'));
            exit;
        }
        if (strlen($coment) > 200) {
            wp_die(esc_html__('Comment more than 200 characters', 'mycity'));
            exit;
        }
        return $commentdata;
    }

    /**
     * Adds the id of the current locations in key _insert post which is associated with  ttshowca     post
     * @param int $post_id
     */
    function mycity_add_ttshowcase_post($post_id)
    {
        //var_dump($post_id);


        if ((get_post_type($post_id) == 'ttshowcase') && isset($_COOKIE['mycity_post_id'])) {
            //var_dump($_COOKIE);
            add_post_meta($post_id, '_insetr_post', sanitize_text_field($GLOBALS["mycity_post_ID"]));
            update_post_meta($post_id, '_insetr_post', sanitize_text_field(@$_COOKIE['mycity_post_id']));
        }
        if (get_post_type($post_id) == 'ajde_events')  {            
            update_post_meta($post_id, '_evcal_exlink_option', '3');
        }

    }

    /**
     * Cut the Title shortcodes
     *
     * @param $title
     * @return mixed
     */
    function mycity_title_2($title)
    {
        return sanitize_text_field(preg_replace("#\[fa(.*?)\]#", '', $title));
    }

    /************************************************************
     *                          Metods
     ************************************************************/

    function get_fa_icons_cat_title($cat_name)
    {

        return $cat_name;
    }
    /**
     * @param $filter
     * @return mixed
     */
    //cuts JS code
    function mycity_cutoff_the_excerpt($text)
    {
        $out = $text;
        $out = iconv_substr($out, 0, 220, 'utf-8');
        return preg_replace('@(.*)\s[^\s]*$@s', '\\1 ...', $out);

    }


    function mycity_esc_js($filter)
    {
        return preg_replace('/<script.*?<\/script>/', '', $filter);
    }

    /**
     * @param $maxchar
     */
    function truncate_str($maxchar)
    { //Specifies the number of characters
        $out = get_the_excerpt();
        $out = iconv_substr($out, 0, $maxchar, 'utf-8');
        $out = preg_replace('@(.*)\s[^\s]*$@s', '\\1 ', $out);
        echo wp_kses_post($out);
    }
    /****************************************************
     *                  Helper methods
     * **************************************************
     */

    /**
     * @return string
     */
    function mycity_container_class()
    {
        $mod = get_theme_mod("site_Identity_layout", 's2');
        if ($mod == "s2")
            return "container-fluid container-fluid_pad_off";
        return "container";
    }

    /**
     * replace the [fa] to <i class="fa fa></i>
     * @param $item
     * @return string
     */
    function icon_converter($item, $count = false)
    {
        $i = 0;
        preg_match_all("#\[fa(.*?)\]#", $item, $arr);
        if (isset($arr[1][0])) {
            foreach ($arr[1] as $new_arr) {
                $i++;

                $item = str_replace("[fa" . $new_arr . "]", ' <i class="fa fa' . $new_arr .
                    '"></i> ', $item . $i);
            }
        }

        return $item;
    }

    /**
     * @return array empty id of places
     */
    function get_empty_places()
    {
        global $wpdb;
        $empty_post = $wpdb->get_results($wpdb->prepare(
            "SELECT ID FROM `$wpdb->posts` WHERE `post_title` = %s OR `post_title` = %s ",
            esc_html__('Enter the place name', "mycity"),
            ''
        ));
        $empty_post_id = array();
        //get empty posts
        foreach ($empty_post as $item) {
            $empty_post_id[] = esc_html($item->ID);
        }
        return $empty_post_id;
    }

    /**
     *Check for the existence of posts on the second page
     * @param $args
     * @return bool
     */
    function check_post_in_second_page($args)
    {
        $args['paged'] = 2;
        $c_query = new WP_Query($args);
        if ($c_query->post_count > 0) {
            $return = true;
        } else {
            $return = false;
        }
        wp_reset_postdata();
        return $return;
    }

    /**
     * return number of cats in category
     * @return int|void
     */
    function ajax_get_the_category()
    {
        $category = get_category(get_query_var('cat'));
        $mycity_cat = (int)$category->cat_ID;
        $count = (int)$category->count;
        if (isset($wp_query->query["pagename"])) {
            if ($wp_query->query["pagename"] == 'blogfeed') {
                return 0;
            } else {
                return $cat;
            }
        } else {
            return $cat;
        }
    }

    /**
     * Prepares correct the url to google font
     * @param $fonts_param
     * @return string url google fonts
     */
    function google_fonts_url($fonts_param)
    {
        $font_url = '';
        /*
        Translators: If there are characters in your language that are not supported
        by chosen font(s), translate this to 'off'. Do not translate into your own language.
         */
        if ('off' !== esc_html_x('on', 'Google font: on or off', 'mycity')) {
            $font_url = add_query_arg('family', urlencode($fonts_param), "//fonts.googleapis.com/css");
        }
        $font_url = str_replace('%2B', '+', $font_url);
        return $font_url;
    }

    function get_pots_image_url()
    {
        $thumbnail = get_the_post_thumbnail(get_the_id(), 'panorama');
        preg_match_all('#src="(.*?)"#si', $thumbnail, $thumb_url);
        if (isset($thumb_url[1][0])) {
            return esc_url($thumb_url[1][0]);
        } else {
            return false;
        }
    }

    /**
     * @param $string
     * @param bool|false $return
     * @return string
     */
    function get_fa_icons($string, $return = false)
    {
        preg_match_all("#\[fa(.*?)\]#", $string, $arr);
        if (isset($arr[1][0])) {
            $item = str_replace("[fa" . $arr[1][0] . "]", ' <i class="fa fa' . $arr[1][0] .
                '"></i> ', $string);
        } else {
            $item = $string;
        }
        $allowed_html = array('i' => array('class' => array()));
        if ($return == false) {
            echo wp_kses($item, $allowed_html);
        } else {
            return wp_kses($item, $allowed_html);
        }
    }

    /**
     * get post id y meta value
     * @param $post_type
     * @param $value
     * @return array
     */
    function get_post_id_by_postmeta_value($post_type, $value)
    {

        $arr_id = array();
        $args = array(
            'post_type' => $post_type,
            'meta_query' => array(
                array(
                    "key" => "_myfield",
                    "value" => $value,
                    "compare" => "="
                )
            )
        );
        $my_query = new WP_Query($args);

        if ($my_query->have_posts()) {
            while ($my_query->have_posts()) {
                $my_query->the_post();
                $arr_id[] = get_the_ID();
            } // end while
        } // end if
        wp_reset_postdata();
        wp_reset_query();

        return $arr_id;

    }


}

$GLOBALS['MyCity_class'] = new MyCity_class();
$GLOBALS['MyCity'] = $GLOBALS['MyCity_class'];
/*==============================================================================*/
add_filter('eventon_wp_query_args', 'mycity_my2_eventon', 50);
/**
 * Attach eventon to the right place
 *
 * Select only those events for which is set in the key 'evcal_location_name' post of ID
 *
 * @param $arguments
 * @return mixed
 */
function mycity_my2_eventon($arguments)
{

    global $post;
    if (!isset($GLOBALS["mycity__post__ID"]))
        $GLOBALS["mycity__post__ID"] = 0;
    $post_id = (!empty($GLOBALS["mycity__post__ID"])) ? sanitize_text_field($GLOBALS["mycity__post__ID"]) : sanitize_text_field(@$_COOKIE['mycity_post_id_2']);
    $title = sanitize_text_field(get_the_title($post_id));

    if (get_post_type($post_id) == 'places' && get_post_type($post->id) != 'page') {

        $mycity_textInput = get_post_meta($post_id, '_myfield', true);
        $mycity_ex = explode(",", $mycity_textInput);

        $arguments['meta_query'] = $arguments['meta_query'] = array(

            array(
                "key" => "evcal_lat",
                "value" => sanitize_text_field($mycity_ex[0]),
                "compare" => "="
            ),
            array(
                "key" => "evcal_lon",
                "value" => sanitize_text_field($mycity_ex[1]),
                "compare" => "="
            ),


        );

    }
    //$arguments['posts_per_page'] = 5;
    return $arguments;
}

add_filter('get_the_excerpt', 'mycity_exc', 90);
/**
 * carves out a brief description of shortcodes
 * @param $param
 * @return mixed
 */
function mycity_exc($param)
{
    $param = preg_replace("/\[.*?\].*?\[\/.*?\]/", "", $param);
    $param = preg_replace("/<.*?>/", "", $param);
    return $param;
}

function mycity_newBasename($path = false, $is_page = false)
{
    if ($path == false && $is_page = false) $path = get_page_template();
    if ($path == false && $is_page = true && is_page()) {
        $path = get_page_template();
    }
    $path = str_replace('\\', '/', $path);
    $path_array = explode('/', $path);
    return array_pop($path_array);
}

function mycity_wp_comments_corenavi()
{
    $pages = '';
    $max = get_comment_pages_count();
    $page = get_query_var('cpage');
    if (!$page) $page = 1;
    $a['current'] = $page;
    $a['echo'] = false;
    $total = 0; //1 - display text "Page N of N", 0 - not to withdraw
    $a['mid_size'] = 3; // how many links to display on the left and right of the current
    $a['end_size'] = 1; // how many links to show the beginning and the end
    $a['prev_text'] = '&laquo;'; // link text "Previous"
    $a['next_text'] = '&raquo;'; // link text "Next page"
    if ($max > 1) echo '<div class="commentNavigation">';
    echo esc_attr($pages) . paginate_comments_links($a);
    if ($max > 1) echo '</div>';
}

add_filter('single_cat_title', 'mycity_get_fa_icons_cat_title', 10, 1);
function mycity_get_fa_icons_cat_title($n)
{
    return $GLOBALS['MyCity']->get_fa_icons($n, true);
}

function mycity_get_url_by_avatar($get_avatar)
{
    preg_match('/src="(.*?)"/i', $get_avatar, $matches);
    return $matches[1];
}

function mycity_get_visited2($id)
{
    global $wpdb;
    $wpdb->hide_errors();
    $id = (int)$id;

    $sql = $wpdb->prepare("SELECT * FROM follow WHERE user1 = '%s' AND user2 < 0", $id);

    $followers = $wpdb->get_results($sql);
    $ids = array();
    foreach ($followers as $lover) {
        $ids[] = $lover->user2 * -1;
    }
    return $ids;
}

function mycity_link_pages()
{
    /* ================ Settings ================ */
    $text_num_page = ''; // The text for the number of pages. {current} is replaced by the current, and {last} the last. Example: "Page {current} of {last} '= Page 4 of 60
    $num_pages = 10; // how many links to display
    $stepLink = 10; // after the navigation links to specific step (value = the number (a pitch) or '' if you do not need to show). Example: 1,2,3 ... 10,20,30
    $dotright_text = '...';
    $dotright_text2 = '...';
    $backtext = '&#171;';
    $nexttext = '&raquo;';
    $first_page_text = ''; //  text "to the first page" or put '', instead of the text if you need to show a page number.
    $last_page_text = ''; // text "to the last page 'or write' 'if, instead of the text you need to show a page number.
    /* ================ End Settings ================ */
    global $page, $numpages;
    $paged = (int)$page;
    $max_page = $numpages;
    if ($max_page <= 1) return false; //check the need for navigation
    if (empty($paged) || $paged == 0) $paged = 1;
    $pages_to_show = intval($num_pages);
    $pages_to_show_minus_1 = $pages_to_show - 1;
    $half_page_start = floor($pages_to_show_minus_1 / 2); //how many links to the current page
    $half_page_end = ceil($pages_to_show_minus_1 / 2); //how many links after current page
    $start_page = $paged - $half_page_start; //first page
    $end_page = $paged + $half_page_end; //last page (conditionally)
    if ($start_page <= 0) $start_page = 1;
    if (($end_page - $start_page) != $pages_to_show_minus_1) $end_page = $start_page + $pages_to_show_minus_1;
    if ($end_page > $max_page) {
        $start_page = $max_page - $pages_to_show_minus_1;
        $end_page = (int)$max_page;
    }
    if ($start_page <= 0) $start_page = 1;
    $out = '';
    $out .= "<div class='wp-pagenavi'>\n";
    if ($text_num_page) {
        $text_num_page = preg_replace('!{current}|{last}!', '%s', $text_num_page);
        $out .= sprintf("<span class='pages'>$text_num_page</span>", $paged, $max_page);
    }
    if ($backtext && $paged != 1) $out .= _wp_link_page(($paged - 1)) . $backtext . '</a>';
    if ($start_page >= 2 && $pages_to_show < $max_page) {
        $out .= _wp_link_page(1) . ($first_page_text ? $first_page_text : 1) . '</a>';
        if ($dotright_text && $start_page != 2) $out .= '<span class="extend">' . $dotright_text . '</span>';
    }
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $paged) {
            $out .= '<span class="page-numbers current">' . $i . '</span>';
        } else {
            $out .= '<a href="' . _wp_link_page($i) . '">' . $i . '</a>';
        }
    }
    //Links increments
    if ($stepLink && $end_page < $max_page) {
        for ($i = $end_page + 1; $i <= $max_page; $i++) {
            if ($i % $stepLink == 0 && $i !== $num_pages) {
                if (++$dd == 1) $out .= '<span class="extend">' . $dotright_text2 . '</span>';
                $out .= '<a href="' . _wp_link_page($i) . '">' . $i . '</a>';
            }
        }
    }
    if ($end_page < $max_page) {
        if ($dotright_text && $end_page != ($max_page - 1)) $out .= '<span class="extend">' . $dotright_text2 . '</span>';
        $out .= _wp_link_page($max_page) . ($last_page_text ? $last_page_text : $max_page) . '</a>';
    }
    if ($nexttext && $paged != $end_page) $out .= _wp_link_page(($paged + 1)) . $nexttext . '</a>';
    $out .= "</div>";
    $out = str_replace('"<a href="', '"', $out);
    $out = str_replace('">">', '">', $out);
    return wp_kses_post($out);
}

function mycity_get_member_permalink($uid)
{
    $pgs = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'template-members-list.php'
    ));
    if (!isset($pgs[0]->ID)) return "#";
    $editlink = add_query_arg('page', $uid, get_permalink($pgs[0]->ID));

    return $editlink;
}

if (!isset($content_width)) {
    $content_width = 1170;
}

function fmr_get_permalink_by_template($template, $pageid = null)
{
    $pgs = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => $template
    ));
    if (!isset($pgs[0]->ID)) return false;
    if ($pageid == null) return get_permalink($pgs[0]->ID);
    if ('' != get_option('permalink_structure')) {
        // using pretty permalinks, append to url
        return user_trailingslashit(get_permalink($pgs[0]->ID) . $pageid); // www.example.com/pagename/test
    } else {
        return add_query_arg('page', $pageid, get_permalink($pgs[0]->ID));
    }


}

function fmr_l($s, $r = null)
{
    return fmr_get_permalink_by_template($s, $r);
}

function fmr_addtoquery($url, $nam, $val)
{
    $query = parse_url($url, PHP_URL_QUERY);
    if ($query) {
        $url .= '&' . $nam . '=' . $val;
    } else {
        $url .= '?' . $nam . '=' . $val;
    }
    return $url;
}


global $mycity_lang, $mycity_langs;

$mycity_lang = substr(get_bloginfo('language'), 0, 2);

add_filter('gettext', 'fmr_translate', 10, 3);

function fmr_translate($translated, $text, $domain)
{
    global $_SERVER;
    global $mycity_lang, $mycity_langs, $_COOKIE;
    //var_dump($_COOKIE['lang']);
    if ($translated == $text && isset($_COOKIE['lang'])) {
        $text = trim($text);
        if (isset($mycity_langs[$text][$_COOKIE['lang']])) $translated = $mycity_langs[$text][$_COOKIE['lang']];
    }

    return $translated;
}

/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function mycity_add_dashboard_widgets()
{

    wp_add_dashboard_widget(
        'example_dashboard_widget',         // Widget slug.
        esc_html__('Mycity news', 'mycity'),       // Title.
        'mycity_dashboard_widget_function' // Display function.
    );
}

add_action('wp_dashboard_setup', 'mycity_add_dashboard_widgets');

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function mycity_dashboard_widget_function()
{

    // Display whatever it is you want to show.
    ?>
    <iframe src="http://wpmix.net/news.php?to=mycity" width="100%" height="300px"></iframe>


    <?php
}

function mycity_js_str($s)
{
    return str_replace(" ", "", "'" . addcslashes($s, "\0..\37\"\\") . "'");
}

function mycity_js_array($array)
{
    $temp = array_map('mycity_js_str', $array);
    return '[' . implode(',', $temp) . ']';
}


function my_update_notice()
{
    //delete_option('mycity_reg');
    if (get_option('mycity_reg') != true) {
        $class = "error notice";
        if (isset($_GET['my_register']) && !empty($_GET['my_register'])) {
            $class = "updated notice";
        } ?>
        <div class="<?php echo esc_html($class); ?>">
            <div class="mycity_reg">
                <?php

                if (isset($_GET['my_register']) && !empty($_GET['my_register'])) {
                    ?>
                    <p><?php esc_html_e('Theme registered! awesome', 'mycity'); ?> </p>
                    <?php
                } else { ?>
                    <form style="" action="http://wpmix.net/themereg.php" method="post" id="reg_mycity">
                        <h3><?php esc_html_e('Register your theme!', 'mycity'); ?></h3>
                        <p><?php esc_html_e("You will receive important news and updates", 'mycity'); ?></p>
                        <table class="form-table">
                            <tbody>
                            <input type="hidden" id="cb_url" name="cb_url" value="">
                            <input type="hidden" id="url" name="url" value="<?php echo esc_html(get_home_url('/')); ?>">
                            <tr>
                                <th scope="row">
                                    <label for="my_name"><?php esc_html_e('Your Name:', 'mycity') ?></label>
                                </th>
                                <td><input id="my_name" name="my_name" type="text"
                                           class="regular-text"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="my_email"><?php esc_html_e('Email:', 'mycity') ?>
                                    </label>
                                </th>
                                <td><input id="my_email" name="my_email" type="text"
                                           aria-describedby="tagline-description"
                                           class="regular-text">
                                </td>
                            </tr>

                            <tr>
                                <td>   <?php submit_button(esc_html__('Register', 'mycity')); ?>
                            </tr>

                            </tbody>
                        </table>
                    </form>

                <?php } ?>
            </div>
            <div class=" mycite_news">
                <iframe src="http://wpmix.net/news.php?to=mycity" width="100%" height="300px"></iframe>
            </div>
        </div>
        <script>
            jQuery(document).ready(function ($) {
                $('#reg_mycity').submit(function (e) {
                    $('#cb_url').val(document.URL);
                    if (isValidEmailAddress($('#my_email').val())) {
                    } else {
                        alert('<?php  echo esc_html__('invalid email')?>');
                        return false;
                    }
                    if ($('#my_name').val().length < 5) {
                        alert('<?php  echo esc_html__('incorrect name')?>');
                        return false;
                    }
                });
            });
            function isValidEmailAddress(emailAddress) {
                var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
                return pattern.test(emailAddress);
            }
        </script>

        <?php
    }

    if (isset($_GET['my_register']) && !empty($_GET['my_register'])) {
        update_option('mycity_reg', true);
    }


}

//add_action('admin_notices', 'my_update_notice');


add_action('save_post', 'mycity_my_save_post_function', 10, 3);
add_action('publish_post', 'mycity_my_save_post_function_2', 10, 2);

/*
 *  delete cache
 */
function mycity_my_save_post_function($post_ID, $post, $update)
{
    delete_transient('mycity_places_map');
}

function mycity_my_save_post_function_2($post_ID, $post)
{
    delete_transient('mycity_places_map');
}

add_action('delete_post', 'mycity_my_save_post_function_d', 10);


function mycity_my_save_post_function_d($p)
{
    delete_transient('mycity_places_map');
}


// ADD NEW COLUMN
function mycity_columns_head($defaults)
{
    $defaults['place_author'] = esc_html__('Author', 'mycity');
    return $defaults;
}

// SHOW THE AUTHOR Places
function mycity_columns_content($column_name, $post_ID)
{
    if ($column_name == 'place_author') {
        $post = get_post($post_ID);
        $sutor_id = $post->post_author;

        echo esc_html(get_userdata($sutor_id)->display_name);
    }
}

add_filter('manage_places_posts_columns', 'mycity_columns_head');
add_action('manage_places_posts_custom_column', 'mycity_columns_content', 10, 2);


function mycity_get_sticky_places()
{
    $stickies = get_option('sticky_posts');

    $new_stickies = array();
    foreach ($stickies as $id) {
        if (get_post_type($id) == 'places') {
            $new_stickies[] = $id;
        }
    }
    return $new_stickies;
}

