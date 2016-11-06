<?php
/**
 * Template Name: Members list (template-members-list)
 * Preview: 
 */

  global $mycity_dditional,$wp_query;
  $mycity_dditional = " Members_list";
 if (isset($_GET['user']) && $_GET['user'] == 'on') {
  $wp_query->query_vars['page'] = get_current_user_id();
 }

if (isset($wp_query->query_vars['page']) && $wp_query->query_vars['page']>0) {
    $mycity_profile = get_userdata(sanitize_text_field($wp_query->query_vars['page']));
    get_template_part("template", "profile");
} else {

    get_header();


?>

<?php
    get_sidebar();
?>

<!--navigation swipe-->
<div class="site-overlay"></div>
<div id="container">
	<div class="container page_info place_info">
		<div class="col-md-12 blog_category">
			<div class="open post_info single_h1">
				<h1 class='edited' id='edited__h1members'><?php esc_html_e( 'Blog', 'mycity' ); ?><span></span></h1>
				<p class='edited' id='edited__hdecmembers'><?php esc_html_e("Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel, aliquid!","mycity"); ?></p>
			</div>
		</div>  
	</div>
	<div class="item_wide_container">
		<div class="container">
			<div class="row">
				<div class="col-md-12 basic">
					<div class="members_in_wrap2">
						<?php
								
						$mycity_params = array(
							'orderby' => 'ID',  
							'order' => 'ASC',
							'number' => 18,
						
						);
						$mycity_uq = new WP_User_Query($mycity_params);
						global $mycity_uq;
						$mycity_style = get_theme_mod("members_memberliststyle", "s1");
						
						foreach ($mycity_uq->results as $GLOBALS['mycity_user']) {
							if ($mycity_style == "s1")
								get_template_part("partials/memberlist", "style1");
							if ($mycity_style == "s2")
								get_template_part("partials/memberlist", "style2");
							if ($mycity_style == "s3")
								get_template_part("partials/memberlist", "style3");
						}
						
						?>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
 /*----------------------Ajax scroll in categories-----------------------*/
   jQuery(document).ready(function ($) {

	var ajax = true;
	var scrH = $(window).height();
	var scrHP = $("#container").height();
	
	jQuery(window).scroll(function () {
		var scrollTop = jQuery(window).scrollTop();
		var ajaxheight = jQuery(".content").height() - $(window).height();        
		if (scrollTop > ajaxheight - 210 && ajax == true) {
			loadArticle();
			ajax = false;
		}
	});

	function loadArticle() {
	
		var inifcircular = jQuery("#inifiniteLoader #circularG");
		inifcircular.show();
		var ofset_mebers = jQuery(".members_item").length;

		jQuery.ajax({
			url : "<?php  echo esc_url( site_url() ); ?>/wp-admin/admin-ajax.php",
			type : 'POST',
			data : "action=mycity_infinitepaginate2&ofset_mebers=" + ofset_mebers + '',
			success : function (html) {
				ajax = true;
				jQuery(".members_in_wrap2").append(html); // This will be the div where our content will be loaded
			
			}
		});
		return false;
	}

});
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
<script>function initialize_map(){}</script>
<?php
    get_footer();
}
?>