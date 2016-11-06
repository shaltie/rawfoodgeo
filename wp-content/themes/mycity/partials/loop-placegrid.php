<?php 
global $mycity_query_grid;

$io = 0;
//
if($mycity_query_grid->have_posts()) {
	// Start the loop. 
	while ($mycity_query_grid->have_posts()) {		
		$mycity_query_grid->the_post();

		$except = (get_post_meta(get_the_ID(), 'smalldescr', true)) ? (get_post_meta(get_the_ID(), 'smalldescr', true)) : get_the_excerpt();
		//get cordinats  	
		$cordinats = get_post_meta(get_the_ID(), '_myfield', true);
		preg_match("/(.*?),(.*?)$/", $cordinats, $math);
		if (!isset($math[1])) $math[1] = 0;
		if (!isset($math[2])) $math[2] = 0;
		$location_latitude  = $math[1];
		$location_longitude = $math[2]
		;
		if (!$location_latitude) continue;
		$img = esc_url( get_template_directory_uri() )."/img/pl3.jpg";	
		$small_img =esc_url(wp_get_attachment_url(get_post_meta(get_the_ID(), '_big_img', true)));
		$img = bfi_thumb( $small_img, array(  'width' => 340, 'height' =>300,  'crop' => true ));
		if(strlen($img) < 5) {
		$img = esc_url(get_template_directory_uri().'/img/start/promo_bg.jpg');
		}	
		$style = array("style_one","style_two","style_three");
		$io++;
		if ($io>2)$io=0;
		$new_style = esc_html($style[$io]);
		?>
		<!--place style one-->
		<div class="col-sm-6 col-md-4 inline-center">	
		<div class="places_list_my pg <?php  echo esc_html($new_style);?> " onclick="location.href='<?php  echo esc_url(get_the_permalink()); ?>';">
		<div class="p_cont">
	
		</div>
		
		<?php if($new_style == 'style_one')
		{ ?>
		<h1 class="grid_h1"><?php  the_title() ?></h1>
		<img src="<?php  echo esc_url($img);?>" alt="" class="hover-out">
	
		<div class="bleed hover-in">
			<div class="item_container">
				<div class="item">
					<div class="hover-down">
						<h1><?php  the_title() ?><span></span></h1>
						<p class="sub-heading">
							<?php   echo esc_html(str_replace(array('<p>','</p>'),array('',''),$except));   ?></p>
						</div>
					</div>
				</div>
			</div>
		<?php
		} else if ($new_style == 'style_two')
			{
			 
			?>
            
            	<h1 class="grid_h1"><?php  the_title() ?></h1>
            <img src="<?php  echo esc_url($img);?>" alt="" class="hover-out">
		
			<div class="bleed hover-in">
				<div class="item_container">
					<div class="item">
						<div class="hover-down">
							<h1><?php  the_title() ?><span></span></h1>
							<p class="sub-heading">
								<?php   echo esc_html(str_replace(array('<p>','</p>'),array('',''),$except));   ?></p>
						</div>
					</div>
				</div>
			</div><?php
			} else 
			{
			 
			?>
            	<h1 class="grid_h1"><?php  the_title() ?></h1>
            <img src="<?php  echo esc_url($img);?>" alt="" class="hover-out">
		
				<div class="bleed hover-in">
					<div class="item_container">
						<div class="item">
							<div class="hover-down">
								<h1><?php  the_title() ?><span></span></h1>
								<p class="sub-heading">
									<?php   echo esc_html(str_replace(array('<p>','</p>'),array('',''),$except));   ?></p>
							</div>
						</div>
					</div>
				</div>
				<?php
			} ?>
		</div>
		</div>
		

	

		
		<?php 
	// End the loop.

  
	}
    
} else { ?>
    					

<?php
}
?>