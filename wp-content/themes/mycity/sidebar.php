<!--navigation swipe sidibar-->
<nav  class="pushy pushy-left wtr">
    <?php 
    global $MyCity_class;
    get_template_part("partials/sidebar", "avatar_form"); 
    $mycity_menus = get_terms('nav_menu', array('hide_empty' => true));
    $mycity_cur = 999999;
    foreach ($mycity_menus as $k => $v) {
        if ($mycity_cur > $v->term_id) {
            $mycity_cur = $v->term_id;
            $mycity_ownmenu = $k;
        } else {
			
		}
    }
	if (!isset($mycity_ownmenu)) $mycity_ownmenu = "";
	
    if (isset($mycity_menus[$mycity_ownmenu]->term_id)) $mycity_menu_items = @wp_get_nav_menu_items($mycity_menus[$mycity_ownmenu]->term_id);
	
    $mycity_arr_menu = array();
    if (isset($mycity_menu_items) && count($mycity_menu_items) > 1) {
        foreach ($mycity_menu_items as $key => $item) :
            $mycity_arr_menu[] = $item->title;
        endforeach;
    }

    if (count($mycity_arr_menu) > 1) {
        $mycity_menu_items = wp_get_nav_menu_items($mycity_menus[$mycity_ownmenu]->term_id);
    ?>
        <ul class="side_menu">
            <?php
            $mycity_menu_list = "";
            foreach ((array )$mycity_menu_items as $key => $menu_item) {
                $title = sanitize_text_field($menu_item->title);
                $url = sanitize_text_field($menu_item->url);
                if (strstr($title, "fa")) {
                    $title = $MyCity_class->get_fa_icons($title, true);                
                }
                else
                {
                    $title = '<i class="fa fa-question"></i>' . $title;
                }                
                $mycity_menu_list .= '<li><a href="' . esc_url($url) . '">' . $title . '</a></li>';
            }
            print_r($mycity_menu_list);
            ?>
        </ul>
    <?php

    } 
    elseif (current_user_can('administrator'))
    {
        get_template_part("partials/sidebar", "warning");
    }
    if (is_active_sidebar('left_menu_widget')) { ?>
        <div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
            <?php
            ob_start();
            @dynamic_sidebar('left_menu_widget');
            $mycity_filter = ob_get_clean();
            $mycity_filter = str_replace('input type="submit"', 'input type="submit" class="btn btn-primary"', $mycity_filter);
            $mycity_filter = str_replace('input type="text"', 'input type="text" class="form-control"', $mycity_filter);
            global $MyCity_class;
            echo $MyCity_class->mycity_esc_js($mycity_filter);
            ?>
            <div class="sticky"></div>
        </div><!-- #primary-sidebar -->
    <?php }  elseif(current_user_can('administrator')){?>
     <ul class="side_menu">
    	<li>
	       	<a><?php echo esc_html(__('  Go to to Design- > Widgets and add  widget by adding them to the Left menu area panel section',
        'mycity'));?>  
		  </a>
        </li>
    </ul>

    <?php } ?>
</nav>

        