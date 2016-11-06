<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
 
if (post_password_required()) {
    return;
}

function mycity_mytheme_comment($comment, $args, $depth)
{
    $user = get_user_by("email", $comment->comment_author_email);
    extract($args, EXTR_SKIP);
    if ('div' == $args['style']) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
    $comment->comment_author;
    ?>

    <div class="rev" id="comment-<?php (int)comment_ID() ?>">
        <div class="user">
            <!--user avatar-->
            <a href="/members/<?php if(isset($user->ID)) echo @(int)esc_html($user->ID); ?>" class="user_avatars">
                <div class="user_go">
                    <i class="fa fa-link"></i>
                </div>
                <?php if (function_exists("get_avatar")) echo get_avatar($comment, 46); ?>
            </a>
        </div>

        <?php if ($comment->comment_approved == '0') : ?>
            <em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'mycity'); ?></em>
            <br/>
        <?php endif; ?>
        <div class="texts">
            <div class="head_rev"><?php printf(__('%s', 'mycity'), get_comment_author_link()); ?>
                <span><?php echo esc_html(get_comment_date()); ?><?php edit_comment_link(esc_html__('(Edit)', 'mycity'), '  ', '');; ?></span>
            </div>
            <div class="text_rev"><?php comment_text(); ?></div>
        </div>
    </div>
<?php
}
?>


<div class="reviews open">
    <?php
	if (have_comments()) : ?>
        <ol class="comment-list" style='padding:0'>
            <?php  wp_list_comments('type=comment&callback=mycity_mytheme_comment'); ?>
        </ol><!-- .comment-list -->
    <?php 
	endif; // have_comments() 
	
	if(function_exists('mycity_wp_comments_corenavi')) mycity_wp_comments_corenavi(); 
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'mycity'); ?></p>
    <?php
	endif; ?>

    <div class="add_comment">
        <?php
        ob_start();
        comment_form();
        $mycity_con = str_replace('name="submit"', 'name="submit" class="btn btn-success"', ob_get_clean());
        $mycity_con = str_replace('type="text"', 'type="text" class="form-control"', $mycity_con);
        print_R($mycity_con);
        ?>
    </div>
</div><!-- .comments-area -->


