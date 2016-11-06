<?php


function mycity_fiu_upload_file(){


    $upload_dir       = esc_attr(wp_upload_dir());
    $upload_path      = esc_attr(str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR);
    $file             = $_FILES[0];

    $uploadedfile = $file;

//verification of the fact that it is a picture
    $imageinfo = getimagesize($uploadedfile['tmp_name']);

    if ($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png'
    ) {
        echo "Sorry, we only accept GIF and JPEG and PNG images\n";
        exit;
    }


    $movefile =  wp_handle_sideload( $uploadedfile,array('test_form' => FALSE));

    if ( $movefile ) {
        $wp_filetype = $movefile['type'];
        $filename = $movefile['file'];

        $wp_upload_dir = wp_upload_dir();
        $attachment = array(
            'guid' => $wp_upload_dir['url'] . '/' .mycity_newBasename($filename ),
            'post_mime_type' => $wp_filetype,
            'post_title' => preg_replace('/\.[^.]+$/', '', mycity_newBasename($filename)),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = esc_attr(wp_insert_attachment( $attachment, $filename));

        echo "id= ".esc_attr($attach_id);
        $user_id= esc_attr(get_current_user_id());
        update_user_meta($user_id, 'be_custom_avatar', sanitize_text_field($attach_id) );

    }
    echo "be_custom_avatar_{$user_id}";

    exit();
}

add_action('wp_ajax_mycity_fiu_upload_file', 'mycity_fiu_upload_file');
add_action('wp_ajax_nopriv_mycity_fiu_upload_file', 'mycity_fiu_upload_file');





/*--- add new avatar in site*/

function mycity_be_custom_avatar_field($user)
{ ?>

    <h3>Custom Avatar</h3>
    <table>
        <tr>
            <th><label for="be_custom_avatar">Custom Avatar URL:</label></th>
            <td>
                <input type="text" name="be_custom_avatar" id="be_custom_avatar" value="<?php echo esc_attr(get_the_author_meta('be_custom_avatar', $user->ID)); ?>" /><br />
                <span>Type in the input id images. </span>
            </td>
        </tr>
    </table>

    <?php
}
add_action('show_user_profile', 'mycity_be_custom_avatar_field');
add_action('edit_user_profile', 'mycity_be_custom_avatar_field');
/**

 */
function mycity_be_save_custom_avatar_field($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    update_user_meta($user_id, 'be_custom_avatar', sanitize_text_field($_POST['be_custom_avatar']));
}
add_action('personal_options_update', 'mycity_be_save_custom_avatar_field');
add_action('edit_user_profile_update', 'mycity_be_save_custom_avatar_field');


/*new user avatar in site*/


function mycity_be_gravatar_filter($avatar, $id_or_email, $size, $default, $alt)
{
    global $comment;


    if((int)$id_or_email > 0){
        $user_thumbnail = get_user_meta ($id_or_email, 'oa_social_login_user_picture', true);
        if(isset($user_thumbnail{2})){
            return '<img  src="' . sanitize_text_field ($user_thumbnail) . '" width="' . $size . '" height="' .
            $size . '" alt="' . $alt . '" />';
        }


    }

    // No avatar found.  Return unfiltered.

    // If provided an email and it doesn't exist as WP user, return avatar since there can't be a custom avatar
    $email = is_object($id_or_email) ? $id_or_email->comment_author_email : $id_or_email;
    if (is_email($email) && !email_exists($email))
        return $avatar;

    $user_id = $id_or_email;

    if(isset($user_id->user_id)) {
        $custom_avatar = get_user_meta($user_id->user_id, 'be_custom_avatar', true);
    } elseif( mycity_email_exists($user_id)) {
        $custom_avatar = get_user_meta( mycity_email_exists($user_id), 'be_custom_avatar', true);
    }else{
        $custom_avatar = get_user_meta( $user_id, 'be_custom_avatar', true);
    }


    if( strlen($custom_avatar) > 0  ) {
        $custom_avatar = wp_get_attachment_image_src($custom_avatar, 'thumbnail-size', true);
        $custom_avatar = $custom_avatar[0];
    } else {
        $custom_avatar = get_template_directory_uri() . '/img/avatar/default_avatar.png';
    }



    if(preg_match("/default.png/",$custom_avatar)) {
        $custom_avatar = get_template_directory_uri() . '/img/avatar/default_avatar.png';
    }
    $meta_avatar_url = get_the_author_meta('be_custom_avatar', $user_id);
    if(preg_match("/.*?(\.).*?(\.).*?/",$meta_avatar_url ) && strlen($meta_avatar_url) > 30) {
        $custom_avatar = $meta_avatar_url;
    }


    if ($custom_avatar){
        $return = '<img  src="' . sanitize_text_field ($custom_avatar) . '" width="' . $size . '" height="' .
            $size . '" alt="' . $alt . '" />';
    }
    else
        $return = '<img src="' . sanitize_text_field (get_template_directory() . '/avatar/default_avatar.png') . '" width="' . $size . '" height="' . $size .
            '" alt="' . $alt . '" />';



    return $return;

}
add_filter('get_avatar', 'mycity_be_gravatar_filter', 10, 999);


function mycity_email_exists( $email ) {
    if ( $user = get_user_by('email', $email) )
        return $user->ID;

    return false;
}

?>