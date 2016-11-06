<?php
/**
 * Created by PhpStorm.
 * User: Pro
 * Date: 08.06.2016
 * Time: 14:12
 */

function mycity_scrape_instagram($username)
{

    $username = strtolower($username);
    $username = str_replace('@', '', $username);

    if (false === ($instagram = get_transient('instagram-a5-' . sanitize_title_with_dashes($username)))) {

        $remote = wp_remote_get('http://instagram.com/' . trim($username));

        if (is_wp_error($remote))
            return new WP_Error('site_down', esc_html__('Unable to communicate with Instagram.', 'wp-instagram-widget'));

        if (200 != wp_remote_retrieve_response_code($remote))
            return new WP_Error('invalid_response', esc_html__('Instagram did not return a 200.', 'wp-instagram-widget'));

        $shards = explode('window._sharedData = ', $remote['body']);
        $insta_json = explode(';</script>', $shards[1]);
        $insta_array = json_decode($insta_json[0], TRUE);

        if (!$insta_array)
            return new WP_Error('bad_json', esc_html__('Instagram has returned invalid data.', 'wp-instagram-widget'));

        if (isset($insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'])) {
            $images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
        } else {
            return new WP_Error('bad_json_2', esc_html__('Instagram has returned invalid data.', 'wp-instagram-widget'));
        }

        if (!is_array($images))
            return new WP_Error('bad_array', esc_html__('Instagram has returned invalid data.', 'wp-instagram-widget'));

        $instagram = array();

        foreach ($images as $image) {

            $image['thumbnail_src'] = preg_replace('/^https?\:/i', '', $image['thumbnail_src']);
            $image['display_src'] = preg_replace('/^https?\:/i', '', $image['display_src']);

            // handle both types of CDN url
            if ((strpos($image['thumbnail_src'], 's640x640') !== false)) {
                $image['thumbnail'] = str_replace('s640x640', 's160x160', $image['thumbnail_src']);
                $image['small'] = str_replace('s640x640', 's320x320', $image['thumbnail_src']);
            } else {
                $urlparts = wp_parse_url($image['thumbnail_src']);
                $pathparts = explode('/', $urlparts['path']);
                array_splice($pathparts, 3, 0, array('s160x160'));
                $image['thumbnail'] = '//' . $urlparts['host'] . implode('/', $pathparts);
                $pathparts[3] = 's320x320';
                $image['small'] = '//' . $urlparts['host'] . implode('/', $pathparts);
            }

            $image['large'] = $image['thumbnail_src'];

            if ($image['is_video'] == true) {
                $type = 'video';
            } else {
                $type = 'image';
            }

            $caption = __('Instagram Image', 'wp-instagram-widget');
            if (!empty($image['caption'])) {
                $caption = $image['caption'];
            }

            $instagram[] = array(
                'description' => $caption,
                'link' => trailingslashit('//instagram.com/p/' . $image['code']),
                'time' => $image['date'],
                'comments' => $image['comments']['count'],
                'likes' => $image['likes']['count'],
                'thumbnail' => $image['thumbnail'],
                'small' => $image['small'],
                'large' => $image['large'],
                'original' => $image['display_src'],
                'type' => $type
            );
        }

        // do not set an empty transient - should help catch private or empty accounts
        if (!empty($instagram)) {
            $instagram = base64_encode(serialize($instagram));
            set_transient('instagram-a5-' . sanitize_title_with_dashes($username), $instagram, apply_filters('null_instagram_cache_time', HOUR_IN_SECONDS * 2));
        }
    }

    if (!empty($instagram)) {

        return unserialize(base64_decode($instagram));

    } else {

        return new WP_Error('no_images', esc_html__('Instagram did not return any images.', 'wp-instagram-widget'));

    }
}


function mycity_images_only($media_item)
{

    if ($media_item['type'] == 'image')
        return true;

    return false;
}


function mycity_get_insta()
{

//var_dump($_GET);
    $limit = empty($instance['number']) ? 100 : $instance['number'];
    $size = empty($instance['size']) ? 'large' : $instance['size'];
    $id = sanitize_text_field($_GET['id']);
    $name =get_post_meta($id, 'instaid',true);
//the_luxury_life
    $media_array = mycity_scrape_instagram($name);
    if (is_wp_error($media_array)) {

        echo wp_kses_post($media_array->get_error_message());

    } else {

        // filter for images only?
        if ($images_only = apply_filters('wpiw_images_only', FALSE)) {
            $media_array = array_filter($media_array, array($this, 'images_only'));
        }

        // slice list down to required limit
        $media_array = array_slice($media_array, 0, $limit);

        // filters for custom classes

       
        $array_img = array();
        $i = 0;
        // var_dump($media_array);

        if ($media_array ) {
            foreach ($media_array as $item) {
                // copy the else line into a new file (parts/wp-instagram-widget.php) within your theme and customise accordingly
                $array_img[$i]['url'] = $item[$size];


                $i++;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($array_img);



    }
    exit;
    die();
}

add_action('wp_ajax_mycity_get_insta', 'mycity_get_insta'); // for logged in user
add_action('wp_ajax_nopriv_mycity_get_insta', 'mycity_get_insta'); // if user not logged in



