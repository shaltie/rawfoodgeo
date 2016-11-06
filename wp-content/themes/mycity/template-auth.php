<?php
    /**
    * Template Name: template-auth.php
    * Preview: http://chat.vioo.ru/feed.html
    */
    
    if (get_current_user_id()>0) {
    	//alrady logged in
    }
    
    get_header();
    ?>
<?php 
    get_sidebar();
    ?>
<div class="top_promo_block">
    <div class="auth_container">
        <div class="container">
            <div class="row">
                <div class="hidden-sm col-sm-6 col-md-7">
                    <div class="auth_descr hidden-xs">
                        <a href="#" class="menu_xs hidden-md hidden-sm hidden-lg">
                        <i class="fa fa-bars fa-2x"></i>
                        </a>
                        <h2>
                            <?php
                                $t = explode(":", get_the_title());
                             
                                ?>
                            <strong>
                            <?php  
                                echo esc_html($t[0]); 
                                                    ?>
                            </strong>
                            <span>:</span>
                            <span class="yellow"> 
                            <?php 
                                echo esc_html($t[1]);
                             ?>
                            </span>
                        </h2>
                        <p>
                            <?php if (have_posts()): while (have_posts()): the_post(); ?>
                            <?php     $mycity_str = get_the_content();
                                $mycity_content = preg_replace ('/\[.*?\]/is', '', $mycity_str); 
                                $mycity_content_count = str_replace(' ','',$mycity_content);
                                $mycity_content_count = str_replace("\r", "",  $mycity_content_count);
                                $mycity_content_count = str_replace("\n", "",  $mycity_content_count);
                                if( strlen($mycity_content_count) > 1) {
                                    echo esc_html(preg_replace ('/\[.*?\]/is', '', $mycity_str)) ;
                                    
                                } else {
                                    esc_html_e( '
                                The theme allows you to switch from classical registration by e-mail to register by entering the phone (password comes to the phone). SMS comes in more than 200 countries. You can also enter through 20+ social networks.
                                ', 'mycity' );
                                }
                                
                                
                                
                                
                                            
                                 endwhile; else: endif;
                                
                                $mycity_auth = false;        
                                if ( is_user_logged_in() ) {
                                $mycity_auth = true;
                                } else {
                                $mycity_auth = false;    
                                };
                                 
                                 
                                 ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="reg_image_container">
                        <div class="reg_block">
                            <div class="btn-hack">
                                <?php 
                                    if($mycity_auth) {
                                        $mycity_current_user = wp_get_current_user();
                                        
                                     ?>
                                <div class="authorization register_p">
                                    <div class="authorization_head clearfix">
                                        <p class="auth_p pull-left">
                                            <?php echo esc_html($mycity_current_user->display_name); ?>
                                        </p>
                                        <i class="fa fa-times fa-2x pull-right"></i>
                                    </div>
                                    <div class="authorization_form" >
                                        <div class="auth_input clearfix">
                                            <?php 
                                                $mycity_n = wp_loginout(get_home_url('/'),0); 
                                                preg_match('/href="(.*?)">(.*?)</',$mycity_n, $math);
                                            
                                                
                                                ?>	
                                            <a class="fa  fa-sign-out fa-2x pull-righ" href="<?php echo esc_html($math[1]); ?>">
                                            </a>	
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }else {
                                    
                                ?>
                            <div class="btn-back">
                                <div class="authorization register_p">
                                    <div class="authorization_head clearfix">
                                        <p class="auth_p pull-left">
                                            <?php esc_html_e( 'Registration', 'mycity' ); ?>
                                        </p>
                                        <a href="/register" class="reg_close" id="reg_close">
                                        <i class="fa fa-times fa-2x pull-right"></i>
                                        </a>
                                    </div>
                                    <div class="authorization_form">
                                        <?php 
                                            if (get_option("allow_sms_registration") == 1) {
                                            ?>
                                         
                                        <?php } else {
                                            ?>
                                        <div class="auth_input clearfix">
                                            <div class="icon">
                                                <i class="fa fa-envelope fa-2x"></i>
                                            </div>
                                            <label class="enter_label">
                                            <?php esc_html_e( ' E-mail:', 'mycity' ); ?>
                                            </label>
                                            <input type="text" class="e-mail_in form-control" onchange='checkesc_html_email()' id='reglogin' placeholder="Your email"/>
                                        </div>
                                        <script>
                                            function checkesc_html_email() {
                                            	
                                            	$.post("<?php echo esc_html(mycity_get_ajax_uri()); ?>/ajax.php?checkesc_html_email=1",{email:jQuery("#reglogin").val()},function(d){
                                            		if (d != "OK") {
                                            				jQuery("#reglogin").removeClass("input_ok");
                                            				jQuery("#result").html(d); 
                                            			} else {
                                            				jQuery("#reglogin").addClass("input_ok");
                                            				jQuery("#result").html(d); 
                                            				jQuery("#tryreg").removeAttr("disabled");
                                            		}
                                            	});
                                            }
                                        </script>
                                        <?php	
                                            }?>
                                        <div class="auth_input clearfix">
                                            <div class="icon">
                                                <i class="fa fa-user fa-2x"></i>
                                            </div>
                                            <label class="enter_label">
                                            <?php esc_html_e( 'Enter name:', 'mycity' ); ?>
                                            </label>
                                            <input type="text" class="e-mail_in form-control" name='display_name' id='display_name' placeholder="<?php esc_html_e("Nick","mycity");?>"/>
                                        </div>
                                        <div class="auth_input clearfix">
                                            <div class="icon">
                                                <i class="fa fa-user fa-2x"></i>
                                            </div>
                                            <label class="enter_label">
                                            <?php esc_html_e( 'Password:', 'mycity' ); ?>
                                            </label>
                                            <input type="text" class="e-mail_in form-control" name="pass" id="regpass" placeholder="<?php esc_html_e("Password","mycity");?>">
                                        </div>
                                    </div>
                                    <div class="auth_login">
                                        <button class="ladda-button ladda-primary btn btn-primary" id='tryreg' onclick='reg();' data-color="red"  data-style="zoom-out"><?php esc_html_e( 'Register', 'mycity' ); ?></button>
                                        <span id='result'>
                                        </span>
                                        <script>
                                            function reg() {
                                            	jQuery.post("<?php echo esc_html(mycity_get_ajax_uri());?>/ajax.php?tryreg=1",{"regemail":jQuery("#regemail").val(),display_name:jQuery("#display_name").val(),login:jQuery("#reglogin").val(),pass:jQuery("#regpass").val()}, function (d) {
                                            		jQuery("#result").html(d);
                                            	}); 
                                            }
                                        </script>
                                    </div>
                                    <?php if (defined("OA_SOCIAL_LOGIN_BASE_PATH")) { ?>
                                        <div class="auth_soc_network">
                                            <p>   <?php esc_html_e( 'Log in with social network', 'mycity' ); ?></p>
                                            <div class="soc_net">
                                                <?php
                                                do_action( 'login_form' );

                                                ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="btn-front">
                                <div class="authorization">
                                    <div class="authorization_head clearfix">
                                        <p  class='edited auth_p pull-left' id='edited_Autorization1'>
                                            <?php esc_html_e( 'Autorization', 'mycity' ); ?>
                                        </p>
                                        <?php 
                                            if (get_option("allow_sms_registration") != 1) {
                                            ?>
                                        <a href="#" id="auth_menu">
                                        <i class="fa fa-user-plus fa-2x pull-right"></i>
                                        </a>
                                        <?php  } ?>
                                    </div>
                                    <div class="authorization_form">
                                        <?php 
                                            if (get_option("allow_sms_registration") == 1) {
                                            ?>
                                        <div class="auth_input clearfix">
                                            <div class="icon">
                                                <i class="fa fa-phone fa-2x"></i>
                                            </div>
                                            <label class="enter_label"><?php esc_html_e( 'Enter your phone', 'mycity' ); ?>:</label> <span id='green1' style='color:green'></span>
                                            <input id='login' onchange="if(this.value.length>10){jQuery('#green1').html('<?php esc_html_e("...","mycity"); ?>');jQuery.get('<?php echo esc_html(mycity_get_ajax_uri());?>/ajax.php?sendsms=' + this.value,function(d){jQuery('#green1').html('<?php esc_html_e("SMS sended","mycity"); ?>');})}" type="text" class="tel"  placeholder="+123456789">
                                        </div>
                                        <?php } else {
                                            ?>
                                        <div class="auth_input clearfix">
                                            <div class="icon">
                                                <i class="fa fa-envelope fa-2x"></i>
                                            </div>
                                            <label class="enter_label">   <?php esc_html_e( 'Email:', 'mycity' ); ?></label>
                                            <input type="text" class="form-control e-mail_in" id='login' placeholder="<?php esc_html_e("Your email","mycity");?>"/>
                                        </div>
                                        <?php	
                                            }?>
                                        <div class="auth_input clearfix">
                                            <div class="icon">
                                                <i class="fa fa-key fa-2x"></i>
                                            </div>
                                            <label class="enter_label">   <?php esc_html_e( 'Password:', 'mycity' ); ?></label>
                                            <input type="password" class="form-control e-mail_in" id='pass' placeholder="<?php if (get_option("allow_sms_registration") == 1) {echo esc_html__("Code from SMS","mycity");} else {echo "*******";}?>"/>
                                        </div>
                                    </div>
                                    <div class="auth_login">
                                        <button class="ladda-button ladda-primary btn btn-primary" id="try_login" data-color="red" onclick='trylogin();' data-style="zoom-out"><?php esc_html_e("Log in","mycity");?></button>
                                        <div class='' id='loginresult'><a href="<?php echo wp_login_url(); ?>?action=lostpassword"><?php esc_html_e("Lost your password?","mycity");?></a></div>
                                    </div>

									<?php if (defined("OA_SOCIAL_LOGIN_BASE_PATH")) { ?>
                                    <div class="auth_soc_network">
                                        <p>   <?php esc_html_e( 'Log in with social network', 'mycity' ); ?></p>
                                        <div class="soc_net">	
                                            <?php
                                                do_action( 'login_form' );
                                                
                                                ?>
                                        </div>
                                    </div>
									<?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div><script>
    jQuery(document).ready(function($){
        $(document).on("keypress", '.page-template-template-auth', function (event) {
    	
    			var keycode = (event.keyCode ? event.keyCode : event.which);
    			if(keycode == '13'){
    				trylogin();
    			}
    
    		});
    });
    	function trylogin() {
    		jQuery.post("<?php echo esc_url(mycity_get_ajax_uri());?>/ajax.php?trylogin=1",{"regemail":jQuery("#regemail").val(),"login":jQuery("#login").val(),"pass":jQuery("#pass").val()},function(d){
    			jQuery("#loginresult").removeClass("hidden");
    			jQuery("#loginresult").html(d);
    		});
    	}
</script>
<script>function initialize_map(){}</script>
<?php
    get_footer();
    ?>