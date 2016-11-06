<?php
$bg = get_theme_mod('footer_footer_img');


if (strlen($bg) > 8) {
    $class = 'footer-with-img';
} else {
    $class = "";
}
?>

<footer class="<?php echo esc_attr($class); ?>">
    <div class="footer-overlay"></div>

    <?php
    if (strlen($bg) > 8) {
        ?>
        <img class="hero__background" src="<?php echo esc_url($bg); ?>">
        <?php
    }
    $arr = get_body_class();
    if (((!in_array('post-type-archive-places', $arr) && $arr[1] != 'tax-places_categories')) || isset($_GET['showas'])) {
        ?>

        <?php
// Check for the existence sidebar 
        if (is_active_sidebar('mycity_footer')) : ?>
            <div class="container">
                <div class="row">
                    <?php @dynamic_sidebar('mycity_footer'); ?>
                </div>
            </div>
            <?php
        endif;
        ?>
        <div class="copyright_container">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        $mycity_footer_copyright = get_theme_mod("footer_footer_copyright");
                        if (strlen($mycity_footer_copyright) > 3) {
                            ?>
                            <div id='footer_copiright'>
                                <?php

                                $allowed_html = array(
                                    'a' => array('href' => array(), 'title' => array()),
                                    'b' => array(),
                                    'i' => array('class' => array()),
                                    'br' => array(),
                                    'strong' => array());

                                echo wp_kses($mycity_footer_copyright, $allowed_html);
                                ?>
                            </div>
                            <?php
                        } else {
                            ?>
							
                            <div id='footer_copiright'>
                               <!-- <A
                                    href="http://mycity.wiki" target='_blank'>Create own city portal</a> -->
									<A
                                    href="http://standart-it.com/" target='_blank'>Web development</a>  standart-it.com
                            </div>
							
                            <?php

                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    <?php }

    ?>
</footer>


<div id='imodalko1'>

    <p class="imodal-p"><?php echo esc_html__("Help us improve the translation for your language", "mycity"); ?></p>
    <p><?php echo esc_html__("You can change any text by clicking on (press Enter after changing)", "mycity"); ?></p>
    <input type='button' name='' onclick='jQuery("#imodalko1").hide();' value='Ok!' class='form-control imod-but'>

</div>
<?php
$mycity_id = (get_theme_mod('my_ok_video_url'));
if (strlen($mycity_id) > 1 && is_front_page() && !is_single()) {

    ?>
    <script type="text/javascript">
        jQuery(function ($) {
            $.okvideo({
                source: '<?php
                    echo esc_html($mycity_id);
                    ?>',
                volume: 0,
                loop: true,
                hd: true,
                adproof: true,
                annotations: false,
                onFinished: function () {
                    console.log('finished')
                },
                unstarted: function () {
                    console.log('unstarted')
                },
                onReady: function () {
                    console.log('onready')
                },
                onPlay: function () {
                    console.log('onplay')
                },
                onPause: function () {
                    console.log('pause')
                },
                buffering: function () {
                    console.log('buffering')
                },
                cued: function () {
                    console.log('cued')
                },
            });
        });
    </script>

    <?php
}
?>

<?php

@wp_footer();
?>
</body>
</html>