<!--author-->
<div class="author">
    <?php echo get_avatar(sanitize_text_field($post->post_author)); ?><a
        href="<?php echo esc_url( '/members/'.$post->post_author); ?>"><?php echo esc_html(the_author_meta('user_nicename', $post->post_author)); ?></a>
	<span>
		<?php

		echo esc_html(the_author_meta('description', $post->post_author)); ?>
	</span>
</div>
