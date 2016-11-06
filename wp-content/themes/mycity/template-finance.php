<?php
/**
* Template Name: template-finance.php (Billing)
* Preview: http://geometry.vioo.ru/wp-content/themes/geometry_4/02.html
*/


global $mycity_bg_img,$MyCity;
$mycity_bg_img = mycity_get_thumbnail(get_the_id()); 


get_header();

if (!isset($mycity_content_width)) $mycity_content_width = 1100;
get_sidebar();


?>
<Script>
jQuery("#header").addClass("sticky");
</script>
<div class="header_section_popup"></div>
<div class="site-overlay"></div>

<div id="container">

	 <div class="item_wide_container">
        <div class="container">
            <div class="row">
                <div class="col-md-12 basic">
	<div class="balance"><br><br><br><br><br><br>
		<div class="container">
			<div class="row">
				<?php
					if (isset($_POST['placeid'])) {
						$balance = get_user_meta(get_current_user_id(),"balance",true);
						if ($_POST['paytarif']!="premium_tarif1"&&$_POST['paytarif']!="premium_tarif2") die("Hard Error 454");
						$planprice = get_theme_mod($_POST['paytarif']."price",20);
						if ($balance<$planprice) {
							?>
							<div class='alert alert-info'><?php esc_html_e("Insufficient gold My Lord :(","mycity"); ?></div>
							<?php
						} else {
							mycity_balance_change(get_current_user_id(),$planprice*-1,esc_html__("Buy premium for place #","mycity").(int)$_POST['placeid']);
							update_post_meta((int)$_POST['placeid'], "datapay", time());
							update_post_meta((int)$_POST['placeid'], "tarif", esc_attr($_POST['paytarif']));
						}
					}

					?>
				<div class="col-md-12">
					<div class="row">
					<div class="balance-head clearfix col-md-6">
						<?php
						$balance = get_user_meta(get_current_user_id(),"balance",true);
						if (!isset($balance)) update_user_meta(get_current_user_id(),"balance",0);
						?>
						<h1><?php esc_html_e("Your balance","mycity"); ?>: <span><?php echo (double)get_user_meta(get_current_user_id(),"balance",true); ?> USD</span></h1>
						<!-- 
						<div style='padding-top:20px;padding-bottom:20px;font-size:120%'>You has 100 USD left. </div>
						-->
						<div class=" clearfix" style='font-size:22px'>
						<?php esc_html_e("Top up the balance before buy premium listing","mycity"); ?>
						</div>
					</div>
						<div class="fill_up clearfix col-md-6" >
						<div class="fill-up-left">
							
							<div class="row"><form action="" id='fmfill' method=post>
							
								
								    <label for=""><?php esc_html_e("Amount","mycity"); ?>: <span>*</span></label>
									<input type="number" required min=1 max=11111 value='<?php if(isset($_POST['amount']))echo $_POST['amount']; ?>' name='amount' class="amount"/>

									 <label for=""><?php esc_html_e("Payment method","mycity"); ?>: </label>
								    <ul class="pay_list">
								    	<li><a href="#" class="visa"></a></li>
								    	<li><a href="#" class="bubbles"></a></li>
										<li class="pay-left"><input type='submit' name='' value='Pay' class="payvia"></li>
								    </ul>
								
								</form>
							</div>
						</div>
					</div>
					
					</div>
					
					<h3><?php esc_html_e("Your places","mycity"); ?></h3>
				    <table class='table table-condensed'>
						<thead>
							<td class="t_id">#</td>
							<td><?php esc_html_e("Place","mycity"); ?></td>
							<td><?php esc_html_e("Price Plan","mycity"); ?></td>
							<td><?php esc_html_e("Pay date","mycity"); ?></td>
							<td><?php esc_html_e("Change Plan","mycity"); ?></td>
							<td class="t_stat"><?php esc_html_e("Status","mycity"); ?></td>
						</thead>
						<?php 
						$mycity_args = array('post_type' => 'places',
                        'showposts' => 100,
                        'post__not_in' => $MyCity_class->get_empty_places(),
						'author' => get_current_user_id()
						);
						//print_R($mycity_args);
						$mycity_query_my2 = new WP_Query($mycity_args);
						   while ($mycity_query_my2->have_posts()) {
							$mycity_query_my2->the_post();
							?>
							<tr>
								<td><?php echo esc_attr(get_the_id());?></td>
								<td><?php the_title();;?></td>
								<td><strong><?php 
								$tarif = get_post_meta(get_the_ID(),"tarif",true); 
								if ($tarif=="premium_tarif1") echo get_theme_mod("premium_tarif1n","Monthly");
								if ($tarif=="premium_tarif2") echo get_theme_mod("premium_tarif2n","Yearly");
								if (!$tarif) echo esc_html__("Free","mycity");
								?></strong></td>
								<td><?php 
									$f=(int)get_post_meta(get_the_ID(),"datapay",true);
									if ($f>0) echo date(get_option('date_format'),get_post_meta(get_the_ID(),"datapay",true)); 
									?>
								</td>
								<td>
								<?php 
								if ($balance==0) {
									?><?php esc_html_e("Top up the balance before buy premium listing","mycity"); ?><?php
								} else {
								?>
								<form action="" method="post">
								<select name='paytarif'>
									<option value='premium_tarif1' rel='<?php echo get_theme_mod("premium_tarif1price",100); ?>'><?php echo get_theme_mod("premium_tarif1n","Monthly"); echo " ".get_theme_mod("premium_tarif1price",20);?>$ </option>
									<option value='premium_tarif2' rel='<?php echo get_theme_mod("premium_tarif2price",100); ?>'><?php echo get_theme_mod("premium_tarif2n","Yearly"); echo " ".get_theme_mod("premium_tarif2price",100); ?>$ </option>
								</select>
								<input type='hidden' class='form-control' name='placeid' value='<?php echo get_the_ID(); ?>'>
								<input type='submit' class='btn btn-primary' value='Pay'>
								</form>
								<?php } ?>
								</td>
								<td class="t_statys<?php  ?>"><i class="fa fa-circle"></i><strong><?php ?></strong></td>
							</tr>
							<?php } ?>
						
					</table>
					<?php
					if (isset($_POST['amount']) || isset($_POST['stripeToken'])) stripe_form($_POST['amount'],get_current_user_id());	
					if (isset($_POST['amount']) && !isset($_POST['stripeToken'])) {
					?>
					<script>
					jQuery(".stripe-button-el").click();
					</script>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	                    </div>
                </div>
            </div>
        </div>
    </div>
<script>function initialize_map(){}</script>
<script> 


jQuery('.page_info').css({
    height : jQuery(window).height() + 'px'
 });
jQuery(document).ready(function ($) {

    $(window).resize(function(){
        jQuery('.page_info').css({
          height : jQuery(window).height() + 'px'
        });
    });
    $(".page_info").css("visibility","visible");
    var catHeight = $('.blog_category').height();
    $('.blog_category').css({
    	'margin-top': ((catHeight/2)*(-1)) + 'px'
    })
	

});

   

</script>
	<?php
	get_footer();
	?>