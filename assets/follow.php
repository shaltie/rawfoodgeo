<?php
/***
 * @param $user1
 * @param $user2
 * @return bool
 */
function mycity_is_follow($user1, $user2)
{
    global $wpdb;
    $follow = $wpdb->get_results($wpdb->prepare("SELECT * FROM follow WHERE user1 = '%d' AND user2 = '%d'",
        array((int)$user1, (int)$user2)));
    if (count($follow) > 0)
        return true;
    return false;
}

/**
 * @param $user1
 * @param $user2
 */

function mycity_follow_button($user1, $user2)
{
    //is follow?
    global $wpdb;
    if(get_theme_mod('item_page_follow2',1)) 
	{
        if (!mycity_is_follow($user1, $user2)) 
		{
            ?>
            <a href='#' class="btn btn-success ladda btn-follow ladda-button ladda-primary" data-style="zoom-out" onclick='togglefollow(<?php echo
            esc_attr($user2); ?>);return false' id='yafollow' data-name='follow'> <?php esc_html_e('Follow',
                    'mycity'); ?></a>
            <?php
        } else 
		{
            ?>
            <a href='#' class="btn btn-success ladda btn-follow ladda-button ladda-primary" data-style="zoom-out" onclick='togglefollow(<?php echo
            esc_attr($user2); ?>);return false' id='yafollow' data-name='follow'> <?php esc_html_e('Unfollow',
                    'mycity'); ?></a>

            <?php
        }
	}
}

/**
 * @param $id
 * @return int
 */
function mycity_get_followers_count($id)
{
    global $wpdb;
    $sql = "SELECT * FROM follow WHERE user20 = '" . (int)$id . "'";
    $follow = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM follow WHERE user2 = '%d'",
        array(
            $id
        ))
	);
	
    return (int)count($follow);
}
?>