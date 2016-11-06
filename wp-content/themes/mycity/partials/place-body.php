<div class="phone_email clearfix">
<?php
global $mycity_short_descr;

	if (current_user_can("edit_post", (int)$post->ID)) {
        ?>

                 <a href="#" class="btn btn-success adda btn-follow" id="submit-review">Submit review</a>
                 <a href='#' id="edit-edit" class="btn btn-success ladda btn-follow ladda-button ladda-primary" data-style="zoom-out"
           onclick='window.location="/submit-place/<?php echo (int)esc_html($post->ID); ?>";return false'> <?php esc_html_e('Edit place',
                'mycity'); ?></a>
        <?php
    }
    esc_html(mycity_follow_button(get_current_user_id(), (int)$post->ID * -1)); ?>
    <div class="clear"></div>
</div>
<!--icon description block-->
<div class="icon_descr_block">
    <?php
    get_template_part("partials/place", "bubles");
    ?>
    <?php
    $mycity_small_content = true;
    $mycity_out = get_the_content();
    $mycity_out = preg_replace('/\[.*?\](.*?)\[.*?\]/is', '', $mycity_out);
    if (strlen($mycity_out) > 150) {
        $mycity_small_content = false;
    }
    $mycity_str = get_the_content();

    if ($mycity_small_content || isset($mycity_short_descr)) { ?>
        <div class="bubble">
            <div>
                <?php
                if (isset($mycity_short_descr)) $mycity_out = $mycity_short_descr;
                echo '<p>' . esc_html($mycity_out) . '</p>';
                ?>
                <span></span>
                <span></span>
            </div>
        </div>
        <?php
    }
    ?>
    <?php
    $mycity_count = 0;
    preg_match_all('/\[feature\](.*?):(.*?)\[\/feature\]/is', get_the_content(), $mycity_features);
    if (count($mycity_features[1])>1) {  ?><!--Features info-->
    <div class="features_block ">

        <div>
            <ul>
                <?php foreach ($mycity_features[1] as $k => $v) {


                    echo "<li><b>" . wp_kses_post($v) . ":</b>";
                    echo " " . wp_kses_post($mycity_features[2][$k]) . "<br></li>";
                    $mycity_count++;

                }
                ?>
            </ul>
        </div>
    </div>

<?php } ?>
</div>


<?php
get_template_part("partials/place", "eventon");
?>
<div class="share_block">
    <div><!--Share this place btn and total visitors-->
        <?php
        if (function_exists('ADDTOANY_SHARE_SAVE_KIT') && get_theme_mod('item_page_control_share', true)) {
            ADDTOANY_SHARE_SAVE_KIT();
        }
        ?>
    </div>
    <div>
        <div>
            <span class='edited' id='edited_1placedate<?php the_ID(); ?>'><?php esc_html_e('Date added', 'mycity'); ?></span>
            <?php the_time(); ?>
        </div>
        <div>
            <span class='edited' id='edited_Visitors<?php the_ID(); ?>'><?php esc_html_e('Total Visitors', 'mycity'); ?></span>
            <?php
			$mycity_views = (int)esc_html(get_option("views_" . $post->ID));
            echo esc_html($mycity_views++);
			?>
            <?php esc_html_e('total', 'mycity'); ?>
        </div>
    </div>
</div>
<?php
if (!$mycity_small_content) {
    ?>
    <div class="phone_email">
        <?php echo '<p>' . esc_html($out) . '</p>'; ?>
    </div>
    <?php
}
?>


<?php
$mycity_short_code = get_theme_mod('my_Testimonials_short', "[show-testimonials orderby='menu_order' order='ASC' layout='grid' options='theme:speech,info-position:info-left,text-alignment:left,columns:2,review_title:on,rating:on,quote-content:short,charlimitextra: (...),display-image:on,image-size:ttshowcase_small,image-shape:circle,image-effect:none,image-link:on']");
echo do_shortcode($mycity_short_code); ?>
<?php

if( strlen(get_post_meta(get_the_ID(), 'instaid',true))>3 && !in_array('instagram',$mycity_hide_url)) get_template_part("partials/place", "tremula");
?>

<?php
$mycity_post_insid = str_replace(" ","",get_post_meta(get_the_ID(), 'post_inside', true));
$mycity_post_street_view = str_replace(" ","",get_post_meta(get_the_ID(), 'post_street_view', true));

if ( (strlen($mycity_post_insid) > 5 || strlen($mycity_post_street_view) > 5)
    && !in_array('google',$mycity_hide_url)  ) {

    ?>

    <div class="bs-example" >
        <?php
        $mycity_allowed_html = array(
            'b' => array(),
            'iframe' => array(
                'class' => array(),
                'src' => array(),
                'width' => array(),
                'height' => array(),
                'frameborder' => array(),
                'style' => array(),
                'allowfullscreen' => array(),
            ),
            'br' => array(),
            'strong' => array());
        ?>





        <div class="google_place">
            <?php
            $inside = 	get_post_meta(get_the_ID(), 'post_inside', true);
            $street = get_post_meta(get_the_ID(), 'post_street_view', true);

            if (strlen($inside)>10 && strlen($street)>10) {
                ?>
                <ul class="gp_nav">

                    <?php
                    if ($inside) {
                        ?>
                        <li class="tabs_controls_item">
                            <a href="#" class="active"><i class="fa fa-location-arrow"></i><?php echo esc_html__("Inside View","mycity");?></a>
                        </li>
                    <?php } ?>
                    <?php
                    if (strlen($street)>10) {
                        ?>
                        <li class="tabs_controls_item">
                            <a href="#"><i class="fa fa-globe"></i><?php echo esc_html__("Street View","mycity"); ?></a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
            <ul class="gp_content">
                <?php
                if (strlen($inside)>10):
                    ?>
                    <li class="tabs_item active">

                        <div class='google_view'>
                            <?php
                            echo $inside;
                            ?></div>

                    </li>
                    <?php
                endif; ?>
                <?php if (strlen($street)>4):
                    ?>
                    <li class="tabs_item <?php if (strlen($inside)<10) echo 'active';?>" style=''>

                        <div class='google_view'>
                            <?php
                            echo $street;
                            ?></div>

                    </li>
                    <?php
                endif; ?>
            </ul>



        </div>


    </div>
<?php } ?>
