<?php
if (get_post_meta($post->ID, 'coupontitle', true))
{
    ?>
	<center class='ttshowcase_rl_quote get_drink'>
	<h1 style='font-size:72px'><?php echo esc_html(get_post_meta(get_the_ID(), 'coupontitle', true)); ?></h1>
	<br><br>
	<div  class="cupon_code_new ">*******</div>
	<br><br>
	<?php 
	if (function_exists('ADDTOANY_SHARE_SAVE_KIT')) {
		ADDTOANY_SHARE_SAVE_KIT();
	} 
    ?>
	<div class='offer_descr' style='font-size:18px;width:50%;margin-top:50px'>
	<?php echo esc_html(get_post_meta(get_the_ID(), 'coupondescr', true)); ?>
	</div>
		<input id="cupon_code_place" class="dn_non" type="hidden" value=" <?php echo (get_post_meta($post->ID,'coupons',true)); ?>" />
	<br>
	
	</center>
<?php 
} ?>
