<?php
global $post;
$mycity_follow = $wpdb->get_results($wpdb->prepare(
    "SELECT * FROM follow WHERE user2 = '-%d'",
    $post->ID
));

foreach ($mycity_follow as $k => $mycity_follower) {
    $mycity_first_followers[] = $mycity_follower->user1;
}

$mycity_users = null;
if (count($mycity_follow) > 0) {
    $mycity_users = get_users("include=" . implode(",", $mycity_first_followers));

}
$mycity_total_other = 0;
$mycity_n = 0;
if ($mycity_users) 
{ ?> 
  <!--Check in-->
    <div class="check_in">
    <div>    <?php 
    

    
    $i = 0;
        foreach ($mycity_users as $user) {
            if ($i++ > 7) {
                $mycity_total_other++;
                continue;
            }
            if ($mycity_n > 0) {
                $mycity_users_str[] = "<a href='" . esc_url(mycity_get_member_permalink($user->ID))."'>" . esc_attr($user->display_name) . "</a>";
            } else {
                $mycity_users_str[] = "<a href='" . esc_url(mycity_get_member_permalink($user->ID))."'>" . esc_attr($user->display_name) . "</a>";
            }
            
            
            $mycity_params = array('width' =>66, 'height' => 66, 'crop' => true );
            $mycity_img_url=  bfi_thumb(mycity_get_url_by_avatar(get_avatar($user->ID,66)), $mycity_params);
            $mycity_users_img[] = ' <a href="'.esc_url(mycity_get_member_permalink($user->ID)).'" class="user_avatars">
			<div class="user_go">
			<i class="fa fa-link"></i>
			</div>
			<img src="'. sanitize_text_field($mycity_img_url).'" alt="">
			</a>';
            $mycity_n++;
        }
		
        echo @implode(", ",$mycity_users_str) . (($mycity_total_other > 0) ? esc_html(sprintf(_n(' and %s other likes this place',' and %s other likes this place',$mycity_total_other,"mycity"),$mycity_total_other)) : "");
        ?>
        <div class="users_group" data-f="hggggg">
            <?php echo @implode("", $mycity_users_img); ?>
        </div>
    </div>
</div>
<?php
} ?>