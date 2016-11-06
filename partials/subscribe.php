<?php
/**
 * Subscribe form
 */
if (get_theme_mod('single_post_single_post_control') == false) 
{  ?>
    <div class="Subscribe">
        <div class="div">
            <h2 class='edited' id='edited_Subscribe'><?php esc_html_e("Subscribe now", "mycity"); ?></h2>
            <form id="subsribe" action="">
                <input class="subsribe_email" type="text" placeholder='email@email.com'>
                <button type="submit" class="btn btn-danger button_substribe">
				<?php  esc_html_e("Subscribe", "mycity"); ?></button>
            </form>
        </div>
    </div>
    <div class="Subscribe_error"></div>
    <?php
}