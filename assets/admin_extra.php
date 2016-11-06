<?php
add_action('places_categories_add_form_fields',
    'mycity_places_categories_addimage', 10, 2);
add_action('places_categories_edit_form_fields',
    'mycity_places_categories_editimage', 10, 2);

/**
 * @return bool
 */
function mycity_places_categories_addimage()
{

    if (!isset($_GET['tag_ID'])) return true;


    global $_GET;
    $current_fa_icon = get_option("fa_icon_" . (int)sanitize_text_field ($_GET['tag_ID']));
    // this will add the custom meta field to the add new term page


    ?>
    <div class="form-field">
        <label><?php esc_html_e('Font awesome icon name', 'mycity'); ?></label>
        <input type="text" name="fa_icon" id='fa_icon' placeholder='fa-heart'>


        <a href='#' onclick='jQuery(".description1").toggle();return false'><?php esc_html_e('Show/hide icons',
                'mycity'); ?></a>
        <br /><br /><b><?php esc_html_e('Note:', 'mycity'); ?></b> <?php esc_html_e('Marker image will be generated automatically with Font Awesome library. But the quality is not the best. We recommend to create a marker in Photoshop and upload it on "Edit category page".',
            'mycity'); ?> <a href='#' onclick='jQuery("#help2").show();'><?php esc_html_e('Read more',
                'mycity'); ?></a>

        <div id='help2' class='db_non'>

            1. <a href='<?php echo esc_url(get_template_directory_uri()); ?>/img/09.marker.psd' target='_blank'>Download
                PSD template</a><br />
            2. <?php esc_html_e('Edit in photoshop', 'mycity'); ?><br />
            3. <?php esc_html_e('Save as PNG with transperent background', 'mycity'); ?>, 27x48px <br />
            4. <?php esc_html_e('On this page click "Edit" on category.', 'mycity'); ?><br />
            5. <?php esc_html_e('Upload png file in "Marker image" section.', 'mycity'); ?>


        </div>
        <p class="description1"  class='db_non'>

            <?php
            global $mycity_fa;
            foreach ($mycity_fa as $v) {
                if (file_exists(get_template_directory() . "/font/16/" . str_replace("fa-", "",
                        $v) . ".png")) { ?><i onclick='jQuery("#fa_icon").val("<?php echo esc_html($v); ?>")'
                                               class='fa font166 <?php echo
                    esc_attr($v); ?>'></i><?php
                }
            }
            ?>
        </p>
    </div>

    <?php
    if (!isset($_GET['tag_ID'])) $_GET['tag_ID'] = "bank";
    $imgmarker = get_theme_root() . '/wp-content/uploads/' . (int)esc_attr($_GET['tag_ID']) .
        ".png";
    if (!file_exists($imgmarker))
        $imgmarker = get_template_directory() . '/img/marker_blank.png';
    ?>

    <div class="form-field">
        <label><?php esc_html_e('Category color', 'mycity'); ?></label>
        <input type="text" name="fa_color" id='fa_color' placeholder=''>
    </div>

    <style>
        .fa:hover {
            color: green;
        }
    </style>
    <?php

}

/**
 * @param $tagid
 * @return string
 */
function mycity_get_marker_by_id($tagid)
{
    $upload_dir = wp_upload_dir();
    return $upload_dir['baseurl'] . "/" . $tagid . ".png";
}

/**
 *
 */
function mycity_places_categories_editimage()
{


    global $_GET;
    $current_fa_icon = get_option("fa_icon_" . (int)esc_attr($_GET['tag_ID']));
    if (!$current_fa_icon)
        $current_fa_icon = "cafe";
    $current_fa_color = get_option("fa_color_" . (int)esc_attr($_GET['tag_ID']));
    // this will add the custom meta field to the add new term page


    ?>
    <tr class="form-field form-required term-name-wrap">
        <th scope="row"><label for="fa_icon"><?php esc_html_e('Font awesome icon name',
                    'mycity'); ?></label></th>
        <td><input name="fa_icon" id="fa_icon" type="text" size="40" value='<?php echo
            esc_attr($current_fa_icon); ?>' required aria-required="true">

            <p class="description">
         
                <?php
                global $mycity_fa;
                foreach ($mycity_fa as $v) {
                    ?>
                    
					<i class="extra_admin_1 fa <?php echo esc_attr($v); ?>"
                    onclick='jQuery("#fa_icon").val("<?php echo esc_html($v); ?>");jQuery(this).css("color","lightgreen")'></i>
				<?php
                }
                ?>
			</p>
            <br /> <br />
            <a href="#" id="my_fmr_icon_show"><?php echo esc_html('trendy icon name','mycity'); ?></a>
        <p id="fmr_icons" class="description" style="display: none;">
                 <b><?php echo esc_html('trendy icon name','mycity'); ?> </b> <br />  <?php
                global $mycity_fmr_icon;
            $exclude = array('fmr-icon-114','fmr-icon-268','fmr-icon-2412','fmr-icon-3516','fmr-icon-4412','fmr-icon-69','fmr-icon-340',
                'fmr-icon-483','fmr-icon-2103','fmr-icon-2104','fmr-icon-2104','fmr-icon-4519');
                foreach ($mycity_fmr_icon as $v) {
                    if(in_array($v,$exclude)) continue;

                  ?>
       
					<i class="extra_admin_1 <?php echo esc_attr("fmr ". $v); ?>"
                    onclick='jQuery("#fa_icon").val("<?php echo esc_html($v); ?>");jQuery(this).css("color","lightgreen")'> <?php  ?></i>
				<?php
               
                }
                ?>
			</p>
            
            <?php
            
            /*
                  <?php
                 
               $mycity_fmr_icon_2 = array(
                    'Human organs' => explode(',','fmr-icon-449,fmr-icon-432,fmr-icon-4410,fmr-icon-433,fmr-icon-434,fmr-icon-4411,fmr-icon-435,fmr-icon-436,fmr-icon-437,fmr-icon-438,fmr-icon-439,fmr-icon-42,fmr-icon-4310,fmr-icon-4311,fmr-icon-4312,fmr-icon-4313,fmr-icon-422,fmr-icon-4314,'),
       
                );
                 ?>
                 <b><?php echo esc_html('trendy icon name','mycity'); ?> </b> <br />  <?php
                global $mycity_fmr_icon;
                ?>
           
                
             <?php   
              $j =0;            
                foreach ( $mycity_fmr_icon_2  as $k=>$val) {
                 ?>
                 <span><?php echo esc_html($k); ?></span><br />
                 <?php
                    foreach($val as $v) {
                        ?>
                        				<i class="fmr extra_admin_1 fa <?php echo esc_attr( $v); ?>"
                    onclick='jQuery("#fa_icon").val("<?php echo esc_html($v); ?>");jQuery(this).css("color","lightgreen")'><?php echo  $j; ?> </i>
					
					
                        <?php
                          $j++;
                    }
                  
                    ?>


                <?php
                }
                ?>
                <p></p>
                
            
            
            */ ?>
           <script>
           jQuery("#my_fmr_icon_show").click(function(e){
                e.preventDefault();
                 jQuery("#fmr_icons").toggle();
           });
          
           </script>                         
        </td>
    </tr>

    <tr class="form-field form-required term-name-wrap">
        <th scope="row"><?php esc_html_e('Map marker icon',
                'mycity'); ?></th>
        <td>
            <img src='<?php echo esc_url(mycity_get_marker_by_id($_GET['tag_ID'])); ?>'>
            <input name="fa_icon_image" id="fa_icon" type="file" size="40" aria-required="true">
        </td>
    </tr>

    <tr class="form-field form-required term-name-wrap">
        <th scope="row"><label for="fa_color"><?php esc_html_e('Color', 'mycity'); ?></label></th>
        <td><input type="text" name="fa_color" value='<?php echo esc_html($current_fa_color); ?>' id='fa_color'
                   placeholder=''>
        </td>
    </tr>
    <script>
        jQuery("#edittag").attr("enctype", "multipart/form-data");
    </script>
    <?php

}


add_action('admin_menu', 'mycity_add_sms_register_admin_menu');

function mycity_add_sms_register_admin_menu()
{
    add_theme_page('SMS registration', 'SMS Registration', 'manage_options',
        '345345345', 'mycity_add_sms_register_admin_menu_options');

}

function mycity_add_sms_register_admin_menu_options()
{
    if (!current_user_can('manage_options')) {
        wp_die(esc_html__('You do not have sufficient permissions to access this page.',
            'mycity'));
    }
    global $_POST;

    if (isset($_POST['sms_api_emeail'])) {
        update_option("sms_api_emeail", sanitize_text_field($_POST['sms_api_emeail']));
    }
    if (isset($_POST['sms_api_hash'])) {
        update_option("sms_api_hash", sanitize_text_field($_POST['sms_api_hash']));
    }
    if ($_POST) {
        update_option("allow_sms_registration", sanitize_text_field($_POST['allow_sms_registration']));
    }

    echo '<div class="wrap ">';
    ?>
	<h2><?php esc_html_e("Registration by SMS","mycity");?></h2>
    <form class="admin_form_5" action=''  method='post'>
        <label><input type='checkbox' name='allow_sms_registration' <?php if (get_option
                ('allow_sms_registration') == 1
            )
                echo "checked"; ?> value='1'> <?php esc_html_e('Allow SMS registration',
                'mycity'); ?> </label>
        <br /><br />
        <?php esc_html_e('Go to control.txtlocal.co.uk and register; ', 'mycity'); ?>
        <br /><br />

        <?php esc_html_e('Your', 'mycity'); ?> <a rhef='control.txtlocal.co.uk'
                                            target=_blank><?php esc_html_e('control.txtlocal.co.uk',
                'mycity'); ?>/</a>
        <b><?php esc_html_e('API email:', 'mycity'); ?></b>
		<br />	
        <input type='text' name='sms_api_emeail' value='<?php echo esc_attr(get_option("sms_api_emeail")); ?>'
               class='form-control'><br />


        <b><?php esc_html_e('Your API Hash:', 'mycity'); ?></b>
		<br />
        <input type='text' name='sms_api_hash' value='<?php echo esc_attr(get_option("sms_api_hash")); ?>'
               class='form-control'>
        <?php esc_html_e('From', 'mycity'); ?> https://control.txtlocal.co.uk/docs/ (<?php esc_html_e('Your API Hash',
            'mycity'); ?>)

<br /><br />
        <input type='submit' class='btn btn-primary' value='Save settings'>
    </form>
    <?php
    echo '</div>';
}


//Additional fields

function mycity_additional_fields_menu()
{
    add_theme_page('Member additional fields', 'Member additional fields',
        'manage_options', '345345377', 'mycity_additional_fields_menu_options');
    add_theme_page('Stripe.com payment gateway', 'Stripe.com payment gateway',
        'manage_options', '345345388', 'mycity_additional_fields_menu_stripe');

}

function mycity_additional_fields_menu_stripe()
{

    ?>
    <div class='wrap'>
        <form action='' method='post'>
			<input type="text" name="sripe_key" value="">
        </form>
    </div>
    <?php
}

function mycity_additional_fields_menu_options()
{
    if (!current_user_can('manage_options')) {
        wp_die(esc_html__('You do not have sufficient permissions to access this page.',
            'mycity'));
    }

    global $_POST;
    ?>
<?php
	

    ?>
    <br />

    <a onclick='jQuery("#fatable").toggle()'><?php esc_html_e('Show Font Awesome Icons',
            'mycity'); ?></a>

    <?php
    global $mycity_fa;
    echo '<table  class="db_non" id="fatable">';
    foreach ($mycity_fa as $icon) {
        echo '<tr><td><i class="fa ' . esc_attr($icon) . '"></i></td><td>' . esc_attr($icon) . '</td></tr>';
    }
    echo '</table></div>';

}

function mycity_register_my_setting()
{
    register_setting('my_options_group', 'my_option_name', 'intval');
}

add_action('admin_init', 'mycity_register_my_setting');


/* удалить !!!! */
add_action( 'admin_footer', 'my_dashboard_widget_display33333' );

function my_dashboard_widget_display33333() {
    ?>
		<style>
			.mat_wrapper_popup {
			background: rgba(0,0,0,.5);
			position: fixed;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			opacity: 0;
			z-index: -1000;
			-webkit-transition: all .3s ease-out;
			-moz-transition: all .3s ease-out;
			-o-transition: all .3s ease-out;
			transition: all .3s ease-out;
		}

		.mat_popup {
			background: #fff;
			width: 100%;
			max-width: 500px;
			position: absolute;
			left: 50%;
			margin-left: -270px;
			top: 50%;
			margin-top: -200px;
			text-align: center;
			padding: 25px 20px;
			z-index: 1000;
			opacity: 0;
		}

		.mat_close {
			width: 20px;
			height: 20px;
			background: #000;
			position: absolute;
			top: 0;
			right: 0;
			cursor: pointer;
		}

		.db_open_popup {
			opacity: 1;
			z-index: 900;
		}

		.mat_popup.db_open_popup p {
			font-size: 22px;
			margin: 0;
		}

		.mat_popup.db_open_popup span {
			font-size: 18px;
			display: block;
		}

		.mat_popup.db_open_popup textarea {
			width: 75%;
			height: 100px;
			margin: 10px 0;
			padding: 10px;
		}

		.mat_popup.db_open_popup form a{
			background-image: url(http://mycity.wiki/img/soc_sprite.png);
			border: none;
			height: 34px;
			padding: 0;
			cursor: pointer;
			margin: 0 5px;
			display: inline-block;
		}

		.fb {
			width: 126px;
			background-position: 0 bottom;
		}

		.tw {
			width: 107px;
			background-position: 0 -36px;
		}

		.gl {
			width: 111px;
			background-position: 0 top;
		}
	</style>
	
		<div class="mat_wrapper_popup"></div>
	<div class="mat_popup">
		<p>
			Your copy not activated, for
			activation write<br> your review
			and repost it on:
		</p><br>
		<form action="">
			<span>Step 1, write what your review</span>
			<textarea name="" id="sdfsdf" onchange='aaref();' placeholder="I like mycity theme for...."></textarea>
			<span>Step 2, select where to send:</span><br>
			<a href="#" onclick="if(!jQuery('#sdfsdf').val()){jQuery('#sdfsdf').focus();return false;}hideokno()" id='xxx1' class="fb"></a>
			<a href="#" onclick="if(!jQuery('#sdfsdf').val()){jQuery('#sdfsdf').focus();return false;}hideokno()" id='xxx2' class="tw"></a>
			<a href="#" onclick="if(!jQuery('#sdfsdf').val()){jQuery('#sdfsdf').focus();return false;}hideokno()" id='xxx3' class="gl"></a>
			<span>
				<br>
				This window will be hide after Step 2. 
			</span>
		</form>
		
	</div>
	
	
	<script>
	function aaref() {
		jQuery("#xxx1").attr("href","https://www.facebook.com/sharer.php?u=http://standart-it.com&text="+jQuery("#sdfsdf").val());
		jQuery("#xxx2").attr("href","https://twitter.com/intent/tweet?url=http://standart-it.com&text="+jQuery("#sdfsdf").val());
		jQuery("#xxx3").attr("href","https://plus.google.com/share?url=http://standart-it.com&text="+jQuery("#sdfsdf").val());
	}
	
	function showokno1() {
		jQuery('.mat_wrapper_popup, .mat_popup').addClass('db_open_popup');
	}
	
	function getCookie11(name) {
		var matches = document.cookie.match(new RegExp(
			"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$') + "=([^;]*)"
			));
		return matches ? decodeURIComponent(matches[1]) : undefined;
	}

	function setCookie11(name, value, options) {
		options = options || {};

		var expires = options.expires;

		if (typeof expires == "number" && expires) {
			var d = new Date();
			d.setTime(d.getTime() + expires * 1000);
			expires = options.expires = d;
		}
		if (expires && expires.toUTCString) {
			options.expires = expires.toUTCString();
		}

		value = encodeURIComponent(value);

		var updatedCookie = name + "=" + value;

		for (var propName in options) {
			updatedCookie += "; " + propName;
			var propValue = options[propName];
			if (propValue !== true) {
				updatedCookie += "=" + propValue;
			}
		}

		document.cookie = updatedCookie;
	}



	if (!getCookie11("lastshare")) {
		var options = new Object;
		options.expires = 300;
		nd = new Date();
		setCookie11("lastshare", nd.getTime(), options);
	} else {
		nd2 = new Date();
		lr=nd2.getTime()-getCookie11("lastshare");
		//alert(lr);
		if (lr>86400000*60) {
			showokno1();
		}
	}

	function hideokno() {
		nd = new Date();
		setCookie11("lastshare", nd.getTime(), options);
		//jQuery('.mat_wrapper_popup, .mat_popup').hide();
	}
</script>

	<?
}

?>
