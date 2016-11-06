<?php
/*
* Template Name: template-Profile.php
* Preview: 
*/

 global $mycity_profile,$mycity_dditional;
 $mycity_dditional = " members_profile";
 get_header();
 ?>
	
<?php 
get_sidebar();
?>

<div class="site-overlay"></div>
<div id="container">
<!--header-->

	<div class="container page_info members_profile">
		<div class="col_md_12 block_profile">
		<?php
            $mycity_params = array('width' =>100, 'height' => 128, 'crop' => true );
            $mycity_img_url=  @bfi_thumb(mycity_get_url_by_avatar(get_avatar((int)$mycity_profile->ID,128)), $mycity_params);
          ?>
           <img src="<?php echo esc_url($mycity_img_url); ?>" alt="">
              
              
		<h1><?php  echo esc_html(sanitize_user($mycity_profile->display_name)); ?></h1>

		<?php 
		$mycity_ids = mycity_get_visited($mycity_profile->ID);
		if (count($mycity_ids) == 0) {?>		
			<p class="lead">
			<?php
			$mycity_descr = get_the_author_meta('description', (int)$mycity_profile->ID);
			echo esc_html($mycity_descr);
			if (strlen($mycity_descr) == 0) { esc_html_e("User have no activity. Ask them to fill in information about yourself, leave reviews or follow the points places","mycity");}
			?>
			</p>		
		<?php
		} 
		?>
		</div>
	</div>

	<div class="container" id='maincn'>
		<?php  
		do_action( 'bp_before_member_body' );
		if (false) { 
		  	
		} else 
		{
		 
		?>
			
			<div class="row">
			<!-- Left column-->
				<div class="col-md-3 mobile_none sidebar">
				<!--avatar-->
				<div class="user_vis">
					<span><i class="fa fa-map-marker"></i>	
					<?php 
						$mycity_ids = mycity_get_visited($mycity_profile->ID);
                      
					?>
					</span>
					<div></div>
				</div>
				<?php
				get_template_part("partials/profile","followers");
				?>
				<!--user btns-->
					<div class="user_btn">
					<?php 
					if ($mycity_profile->ID!=get_current_user_id()) mycity_follow_button(get_current_user_id(),$mycity_profile->ID); 
					?>
				
					</div>
				</div>
			<!--content-->
			<div class="col-md-9 basic vp">
				<?php do_action( 'bp_before_member_body' ) ?>				
						
				<div id="map" class="map_user_visits"></div>
				
				<!--User info for mobile visible-->
				<div class="profile_mobile_vis">
				<!--Friends-->
					<div class="user_friends">
						<h4>
						<?php esc_html_e( 'Friends:', 'mycity' ); ?>
						</h4>
						<div class="users_group">
							<a href="02.html" class="user_avatars">
							<div class="user_go">
								<i class="fa fa-link"></i>
							</div>
							</a>
						</div>
					</div>
				</div>
				<?php
				get_template_part("partials/profile","reviews");
				?>
			</div>
		</div>
		<?php 
		}
		?>
	</div>
</div>

<script>

var
		mapObject,
		markers = [],
		markersData = {<?php 
		
		$mycity_categories=  get_categories("taxonomy=places_categories&hide_empty=0");
		$mycity_places_categories = array();
		foreach ($mycity_categories  as $mycity_place_cat) {
			$mycity_init_maps_point_by_term_slug = mycity_init_maps_point_by_term_slug(sanitize_text_field($mycity_place_cat->term_id),$mycity_ids);
			if (!$mycity_init_maps_point_by_term_slug) continue;
			
			ob_start();
			?>
			'<?php echo esc_html($mycity_place_cat->slug);?>': [<?php print_r($mycity_init_maps_point_by_term_slug);?>]
			<?php 
			$mycity_places_categories[] = ob_get_clean();
			
		}
	
   
		echo implode(",",$mycity_places_categories);
		
		?>
		};
		var global_scrollwheel = false;
		
		
		function initialize_map() {
			loadScript("<?php echo esc_url( get_template_directory_uri() ); ?>/js/infobox.js",after_load);
		}
		
		function after_load() {
			initialize_new();
		}
</script>

<?php 
get_footer();
?>