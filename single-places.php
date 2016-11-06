<?php
$showas = (isset($_GET['showas'])) ? sanitize_text_field($_GET['showas']) : ''; 

 $set = get_theme_mod("site_Identity_layout",'s2');
 if ( ($set == 's2' || $showas =='wide') && $showas !='boxed' ) {
  get_template_part("template","item-wide");  
}
else 
{get_template_part("template","item");
  	 
       }
?>