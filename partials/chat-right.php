<?php if (fmr_get_permalink_by_template("template-members.php")) { ?><div style='position:fixed;display:none' class="col-md-4 chat chatframe">
				<iframe style="width:100%;height:435px;outline:none;border:none;bottom:0;" id='fmr_chatframe' src=""></iframe>
			</div>
			<div class="chat_right">
			<?php
		      	$lovers = $wpdb->get_results($wpdb->prepare("SELECT * FROM dialog WHERE user1 = '%d'",get_current_user_id()));
					foreach ($lovers as $lover) {
						$ids[] = $lover->user2;
					}			
				$lovers = $wpdb->get_results(
                $wpdb->prepare(
                "SELECT * FROM dialog WHERE user2 = '%d'",get_current_user_id()
                ));
									
				if ($lovers) {
					foreach ($lovers as $lover) {
						if (!isset($unreaded[$lover->user1])) $unreaded[$lover->user1] = 0;
						if($lover->readed==0) $unreaded[$lover->user1]++;
						$ids[] = $lover->user1;
					}
					
				}
				
				if (!isset($ids) || get_current_user_id()==0) {$ids[]=15;}
				
				$lovers = get_users(array("include"=>$ids));
				
				global $wpdb;
				
				foreach ($lovers as $lover) {
				if (!isset($unreaded[$lover->ID])) $unreaded[$lover->ID] = 0;
				$fmr_url = fmr_get_permalink_by_template("template-dialog.php");
				if (!$fmr_url) continue;
				$fmr_url = fmr_addtoquery($fmr_url,"user2",(int)$lover->ID);
				$fmr_url = fmr_addtoquery($fmr_url,"xframe",1);
				?>
				<div class="img_chat_item">
					<span class='unreaded'><?php echo $unreaded[$lover->ID];?></span>
					
					<a href="#" class="ladda-button" data-color="red" data-style2="zoom-out" data-style="zoom-out" title="<?php echo esc_html($lover->user_nicename); ?>" onclick='ladda_gochat(this,"<?php echo esc_url($fmr_url); ?>");return false'> <span class="ladda-label"><?php echo get_avatar($lover->ID,60);?></span>	</a>
				</div>
				<?php } ?>
				
				<div class="add_chat_item">
					<a href="<?php echo esc_url(fmr_get_permalink_by_template("template-members.php")); ?>">
						<div class="chat_item_circle">
							<i class="fa fa-plus fa-2x"></i>
						</div>
					</a>
				</div>
		</div>		
		<?php } ?>