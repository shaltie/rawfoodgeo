<?php
$mycity_user = $GLOBALS['mycity_user'];

?>
<div class="col-sm-3 col-md-3 col-lg-2 text-center">
    <div class="members_item">
        <a href="<?php echo esc_url(mycity_get_member_permalink($mycity_user->ID));?>" class="a_members">
 
            <?php
            $mycity_params = array('width' =>129, 'height' => 129, 'crop' => true );         
            $mycity_img_url= bfi_thumb(mycity_get_url_by_avatar(get_avatar((int)$mycity_user->ID,66)), $mycity_params);
            $mycity_img_url=  (strlen($mycity_img_url) > 8) ? $mycity_img_url :  mycity_get_url_by_avatar(get_avatar((int)$mycity_user->ID,128))
           ?>
           <img src="<?php echo esc_url($mycity_img_url); ?>" width="128" height="128" alt="">
           
            <div class="happy_f_block_hover">
                <div class="plus-hover-content">
                    <i class="fa fa-plus fa-3x"></i>
                </div>
            </div>
        </a>
        <a href="<?php echo esc_url(mycity_get_member_permalink($mycity_user->ID));?>">
            <p class="member_name"><?php echo esc_html($mycity_user->display_name); ?></p>
        </a>
      
        <p class="member_year"><?php mycity_get_visited($mycity_user->ID); ?> </p>
    </div>
</div>