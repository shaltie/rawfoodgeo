<div class="profile">
    <?php
    if (is_user_logged_in()) {
        ?>
        <div class="ladda-button my-button2" data-style="expand-right"></div>
        <div id="avatar_form" class="avatar">
            <form method="post" enctype="multipart/form-data">
                <?php
                $mycity_user_id = (int)get_current_user_id(); ?>


                <div class="input-file-row-1">
                    <div class="upload-file-container">
                        <?php echo str_replace('<img', '<img id="image"', get_avatar($mycity_user_id)); ?>
                        <div class="upload-file-container-text">
                            <input type="file" name="file" class="photo" id="imgInput"/>
                        </div>
                    </div>
                </div>
                <div id="resuli_img"></div>
            </form>
        </div>
        <?php
        $mycity_user = get_userdata($mycity_user_id);
        ?>
        <h3>
            <a href="<?php echo esc_url(fmr_get_permalink_by_template('template-members-list.php') .
                '/' . (int)$mycity_user->ID); ?>"><?php echo esc_html($mycity_user->
                display_name); ?></a>
        </h3>
        <?php
        $mycity_n = wp_loginout(get_home_url('/'), 0);
        preg_match('/href="(.*?)">(.*?)</', $mycity_n, $mycity_mathlog_out);
        ?>
        <a href="<?php echo esc_url($mycity_mathlog_out[1]); ?>"
           class="log_btn"><?php esc_html_e('Log out', 'mycity'); ?></a>
        <?php
    } else
        if (mycity_newBasename() != "template-auth.php") {
            ?>
            <a href=" <?php echo esc_url(fmr_get_permalink_by_template('template-auth.php')); ?> "
               class="log_btn"><?php esc_html_e('Log in', 'mycity'); ?></a>
            <?php
        } else {
            echo "<Br><br>";
        }
    ?>
</div>
<div class="log_btn"></div>