<?php
/**
	* Template Name: Places_MAP.php minimal
 */


global $mycity_dditional, $wp_query;
$mycity_dditional = "Places_map";

if(isset($_GET['showas'])) {

if (isset($_GET['showas']) && sanitize_text_field($_GET['showas']) == 'list') $template = 'Places_list';
if (isset($_GET['showas']) && sanitize_text_field($_GET['showas']) == 'grid') $template = 'Places_grid';
if (isset($_GET['showas']) && sanitize_text_field($_GET['showas']) == 'minimal') $template = 'Places_map_minimal';

get_template_part($template);
} else {
	
$template = "Places_map2";
get_template_part($template);
}
?>