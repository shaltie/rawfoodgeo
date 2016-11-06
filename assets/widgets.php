<?php

add_action('widgets_init', 'mycity_footer_events');
add_action('widgets_init', 'mycity_popular_tags_widget');
add_action('widgets_init', 'mycity_popular_category_widget');
add_action('widgets_init', 'mycity_twiter_widget');
add_action('widgets_init', 'mycity_popular_places');
add_action('widgets_init', 'mycity_airbnb');


/*popular_places*/
function mycity_airbnb()
{
    register_widget('mycity_airbnb_Wigdet');
}

/*popular_places*/
function mycity_popular_places()
{
    register_widget('mycity_popular_places_Wigdet');
    register_widget('mycity_popular_places_folower_Wigdet');
}

/*popular_category*/
function mycity_twiter_widget()
{
    register_widget('mycity_twiter_Wigdet');
}


/*popular_category*/
function mycity_popular_category_widget()
{
    register_widget('mycity_popular_category_Wigdet');
}


//Events
function mycity_footer_events()
{
    register_widget('mycity_footer_events_Wigdet');
}

//Popular tags
function mycity_popular_tags_widget()
{
    register_widget('mycity_popular_tags_Widget');
}


class mycity_airbnb_Wigdet extends WP_Widget
{
    /**
     * Register the new widget
     */

    function __construct()
    {
        $args = array(
            'name' => esc_html__('MyCity Airbnb', 'mycity'),
            'description' => esc_html__('It displays a list of hosts', 'mycity'),
            'classname' => 'mycity_Airbnb'
        );
        parent::__construct('mycity_Airbnb_p', 'MyCity Airbnb', $args);

    }

    /**
     * method to display in the admin
     *
     * @param $instance
     */
    function form($instance)
    {
        extract($instance);
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"> <?php esc_html_e('Title:',
                    'mycity'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php if (isset($title)) {
                       echo esc_attr($title);
                   } ?>">
        </p>


        <p>
            <label for="<?php echo esc_attr($this->get_field_id('url')); ?>"> <?php esc_html_e('URL:',
                    'mycity'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('url')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('url')); ?>" type="text"
                   value="<?php if (isset($url)) {
                       echo esc_attr($url);
                   } ?>">
        </p>


        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('numbers')); ?>"> <?php esc_html_e('How to show places?',
                    'mycity'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('numbers')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('numbers')); ?>" type="text"
                   value="<?php if (isset($numbers)) {
                       echo esc_attr($numbers);
                   } ?>">
        </p>
        <?php
    }

    /**
     * frontend for the site
     *
     * @param $args
     * @param $instance
     */

    function widget($args, $instance)
    {
        extract($args);
        extract($instance);
        $title = sanitize_text_field(apply_filters('widget_title', $title));
        echo wp_kses_post($before_widget . "");

        echo wp_kses_post($before_title) . esc_attr($title) . wp_kses_post($after_title);
        $aribbn_date = get_transient('mycity_aribbn_wiget_2');

        if (strlen($url) > 20) {

            if (false === $aribbn_date) {
                $res = wp_remote_get($url);

                /**********************/

                global $wp_filesystem;

                //the existence check
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }

                $fmr_upload_dir = wp_upload_dir();
                $saw = new mycity_nokogiri($res['body']);

                //get base info
                $arr_pars = $saw->get('div.listings-container div.col-sm-12 .panel-overlay-top-right')->
                toArray();
                //get price currency
                $arr_desciption = $saw->get('div.listings-container div.col-sm-12 .price-label')->
                toArray();

                $currency = $arr_desciption[0]['sup'][0]['#text'];


                $arr_top = array();
                $j = 0;
                foreach ($arr_pars as $item) {
                    // var_dump($item);
                    $arr_top[] = array(
                        'title' => $item['span']['data-name'],
                        'price' => $currency . ' ' . $arr_desciption[$j]['span'][0]['#text'],
                        'rating' => $item['span']['data-star_rating'],
                        'img_src' => $item['span']['data-img'],
                        'decription' => ''
                    );
                    $j++;
                }

                function mycity_sort_rating($a, $b)
                {
                    return ($b['rating'] - $a['rating']);
                }

                usort($arr_top, "mycity_sort_rating");

                if ($numbers > count($arr_top)) {
                    $numbers = count($arr_top);
                }

                $args_cahe = array();

                for ($i = 0; $i < $numbers; $i++) {

                    $args_cahe[] = array(
                        'title' => $arr_top[$i]["title"],
                        'img_src' => $arr_top[$i]["img_src"],
                        'price' => $arr_top[$i]["price"],
                        'rating' => $arr_top[$i]["rating"]
                    );
                }

                ob_start();
                foreach ($args_cahe as $ar) {

                    ?>

                    <a href="<?php echo esc_url(get_theme_mod('airbnb_referal')); ?>">
                        <div class="footer_events footer_places clearfix">
                            <div class="footer_rectangle pull-left footer_rectangle_new">

                                <img src="<?php
                                echo esc_url($ar["img_src"]);
                                ?>" alt="<?php echo esc_attr($ar["title"]); ?>" width="85" height="80">

                            </div>


                            <div class="footer_events_descr pull-left">
                                <p><a><?php echo esc_attr($ar["title"]); ?></a></p>

                                <p>  <?php echo esc_attr($ar["price"]);
                                    ?>  </p>

                                <?php
                                mycity_stars((int)$ar["rating"]);
                                ?>
                            </div>


                        </div>
                    </a>
                    <?php
                }
                $date = ob_get_clean();
                set_transient('mycity_aribbn_wiget', $date, 60 * 60);
                echo $date;
            } else {
                echo get_transient('mycity_aribbn_wiget');
            }

        }


        echo wp_kses_post($after_widget);
    }

    /*
  * a method which, when the update of the widget is executed
  *
  * @param $new_instance
  * @param $old_instance
  * @return mixed
  */
    function update($new_instance, $old_instance)
    {
        delete_transient('mycity_aribbn_wiget');
        $new_instance['title'] = !empty($new_instance['title']) ? esc_attr($new_instance['title']) :
            "";
        $new_instance['numbers'] = ((int)$new_instance['numbers']) ? (int)$new_instance['numbers'] :
            2;
        $new_instance['url'] = ($new_instance['url']) ? esc_url($new_instance['url']) :
            "";

        return $new_instance;
    }

}

/*===================================================================================*/

class mycity_popular_places_Wigdet extends WP_Widget
{
    function __construct()
    {
        $args = array(
            'name' => esc_html__('MyCity Popular places ', 'mycity'),
            'description' => esc_html__('It displays a list of popular places', 'mycity'),
            'classname' => 'mycity_twiter'
        );
        parent::__construct('mycity_places_p', esc_html__('MyCity Popular places', 'mycity'), $args);

    }

    /**
     * method to display in the admin
     *
     * @param $instance
     */

    function form($instance)
    {
        extract($instance);

        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"> <?php esc_html_e('Title:',
                    'mycity'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php if (isset($title)) {
                       echo esc_attr($title);
                   } ?>">
        </p>

        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('numbers')); ?>"> <?php esc_html_e('How to show places?',
                    'mycity'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('numbers')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('numbers')); ?>" type="text"
                   value="<?php if (isset($numbers)) {
                       echo esc_attr($numbers);
                   } ?>">
        </p>
        <?php

    }

    /**
     * frontend for the site
     *
     * @param $args
     * @param $instance
     */

    function widget($args, $instance)
    {
        extract($args);
        extract($instance);
        // Create a filter to the other plug-ins can change them
        $title = sanitize_text_field(apply_filters('widget_title', $title));
        echo wp_kses_post($before_widget . "");

        echo wp_kses_post($before_title) . esc_attr($title) . wp_kses_post($after_title);
        global $wpdb, $MyCity_class;

        $sticky = get_option('sticky_posts');

        $args = array(
            'post_type' => 'places',
            'post__not_in' => $MyCity_class->get_empty_places(),
            'post_status' => 'publish',
            'meta_key' => 'mycity_views',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'posts_per_page' => (int)$numbers,
            'p=' . $sticky[0],
        );

        //exlude empty post

        $j = 0;
        $new_arr = array(
            'post_type' => 'places',
            'post__not_in' => $MyCity_class->get_empty_places(),
            'post_status' => 'publish',
            'posts_per_page' => (int)$numbers,
            'post__in' => mycity_get_sticky_places(),
        );
        $new_arr['meta_query'] = array(
            array(
                'key' => '_small_img',
                'value' => 0,
                'compare' => '!='
            ),
            array(
                'key' => 'mycity_views',
                'value' => 1,
                'compare' => '>=',
                'type' => 'NUMERIC',
            )
        );

        $mycity_query_places = new WP_Query($new_arr);

        if ($mycity_query_places->have_posts()):
            while ($mycity_query_places->have_posts()):
                $mycity_query_places->the_post();

                $small_img = sanitize_text_field(wp_get_attachment_url(get_post_meta(get_the_ID(), '_small_img', true)));
                $small_img = bfi_thumb($small_img, array('width' => 85, 'height' => 80));
                ?>
                <a href="<?php echo esc_url(get_the_permalink()); ?>">
                    <div class="footer_events footer_places clearfix">
                        <div class="footer_rectangle pull-left footer_rectangle_new">
                            <img src="<?php
                            echo esc_url($small_img);
                            ?>" alt="<?php the_title(); ?>">

                        </div>


                        <div class="footer_events_descr pull-left">

                            <p><?php the_title(); ?></p>

                            <p><?php
                                $except = (get_post_meta(get_the_ID(), 'smalldescr', true)) ? (get_post_meta(get_the_ID(), 'smalldescr', true)) : get_the_excerpt();
                                $out = $except;
                                $out = iconv_substr($out, 0, 55, 'utf-8');
                                $out = preg_replace('@(.*)\s[^\s]*$@s', '\\1 ', $out);
                                echo wp_kses_post($out);


                                ?></p> <?php mycity_stars(5); ?>
                        </div>


                    </div>
                </a>

                <?php
                $j++;
            endwhile;
            wp_reset_postdata();
        endif;


        $per_page = (int)$numbers - $j;

        // if sticky place less 3 then
        if ($per_page > 0) {

            $args = array(
                'post_type' => 'places',
                'post__not_in' => array_merge($MyCity_class->get_empty_places()),
                'post_status' => 'publish',
                'meta_key' => 'mycity_views',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'posts_per_page' => (int)$numbers - $j
            );

            //exlude empty post
            $args['meta_query'] = array(
                array(
                    'key' => '_small_img',
                    'value' => 0,
                    'compare' => '!='
                ),
                array(
                    'key' => 'mycity_views',
                    'value' => 1,
                    'compare' => '>=',
                    'type' => 'NUMERIC',
                )
            );


            $mycity_query_places = new WP_Query($args);


            if ($mycity_query_places->have_posts()):
                while ($mycity_query_places->have_posts()):
                    $mycity_query_places->the_post();

                    $small_img = sanitize_text_field(wp_get_attachment_url(get_post_meta(get_the_ID(), '_small_img', true)));
                    $small_img = bfi_thumb($small_img, array('width' => 85, 'height' => 80));
                    ?>
                    <a href="<?php echo esc_url(get_the_permalink()); ?>">
                        <div class="footer_events footer_places clearfix">
                            <div class="footer_rectangle pull-left footer_rectangle_new">
                                <img src="<?php
                                echo esc_url($small_img);
                                ?>" alt="<?php the_title(); ?>">

                            </div>


                            <div class="footer_events_descr pull-left">

                                <p><?php the_title(); ?></p>

                                <p><?php
                                    $except = (get_post_meta(get_the_ID(), 'smalldescr', true)) ? (get_post_meta(get_the_ID(), 'smalldescr', true)) : get_the_excerpt();
                                    $out = $except;
                                    $out = iconv_substr($out, 0, 55, 'utf-8');
                                    $out = preg_replace('@(.*)\s[^\s]*$@s', '\\1 ', $out);
                                    echo wp_kses_post($out);


                                    ?></p> <?php mycity_stars(5); ?>
                            </div>


                        </div>
                    </a>

                    <?php
                endwhile;
            endif;


        }


        wp_reset_postdata();

        echo wp_kses_post($after_widget);
    }

    function update($new_instance, $old_instance)
    {
        $new_instance['title'] = !empty($new_instance['title']) ? esc_attr($new_instance['title']) :
            "";
        $new_instance['numbers'] = ((int)$new_instance['numbers']) ? $new_instance['numbers'] :
            2;

        return $new_instance;
    }


}


class mycity_popular_places_folower_Wigdet extends WP_Widget
{
    function __construct()
    {
        $args = array(
            'name' => esc_html__('MyCity Follower places ', 'mycity'),
            'description' => esc_html__('It displays a list of folower places', 'mycity'),
            'classname' => 'mycity_twiter'
        );
        parent::__construct('mycity_places_f', esc_html__('MyCity Follower places', 'mycity'), $args);

    }

    /**
     * method to display in the admin
     *
     * @param $instance
     */

    function form($instance)
    {
        extract($instance);

        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"> <?php esc_html_e('Title:',
                    'mycity'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php if (isset($title)) {
                       echo esc_attr($title);
                   } ?>">
        </p>

        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('numbers')); ?>"> <?php esc_html_e('How to show places?',
                    'mycity'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('numbers')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('numbers')); ?>" type="text"
                   value="<?php if (isset($numbers)) {
                       echo esc_attr($numbers);
                   } ?>">
        </p>
        <?php

    }

    /**
     * frontend for the site
     *
     * @param $args
     * @param $instance
     */

    function widget($args, $instance)
    {
        extract($args);
        extract($instance);
        // Create a filter to the other plug-ins can change them
        $title = sanitize_text_field(apply_filters('widget_title', $title));
        echo wp_kses_post($before_widget . "");

        echo wp_kses_post($before_title) . esc_attr($title) . wp_kses_post($after_title);
        global $wpdb, $MyCity_class;
        global $wpdb;
        $wpdb->hide_errors();
        $id = get_current_user_id();
        $sql = $wpdb->prepare("SELECT * FROM follow WHERE user1 = '%s' AND user2 < 0", $id);
        $followers = $wpdb->get_results($sql);

        $ids = array();

        $i = 0;
        foreach ($followers as $lover) {
            if ($i > 0) {
                $ids[] = $lover->user2 * -1;
            }
            $i++;
        }

        $ids = array_unique($ids);


        $args = array(
            'post_type' => 'places',
            'post_status' => 'publish',
            'order' => 'DESC',
            'posts_per_page' => (int)$numbers
        );

        $args["post__in"] = $ids;
        //  var_dump( array( '7879' , '52','2535'));
        //var_dump($ids);
//var_dump($args);

        //exlude empty post
        $args['meta_query'] = array(
            array(
                'key' => '_small_img',
                'value' => 0,
                'compare' => '!='
            ),
            array(
                'key' => 'mycity_views',
                'value' => 1,
                'compare' => '>=',
                'type' => 'NUMERIC',
            )
        );


        $mycity_query_places = new WP_Query($args);


        if ($mycity_query_places->have_posts()):
            while ($mycity_query_places->have_posts()):
                $mycity_query_places->the_post();

                $small_img = sanitize_text_field(wp_get_attachment_url(get_post_meta(get_the_ID(), '_small_img', true)));
                $small_img = bfi_thumb($small_img, array('width' => 85, 'height' => 80));
                ?>
                <a href="<?php echo esc_url(get_the_permalink()); ?>">
                    <div class="footer_events footer_places clearfix">
                        <div class="footer_rectangle pull-left footer_rectangle_new">
                            <img src="<?php
                            echo esc_url($small_img);
                            ?>" alt="<?php the_title(); ?>">

                        </div>


                        <div class="footer_events_descr pull-left">

                            <p><?php the_title(); ?></p>

                            <p><?php
                                $except = (get_post_meta(get_the_ID(), 'smalldescr', true)) ? (get_post_meta(get_the_ID(), 'smalldescr', true)) : get_the_excerpt();
                                $out = $except;
                                $out = iconv_substr($out, 0, 55, 'utf-8');
                                $out = preg_replace('@(.*)\s[^\s]*$@s', '\\1 ', $out);
                                echo wp_kses_post($out);


                                ?></p> <?php mycity_stars(5); ?>
                        </div>


                    </div>
                </a>

                <?php
            endwhile;
        endif;

        wp_reset_postdata();
        echo wp_kses_post($after_widget);
    }

    function update($new_instance, $old_instance)
    {
        $new_instance['title'] = !empty($new_instance['title']) ? esc_attr($new_instance['title']) :
            "";
        $new_instance['numbers'] = ((int)$new_instance['numbers']) ? $new_instance['numbers'] :
            2;

        return $new_instance;
    }


}


class mycity_twiter_Wigdet extends WP_Widget
{
    function __construct()
    {
        $args = array(
            'name' => esc_html__('MyCity Tweets', 'mycity'),
            'description' => esc_html__('It displays a list of tweets', 'mycity'),
            'classname' => 'mycity_twiter'
        );
        parent::__construct('mycity_twiter', esc_html__('MyCity Tweets', 'mycity'), $args);

    }

    /**
     * method to display in the admin
     *
     * @param $instance
     */
    function form($instance)
    {

        extract($instance);


        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"> <?php esc_html_e('Title:',
                    'mycity'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php if (isset($title)) {
                       echo esc_attr($title);
                   } ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('name')); ?>"> <?php esc_html_e('Name:',
                    'mycity'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('Name')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('Name')); ?>" type="text"
                   value="<?php if (isset($Name)) {
                       echo esc_attr($Name);
                   } ?>">
        </p>

        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('text')); ?>"> <?php esc_html_e('How many show Tweets?',
                    'mycity'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('text')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('text')); ?>" type="text"
                   value="<?php
                   if (isset($text)) {
                       echo esc_attr($text);
                   }
                   ?>">

        </p>


        <?php
    }

    /**
     * frontend for the site
     *
     * @param $args
     * @param $instance
     */
    function widget($args, $instance)
    {
        extract($args);
        extract($instance);
        // Create a filter to the other plug-ins can change them
        $title = sanitize_text_field(apply_filters('widget_title', $title));
        $before_widget = str_replace('class="', 'class=" twits_wid ', $before_widget);
        echo wp_kses_post($before_widget . "");

        echo wp_kses_post($before_title) . esc_attr($title) . wp_kses_post($after_title);


        global $wp_filesystem;

        //the existence check
        if (empty($wp_filesystem)) {
            require_once(ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }


        $fmr_upload_dir = wp_upload_dir();
        //We get the correct path to the file
        $fmr_filename = trailingslashit($fmr_upload_dir['basedir']) . $title . "twitcache.XML";

        //if it took more than an hour the update cache
        if (get_option("last_twitupdate") < time() - 3600) {
            $file = $wp_filesystem->get_contents('http://twitrss.me/twitter_user_to_rss/?user=' . $Name);
            update_option($title . "last_twitupdate", time());
            $wp_filesystem->put_contents($fmr_filename, $file, FS_CHMOD_FILE);

        } else {

            $file = $wp_filesystem->get_contents($fmr_filename);

        }


        if (strlen($file) > 10) {
            $movies = new SimpleXMLElement($file);


            for ($i = 0; $i < $text; $i++) {
                ?>
                <a href="<?php echo esc_url($movies->channel->item[$i]->link); ?>">
                    <div class="footer_events clearfix">
                        <p><?php echo esc_attr($movies->channel->item[$i]->title); ?></p>
                        <a href="<?php echo esc_url($movies->channel->item[$i]->link); ?>" class="tweets_a">@ <?php echo
                            esc_attr($Name); ?></a>
                    </div>
                </a>
                <?php
            }
        }


        echo wp_kses_post($after_widget);
    }

    function update($new_instance, $old_instance)
    {
        $new_instance['title'] = !empty($new_instance['title']) ? esc_attr($new_instance['title']) :
            "";
        $new_instance['text'] = ((int)$new_instance['text']) ? $new_instance['text'] : 2;

        return $new_instance;
    }


}

/*--------------------------------------*/

class mycity_popular_category_Wigdet extends WP_Widget
{
    function __construct()
    {
        $args = array(
            'name' => esc_html__('MyCity popular category', 'mycity'),
            'description' => esc_html__('It displays a list of popular_category', 'mycity'),
            'classname' => 'mycity_ptc'
        );
        parent::__construct('mycity_ptc', esc_html__('MyCity popular_category', 'mycity'), $args);

    }

    /**
     * method to display in the admin
     *
     * @param $instance
     */
    function form($instance)
    {

        extract($instance);


        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"> <?php esc_html_e('Title:',
                    'mycity'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php
                   if (isset($title)) {
                       echo esc_attr($title);
                   }
                   ?>">
        </p>
        <?php
    }

    /**
     * frontend for the site
     *
     * @param $args
     * @param $instance
     */
    function widget($args, $instance)
    {
        extract($args);
        extract($instance);
        // Create a filter to the other plug-ins can change them
        $title = sanitize_text_field(apply_filters('widget_title', $title));

        echo wp_kses_post($before_widget);
        echo wp_kses_post($before_title) . esc_attr($title) . wp_kses_post($after_title);
        ?>
        <ul class="places_cat">
            <?php
            $mycity_categories = get_categories("parent=0&taxonomy=places_categories&hide_empty=0");

            if (!isset($mycity_categories["errors"])) {
                foreach ($mycity_categories as $place_cat) {
                    $icon = get_option("fa_icon_" . esc_attr((int)$place_cat->term_id));
                    $class = (preg_match('/fmr/', $icon)) ? "fmr" : "fa";

                    ?>

                    <li><a href="<?php echo esc_url(get_term_link($place_cat)); ?>" class="<?php echo
                        esc_html($place_cat->slug); ?>"><i
                                class="<?php echo esc_html($class . ' ' . $icon); ?>"></i><?php echo
                            esc_html($place_cat->name); ?></a></li>
                    <?php

                }
            }
            ?>
        </ul>
        <?php
        echo wp_kses_post($after_widget);
    }
}

class mycity_popular_tags_Widget extends WP_Widget
{
    /**
     * Register the new widget
     */
    function __construct()
    {
        $args = array(
            'name' => esc_html__('MyCity Popular tags', 'mycity'),
            'description' => esc_html__('It displays a list of popular tags', 'mycity'),
            'classname' => 'mycity_pt'
        );
        parent::__construct('mycity_pt', esc_html__('MyCity Popular tags', 'mycity'), $args);
    }

    /**
     * method to display in the admin
     *
     * @param $instance
     */
    function form($instance)
    {
        extract($instance);


        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"> <?php esc_html_e('Title:',
                    'mycity'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php
                   if (isset($title)) {
                       echo esc_attr($title);
                   }
                   ?>">

        </p>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('text')); ?>"> <?php esc_html_e('How many show tags?',
                    'mycity'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('text')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('text')); ?>" type="text"
                   value="<?php
                   if (isset($text)) {
                       echo esc_attr($text);
                   }
                   ?>">

        </p>

        <?php
    }

    /**
     * frontend for the site
     *
     * @param $args
     * @param $instance
     */
    function widget($args, $instance)
    {
        global $MyCity_class, $wpdb;
        extract($args);
        extract($instance);
        // Create a filter to the other plug-ins can change them
        $title = apply_filters('widget_title', $title);
        echo wp_kses_post($before_widget);
        echo wp_kses_post($before_title) . esc_attr($title) . wp_kses_post($after_title);
        echo '<ul class="blog_cat clearfix">';


        $mycity_result = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM  `$wpdb->postmeta`  WHERE  meta_key=%s and meta_value !=''  ORDER BY meta_value DESC",
            '_tags'
        ));
        foreach ($mycity_result as $res) {

            $tag = explode(",", $res->meta_value);
            for ($i = 0; $i < count($tag); $i++) {
                $mycity_arry_tags[] = $tag[$i];
            }
        }
        $mycity_result = array_unique($mycity_arry_tags);
        sort($mycity_result);
        for ($j = 0; ($j < count($mycity_result) && $j < $text); $j++) {
            echo '<li><a href="' . esc_url(get_home_url('/') . '/places/?showas=list&#038;tags=' . esc_html($MyCity_class->icon_converter($mycity_result[$j]))) . '">' . esc_html($mycity_result[$j]) .
                '</a></li>' . "\n";

        }

        echo '</ul>';


        echo wp_kses_post($after_widget);

    }

    function update($new_instance, $old_instance)
    {
        $new_instance['text'] = ((int)$new_instance['text']) ? $new_instance['text'] : 3;

        return $new_instance;
    }
}


class mycity_footer_events_Wigdet extends WP_Widget
{
    /**
     * Register the new widget
     */
    function __construct()
    {
        $args = array(
            'name' => esc_html__('MyCity Footer events', 'mycity'),
            'description' => esc_html__('Displays a list of events in the footer', 'mycity'),
            'classname' => 'mycity_fw'
        );
        parent::__construct('mycity_fw', esc_html__('MyCity Footer events', 'mycity'), $args);
    }

    /**
     * frontend for the site
     *
     * @param $args
     * @param $instance
     */
    function widget($args, $instance)
    {
        global $MyCity_class, $wpdb;
        extract($args);
        extract($instance);
        $title = sanitize_text_field(apply_filters('widget_title', $title));
        $text = sanitize_text_field(apply_filters('widget_text', $text));
        echo wp_kses_post($before_widget);
        echo wp_kses_post($before_title) . esc_attr($title) . wp_kses_post($after_title);

        ?>
        <?php

        $MyCity_events_query = new WP_Query(array(
            'showposts' => 100,
            'post_type' =>
                'ajde_events'

        ));


        $transName = 'event_url';
        if (false === ($url_event = get_transient($transName))) {
            $all_events = $wpdb->prepare("SELECT ID FROM  `$wpdb->posts` WHERE `post_content` LIKE  %s AND  `post_status` =  'publish' LIMIT 0 , 1"
                , '%[add_eventon_list%');
            $all_events = $wpdb->get_results($all_events, ARRAY_A);
            $url_event = get_the_permalink($all_events[0]['ID']);
            set_transient($transName, $url_event, 60 * 60);

        } else {
            $url_event = get_transient($transName);
        }


        $i = 0;
        if ($MyCity_events_query->have_posts()) {
            while ($MyCity_events_query->have_posts()) {
                $MyCity_events_query->the_post();
                if ($i > (int)$text) {
                    break;
                }
                //date filter
                $start_date = get_post_meta(get_the_ID(), 'evcal_srow', true);
                $end_date = get_post_meta(get_the_ID(), 'evcal_erow', true);

                if ($end_date < time()) continue;
                $post_id = get_the_ID();

                $lat = trim(get_post_meta($post_id, 'evcal_lat', true));
                $lon = trim(get_post_meta($post_id, "evcal_lon", true));

                //get post id by cordinats
                $sql = $wpdb->prepare("SELECT post_id FROM `$wpdb->postmeta` WHERE `meta_key` = '_myfield' AND `meta_value` LIKE %s AND `meta_value` LIKE %s", '%' . $lat . '%', '%' . $lon . '%');


                $results = $wpdb->get_results($sql, ARRAY_A);

                $url = "#";

                //is isset post id
                if (!isset($results[0]["post_id"]) || empty($results[0]["post_id"])) {
                    $url = $url_event;
                } else {
                    //if this post not places
                    if (get_post_type($results[0]["post_id"]) != 'places') {
                        $url = $url_event;
                    } else {
                        $url = get_the_permalink($results[0]["post_id"]);
                    }

                }


                if ($i < (int)$text) {
                    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
                    $small_img = bfi_thumb($thumb[0], array('width' => 85, 'height' => 80));

                    ?>

                    <?php


                    ?>
                    <a href="<?php echo esc_url($url . '?showevent=' . get_the_ID()); ?>">
                        <div class="footer_events clearfix">

                            <div class="footer_rectangle pull-left footer_rectangle_new">
                                <img src="<?php
                                echo esc_url($small_img);
                                ?>" alt="<?php the_title(); ?>">
                            </div>
                            <div class="footer_events_descr pull-left">


                                <p>
                                    <?php the_title();
                                    ?></p>

                                <p><?php

                                    ?></p>
 
                                <p><?php

                                    if (date("d", $start_date) == date("d", $end_date)) {
                                        echo esc_attr(date("d", $start_date));
                                    } else {
                                        echo esc_attr(date("d", $start_date) . "-" . date("d", $end_date));
                                    }
                                    ?></p>

                                <p><?php
                                    if (date("d", $start_date) == date("d", $end_date)) {
                                        echo esc_attr(date("M", $start_date));
                                    } else {
                                        echo esc_attr(date("M", $start_date) . "&nbsp;&nbsp;&nbsp;&nbsp;" . date("M", $end_date));
                                    }
                                    ?></p>
                            </div>
                        </div>
                    </a>
                    <?php
                    $i++;
                }
            }
        }

        wp_reset_postdata();
        ?>

        <?php
        echo wp_kses_post($after_widget);
    }

    /**
     * method to display in the admin
     *
     * @param $instance
     */
    function form($instance)
    {
        extract($instance); //do variables from an array
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"> <?php esc_html_e('Title:',
                    'mycity'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php
                   if (isset($title)) {
                       echo esc_attr($title);
                   }
                   ?>">
        </p>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('text')); ?>"> <?php esc_html_e('How many show events:',
                    'mycity'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('text')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('text')); ?>" type="text"
                   value="<?php
                   if (isset($text)) {
                       echo esc_attr($text);
                   }
                   ?>">

        </p>
        <?php
    }

    /*
     * a method which, when the update of the widget is executed
     *
     * @param $new_instance
     * @param $old_instance
     * @return mixed
     */
    function update($new_instance, $old_instance)
    {
        $new_instance['title'] = !empty($new_instance['title']) ? esc_attr($new_instance['title']) :
            "";
        $new_instance['text'] = ((int)$new_instance['text']) ? $new_instance['text'] : 2;

        return $new_instance;
    }
}


?>