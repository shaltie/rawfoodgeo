<?php
function mycity_preg_datetime($matches)
{
    $matches[2] = strlen($matches[2]) == 1 ? "0" . $matches[2] : $matches[2];
    return "datetime='$matches[1]-$matches[2]-$matches[3]'";
}

function mycity_removeJSCSS($html)
{
    try {
        $html = str_replace("<script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?sensor=false&#038;ver=1.0'></script>", '', $html);
        return $html;
        preg_match_all("/<script.*?revslider.*?script>/", $html, $math);
        preg_match_all("/<link.*?revslider.*?\/>/", $html, $math2);
        $n1 = array($math[0][0], $math[0][1], $math2[0][0], $math3[0][0], $math4[0][0]);
        $n2 = array("", "", "");
        $str = str_replace($n1, "", $html);
        $str = str_replace("<link rel='stylesheet'", "<link rel='stylesheet' property='stylesheet' ", $str);
        $str = str_replace(array('<a name="ttform"></a>', 'for="_aditional_info_rating"', 'type="text/javascript"'), array('', '', ''), $str);
        $str = str_replace('role="search"', '', $str);
        $str = preg_replace_callback(
            '/datetime="(.*?)-(.*?)-(.*?)"/',
            mycity_preg_datetime($matches),
            $str
        );


        return $str;
    } catch (Exception $e) {
        return $html;
    }

}

/**
 * validate the date attribute
 * @param $m
 * @return string
 */
function mycity_mant_conver($m)
{
    if (strlen($m) == 1) {
        return "0" . $m;
    } else {
        return $m;
    }
}

function mycity_bufferStart()
{
    ob_start('mycity_removeJSCSS');
}

function mycity_bufferEnd()
{
    ob_end_flush();
}

/**
 * transfer scripts in the footer
 */
add_action('get_header', 'mycity_bufferStart', 999);
add_action('wp_footer', 'mycity_bufferEnd', 999);
remove_action('wp_head', 'print_emoji_detection_script', 7);
add_action('wp_footer', 'print_emoji_detection_script');
remove_filter('wp_head', 'add_eg_additional_inline_javascript');


function mycity_wpdocs_dequeue_script()
{
    wp_dequeue_script('evcal_gmaps');
}

add_action('wp_print_scripts', 'mycity_wpdocs_dequeue_script', 100);

function mycity_desregister_script_method()
{
    wp_deregister_script('evcal_gmaps');

}

add_action('wp_enqueue_scripts', 'mycity_desregister_script_method');


?>