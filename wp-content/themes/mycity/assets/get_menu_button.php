<?php
/**
 * great new button hamburger
 */
function mycity_get_menu_button()
{    global $wpdb;
    ?>
       <?php
        if (strlen(get_theme_mod('mycity_top_header_left') > 0 || strlen(get_theme_mod('mycity_top_header_right')) >
            0)) {
            $class_new = "";
        } else {
            $class_new = "no_top_mycity_menu-btn";
        }
        ?>
    <div class="mycity_o-grid__item mycity_menu-btn <?php echo sanitize_html_class($class_new); ?>">

     
        <button class="c-hamburger c-hamburger--rot">
          <span>          
			<?php esc_html_e('toggle menu', 'mycity'); ?>          
          </span>
        </button>
    </div>

    <?php
}