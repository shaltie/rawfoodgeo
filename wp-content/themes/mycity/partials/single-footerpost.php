<?php
/**
 * Displays information in the end of the post
 */
?>
<div class="p_footer">
    <?php
    global $post;
    $mycity_author_id = (int)$post->post_author;
    ?>
    <ul>
        <li>
            <i class="fa fa-globe"></i>
            <?php
            $mycity_views = (int)esc_attr(get_option("views_" . $post->ID));
            echo esc_attr($mycity_views++);
            update_option("views_" . $post->ID, (int)$mycity_views);
            ?>
        </li>
        <li>
			<i class="fa fa-tags"></i> <?php the_category(); ?>
		</li>
        <li>
			<i class="fa fa-comments"></i> <?php comments_number('no responses', 'one response', '% responses'); ?>.
        </li>
        <li>	
			<i class="fa fa-calendar"></i> <?php the_date('m.d.Y'); ?>
		</li>
        <li>
            <?php
            if (strlen(esc_html(the_author_meta('description', $post->post_author))) < 1) {
                ?><i class="fa fa-user"></i>
                <?php
             
                $user_info = get_userdata($post->post_author);

                echo esc_html($user_info->display_name);
            }
            ?>
		</li>
    </ul>
</div>