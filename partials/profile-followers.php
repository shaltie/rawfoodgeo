<!--Friends-->
<?php
global $mycity_profile;
?>
<div class="user_friends">
    <h4>
        <?php esc_html_e('Followers:', 'mycity'); ?>
    </h4>
    <div class="users_group">
        <?php
        $mycity_followers = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM follow WHERE user2 = '%d' AND user1 > 0",
            $mycity_profile->ID));
		
       
		$mycity_ids = array();
        if ($mycity_followers) {
            foreach ($mycity_followers as $mycity_lover) {
                $mycity_ids[] = $mycity_lover->user1;
            }
        }
		
        if (count($mycity_ids) > 0) {
            $mycity_lovers = get_users(array("include" => $mycity_ids));
            foreach ($mycity_lovers as $mycity_lover) {
                ?>
                <?php
                if ($mycity_profile->ID != $mycity_lover->ID)
				{
                    ?>
                    <a href="<?php echo mycity_get_member_permalink($mycity_lover->ID);?>" title='<?php echo esc_attr($mycity_lover->display_name); ?>' class="user_avatars">
                        <div class="user_go">
                            <i class="fa fa-link"></i>
                        </div>
						
						<img src="<?php 
						  $params = array('width' =>46, 'height' => 46);
						  $img_url=  bfi_thumb(mycity_get_url_by_avatar(get_avatar($mycity_lover->ID,46)), $params);
						  echo esc_url($img_url); ?>" alt="#">
			                 
                    </a>
                <?php 
				}
            }
        }
        ?>
    </div>
</div>
