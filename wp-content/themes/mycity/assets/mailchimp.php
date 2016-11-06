<?php


/**
 * This function via Ajax sends a post request to the server MailChimp
 */
function mycity_mailchimp_send()
{
	//get api kode
    preg_match("/(.*?)-(us..)/", sanitize_text_field(get_theme_mod('mailchimp_api_control')), $math);

    $api_key = $math[1];
    if (strlen($math[1] < 10)) {
        echo esc_attr(__('You have incorrect API key  ', 'mycity'));
        exit;
        die();

    }

    if (strlen($math[2]) < 1) {
        echo esc_attr(__('You have incorrect dc ', 'mycity'));
        exit;
        die();

    }
    $list_id = sanitize_text_field(get_theme_mod('mailchimpid_list_control'));
    if (strlen($list_id) < 5) {
        echo esc_attr(__('You have incorrect id list ', 'mycity'));
        exit;
        die();

    }


    $dc = $math[2]; // date center MailChimp
    $email = sanitize_email($_POST['mail']);
    $url = "https://$dc.api.mailchimp.com/2.0/lists/subscribe.json";

    $request = wp_remote_post( 	sanitize_text_field($url), array('body' => json_encode(array(
        'apikey' => sanitize_text_field($api_key),
        'id' =>sanitize_text_field($list_id),
        'email' => array('email' => $email),
    )),));

    $result = json_decode(wp_remote_retrieve_body($request));


    /*if have error then echo this*/
    if (isset($result->error)) {
        echo esc_attr($result->error);
    } elseif (isset($result->email)) {
        echo esc_html__('You subscribe as  ', 'mycity') . esc_attr($result->email);
    }

    exit;
    die();
}

add_action('wp_ajax_mycity_mailchimp_send', 'mycity_mailchimp_send'); // for logged in user
add_action('wp_ajax_nopriv_mycity_mailchimp_send', 'mycity_mailchimp_send'); // if user not logged in


?>