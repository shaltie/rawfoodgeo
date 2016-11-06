<?php  $mycity_user =$GLOBALS['mycity_user']; ?>

<div class="members_inline hidden-xs">
	<div class="container">
		<div class="members_inline_wrap clearfix">
			<div class="row">
				<div class="col-md-10">
					<div class="members_inline_item clearfix">
						<div class="memb_img">
                        
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
				</div>
				<div class="col-md-2 clearfix">
					
				</div>
			</div>    
		</div>
	</div>
</div>
	