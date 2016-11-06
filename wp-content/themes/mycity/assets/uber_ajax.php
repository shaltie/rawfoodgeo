<?php
/**
 *  get uber price AJAX
 */
function mycity_uber_price()
{

    $textInput = get_post_meta(sanitize_text_field($_POST['post_id']), '_myfield', true);
    $arr_lat = explode(',', sanitize_text_field($textInput));
    $param = array(
        'start_latitude' => sanitize_text_field($_POST['latitude']),
        'start_longitude' =>sanitize_text_field( $_POST['longitude']),
        'end_latitude' => sanitize_text_field($arr_lat[0]),
        'end_longitude' =>sanitize_text_field( $arr_lat[1]));


    $out = "";
    foreach ($param as $key => $val) {
        $out .= "&$key=$val";
    }
    //url to get uber price
    $url = 'https://api.uber.com/v1/estimates/price?server_token=bzCQtwQbZQsG4DVuseWDQy_OGllXVUKmJ5dpTY7g';
    $url .= $out;
	

    $request = wp_remote_get(sanitize_text_field($url));

   
    if ( is_wp_error( $request ) ) {
     echo "Taxi service unavailable for your location :(";
     exit;
     die();
   }
    $res = json_decode($request['body']);
   
   
    if (isset($res->prices[0])) {
      
        echo esc_html("Taxi price min $" . sanitize_text_field($res->prices[0]->low_estimate ). " max $" .sanitize_text_field( $res->
            prices[0]->high_estimate) . ". ");
        $second = sanitize_text_field($res->prices[0]->duration);
        $minut = $second / 60;
        echo esc_html("Time travel " . (int)$minut . " minutes");
    }
    if (isset($res->message) || !isset($res->prices[0])) {
        echo get_theme_mod('uber_unavailable_message','Taxi service unavailable for your location :(');

    }
    exit;
    die();
}

add_action('wp_ajax_mycity_uber_price', 'mycity_uber_price'); // for logged in user
add_action('wp_ajax_nopriv_mycity_uber_price', 'mycity_uber_price'); // if user not logged in

?>