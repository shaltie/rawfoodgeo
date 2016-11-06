<?php
/**
 * @param $css
 * @return mixed
 */
function mycity_color_hack($css)
{
    $css = str_ireplace("322F44", "33244A", $css);
    $css = str_ireplace("47A5F5", "009ECC", $css);
    $css = str_ireplace("45C3E8", "009ECC", $css);
    $css = str_ireplace("7CCB18", "AAC600", $css);
    $css = str_ireplace("62B50A", "AAC600", $css);
    $css = str_ireplace("006EC6", "0081DB", $css);
    $css = str_ireplace(array(
        "7CCB18",
        "1B2027",
        "191A22",
        "1F1C2D",
        "191A22"), array(
        "97C900",
        "030102",
        "011222",
        "011222"), $css);
    //green
    $css = str_ireplace("AAC600", "97C900", $css);
    //orange
    $css = str_ireplace(array(
        "FF9C00",
        "FFAC00",
        "FF5700",
        "FFCB00"), "FF9100", $css);
    //dark red
    $css = str_ireplace(array(
        "D82E26",
        "CC130A",
        "A1201A"), "D82E26", $css);
    //light red
    $css = str_ireplace(array(
        "E51616",
        "F54100",
        "E73931"), "FF9100", $css);
    return $css;
}
/**
 * Hex2RGB
 * @param $color
 * @return array
 */
function mycity_Hex2RGB($color)
{
    $color = str_replace('#', '', $color);
    if (strlen($color) != 6) {
        return array(
            0,
            0,
            0);
    }
    $mycity_rgb = array();
    for ($x = 0; $x < 3; $x++) {
        $mycity_rgb[$x] = hexdec(substr($color, (2 * $x), 2));
    }
    return $mycity_rgb;
}
?>