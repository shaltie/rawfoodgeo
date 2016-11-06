<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-6">
        <p class="p_top_header">  
            <?php
            $allowed_html = array(
                'a' => array('href' => array(), 'title' => array()),
                'b' => array(),
                'i' => array('class' => array()),
                'br' => array(),
                'strong' => array());

            echo wp_kses(get_theme_mod('mycity_top_header_left'), $allowed_html);
            ?>
        </p>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6">
    
    <?php if(get_theme_mod('langs_lang',false) == 1){ ?>
    	<div class="select-L">
    		<a href="#" class="selected-lang"><?php if (isset($_COOKIE['lang'])) {echo $_COOKIE['lang'];} else {echo "en";} ?></a>
    		<i class="fa fa-angle-down"></i>
    		<ul class="select-lang">
    			<a href="http://city1.wpmix.net">en</a>
    			<a href="http://fr.city1.wpmix.net" target="_blank">fr</a>
    			<a href="http://es.city1.wpmix.net" target="_blank">es</a>
    		</ul>
    	</div>
        <?php } ?>
        <p class="pull-right p_top_header">
            <?php
            $mycity_right_top = get_theme_mod('mycity_top_header_right', '[login]');

            if (is_user_logged_in()) {
                $mycity_link2login = "<a href='" . wp_logout_url() . "'>".esc_html__("Logout","mycity")."</a>";
            } else {
                $mycity_link2login = "<a href='".home_url()."/register'>".esc_html__("Login","mycity")."</a>";
            }
            $mycity_right_top = str_replace("[login]", $mycity_link2login, $mycity_right_top);
            $allowed_html = array(
                'a' => array('href' => array(), 'title' => array()),
                'b' => array(),
                'br' => array(),
                'strong' => array());

            echo wp_kses($mycity_right_top, $allowed_html);
            ?>
        </p>
       <?php 
          if (get_current_user_id()>0){ ?>
	
        
		<?php 
        }
		?>
        <div class="social_icons pull-right">
            <?php if (strlen(get_theme_mod('sotial_networks_control_VK')) > 8): ?>
                <a href="<?php echo esc_url(get_theme_mod('sotial_networks_control_VK')); ?>">
                    <i class="fa fa-vk"></i>
                </a>
            <?php endif; ?>
            <?php if (strlen(get_theme_mod('sotial_networks_control_facebook')) > 8): ?>
                <a href="<?php echo esc_url(get_theme_mod('sotial_networks_control_facebook')); ?>"
                   class="soc_fb">
                    <i class="fa fa-facebook"></i>
                </a>
            <?php endif; ?>
            <?php if (strlen(get_theme_mod('sotial_networks_control_instagram')) > 8): ?>
                <a href="<?php echo esc_url(get_theme_mod('sotial_networks_control_instagram')); ?>">
                    <i class="fa fa-instagram"></i>
                </a>
            <?php endif; ?>
            <?php if (strlen(get_theme_mod('sotial_networks_control_twitter')) > 8): ?>
                <a href="<?php echo esc_url(get_theme_mod('sotial_networks_control_twitter')); ?>">
                    <i class="fa fa-twitter"></i>
                </a>
            <?php endif; ?>
            <?php if (strlen(get_theme_mod('sotial_networks_control_google')) > 8): ?>
                <a href="<?php echo esc_url(get_theme_mod('sotial_networks_control_google')); ?>">
                    <i class="fa fa-google-plus"></i>
                </a>
            <?php endif; ?>
        </div>
        
    </div>
</div>