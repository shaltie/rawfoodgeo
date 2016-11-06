<?php


global $mycity_bg_img,$MyCity_class,$mycity_dditional;
$mycity_bg_img = mycity_get_thumbnail(get_the_id()); 

if ( isset($_GET['ajax'])) { get_template_part("partials/post","body-wide"); die(); }

get_header();

if (!isset($mycity_content_width)) $mycity_content_width = 1100;


$mycity_dditional .= " small_header";

get_sidebar();


?>

<div class="header_section_popup"></div>
<div class="site-overlay"></div>

<div id="container">

	<div class="container page_info place_info">
		<div class="col-md-12 blog_category">
			<div class="open post_info single_h1">
				<h1><?php the_title(); ?><span></span></h1>
			     <?php
            
                    $short_desc = get_post_meta( $post->ID, 'mycity_short_description' , true ) ;
                    if(strlen(trim($short_desc)) > 2) {
                       echo "<p>". wp_kses_post($short_desc)."</p>";
                    } 
                    ?>
			</div>
		</div>  
	</div>

	<?php 
		get_template_part("partials/post","body-wide");
   
	?>
<?php  ?>

</div>
<script>
function initialize_map(){}
jQuery(document).ready(function ($) {
 $(document).on("click", '.button_substribe', function (e) {	
		e.preventDefault();
        $(".Subscribe_error").html(" ");
        var email = $("#subsribe .subsribe_email");
        email.removeClass('error');
        if(isValidEmailAddress(email.val())) {
        var mylada = Ladda.create( document.querySelector('.button_substribe' ));
        mylada.start();
		$.ajax({
			url : "<?php echo esc_url(site_url()); ?>/wp-admin/admin-ajax.php",
			type : 'POST',
			data : "action=mycity_mailchimp_send&mail="+ email.val() ,
			success : function (date) {
             $(".Subscribe_error").html(date);
              mylada.stop(); 	
			}

		});
        } else {
             email.addClass('error');
        }
	});
	});
    function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
		return pattern.test(emailAddress);
	}
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