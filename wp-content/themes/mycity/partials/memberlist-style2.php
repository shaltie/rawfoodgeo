<?php 
 $mycity_user = $GLOBALS['mycity_user'];
?>
<div class="col-md-4 col-sm-6">
	<div class="members_item clearfix">
		<div class="members_item_img">
			<?php  echo get_avatar( $mycity_user->ID, 128 ); ?>
            <div class="happy_f_block_hover">
				<div class="plus-hover-content">
					<i class="fa fa-plus fa-3x"></i>
				</div>
			</div>
		</div>
		<a href="<?php echo esc_url(mycity_get_member_permalink($mycity_user->ID));?>">
			<p class="member_name"><?php echo esc_html($mycity_user->display_name);?></p>
		</a>		
	</div>
	<div class="members_item_border visible-xs"></div>
</div>