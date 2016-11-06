<?php
/**
 *
 * Template Name: template-add.php (Submit place)
 * Preview: http://chat.vioo.ru/feed.html
 */

global $wp_error, $wpdb;
if ( ! isset( $wp_query->query_vars['page'] ) || $wp_query->query_vars['page'] == 0 ) {
    $my_post = array(
        'post_title'   => esc_html__( 'Enter the place name', "mycity" ),
        'post_content' => esc_html__( 'Description', "mycity" ),
        'post_status'  => get_theme_mod( 'item_page_firststatus', 'publish' ), //change draft to publish
        'post_author'  => (int) get_current_user_id(),
        'post_type'    => 'places'
    );
    /**
     * if the user is not authorized, we will send it to the login page.
     */
    if ( ! get_current_user_id() ) {
        //wp_safe_redirect( esc_url( home_url().'/register'));
        $mycity_post_ID = wp_insert_post( $my_post, $wp_error );
        $url            = add_query_arg( 'page', $mycity_post_ID, get_permalink() );
        $url            = str_replace( '?page=', '', $url );
        wp_safe_redirect( $url );

    } else {
        $mycity_post_ID = wp_insert_post( $my_post, $wp_error );
        $url            = add_query_arg( 'page', $mycity_post_ID, get_permalink() );
        $url            = str_replace( '?page=', '', $url );
        wp_safe_redirect( $url );
    }

} else {
    $mycity_draft_id         = (int) $wp_query->query_vars['page'];
    $mycity_postplace        = get_post( $mycity_draft_id );
    $mycity_additional_class = "is_reg";

    get_header();

    //If  press send button
    if ( isset( $_GET['del'] ) && $_GET['del'] = 1 ) {
        wp_delete_post( $mycity_draft_id );
        wp_safe_redirect( esc_url( home_url( '/' ) ) );
    }
    if ( $_POST ) {
        //delete cahe on map
        delete_transient( 'mycity_places_map' );
        $mycity_slug = sanitize_title_with_dashes( $_POST['titlez'] );

        if ( isset( $_POST['slug'] ) && current_user_can( 'administrator' ) ) {
            $mycity_slug = $_POST['slug'];
        }

        $post_status = 'draft';
        //if this admin
        if ( get_post_status( $mycity_draft_id ) == "publish" || current_user_can( "administrator" ) ) {
            $post_status = 'publish';
        }
        $mycity_post_data = array(
            'ID'           => $mycity_draft_id,
            'post_title'   => sanitize_text_field( $_POST['titlez'] ),
            'post_content' => wp_kses_post( $_POST['post_content'] ),
            'post_status'  => $post_status,
            'post_name'    => $mycity_slug,
            'menu_order'   => - 1

        );
        if ( $_POST['sticky'] == 'on' ) {
            stick_post( $mycity_draft_id );

        } else {
            unstick_post( $mycity_draft_id );
        }


        wp_update_post( $mycity_post_data );
        mycity_my_save_postdata( $mycity_draft_id );


        wp_set_object_terms( $mycity_draft_id, array( (int) $_POST['place_category'] ),
            "places_categories" );

        $mycity_latlong = explode( ",", sanitize_text_field( $_POST['myplugin_new_field'] ) );


        // create new taxonomy from new values

        $mycity_term_name = sanitize_text_field( $_POST['titlez'] );
        $mycity_term_slug = str_replace( " ", "-", $mycity_term_name );


        $mycity_term_meta                     = array();
        $mycity_term_meta['location_lon']     = sanitize_text_field( $mycity_latlong[1] );
        $mycity_term_meta['location_lat']     = sanitize_text_field( $mycity_latlong[0] );
        $mycity_term_meta['location_address'] = sanitize_text_field( ( get_post_meta( $mycity_postplace->ID,
            '_adress', true ) ) );


        if ( isset( $_POST['slug'] ) && current_user_can( 'administrator' ) ) {
            $mycity_term_slug = $_POST['slug'];
        }

        $term = term_exists( $mycity_term_slug, 'event_location' );

        if ( isset( $term['term_id'] ) ) {
            update_option( "taxonomy_" . (int) $term['term_id'], $mycity_term_meta );
        } else {
            // create wp term
            $mycity_new_term = wp_insert_term( $mycity_term_name, 'event_location', array(
                'slug'             => $mycity_term_slug,
                'location_address' => sanitize_text_field( get_post_meta( $mycity_postplace->ID, '_adress', true ) ),
                'location_lat'     => sanitize_text_field( $mycity_latlong[0] ),
                'location_lon'     => sanitize_text_field( $mycity_latlong[1] )
            ) );
            //update wp term
            if ( ! is_wp_error( $mycity_new_term ) ) {

                update_option( "taxonomy_" . (int) $mycity_new_term['term_id'], $mycity_term_meta );
            }
        }


        //if not empty inside anf vies google
        $mycity_allowed_html = array(
            'b'      => array(),
            'iframe' => array(
                'class'           => array(),
                'src'             => array(),
                'width'           => array(),
                'height'          => array(),
                'frameborder'     => array(),
                'style'           => array(),
                'allowfullscreen' => array(),
            ),
            'br'     => array(),
            'strong' => array()
        );


        update_post_meta( $mycity_draft_id, 'post_inside', wp_kses( $_POST['post_inside'], $mycity_allowed_html ) );

        if ( ! isset( $_POST['smalldescr'] ) ) {
            $_POST['smalldescr'] = "";
        }
        update_post_meta( $mycity_draft_id, 'smalldescr', wp_kses( $_POST['smalldescr'], $mycity_allowed_html ) );

        update_post_meta( $mycity_draft_id, 'post_street_view', wp_kses( $_POST['post_street_view'],
            $mycity_allowed_html ) );


        //rederict to placesc
        if ( get_theme_mod( 'item_page_firststatus', 'publish' ) == 'publish' ) {
            wp_safe_redirect( esc_url( get_permalink( $mycity_draft_id ) ) );
        } else {
            if ( get_post_status( $mycity_draft_id ) == "publish" ) {
                wp_safe_redirect( esc_url( get_permalink( $mycity_draft_id ) ) );
            } elseif ( current_user_can( "administrator" ) ) {
                wp_safe_redirect( esc_url( get_permalink( $mycity_draft_id ) ) );
            }
            $showok = 1;

        }
    }

    ?>
    <div class="submit_place_wrapper">
        <?php get_sidebar(); ?>

        <script>
            function FFanaliz(a) {
                if ($("#pac-input").is(":focus")) {
                    return false;
                }
            }
            jQuery('#hero-bg').addClass("fixid_notr");
            jQuery('#hero-bg').css({
                minHeight: 2000
            });
        </script>
        <div class="container submit-cont">
            <div class="row">
                <form action='' method='post' onsubmit="return FFanaliz(this)">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="submit_form">
                            <div class="submit_title">
                                <?php

                                if ( isset( $showok ) && $showok == 1 ) {
                                    ?>
                                    <div
                                        class='alert alert-info'><?php esc_html_e( 'Success! Place will be added after moderation', 'mycity' ); ?>
                                    </div>
                                    <?php
                                }

                                ?>
                                <label class='edited' id='edited_labeladdplaces'><?php echo esc_html( _e( 'Title',
                                        'mycity' ) ); ?>:</label>
                                <input
                                    type="text" name='titlez' class="form-control title_location" value='<?php
                                if ( isset( $mycity_postplace->post_title ) && $mycity_postplace->post_title != esc_html__( "Enter the place name", "mycity" ) ) {
                                    echo esc_html( $mycity_postplace->post_title );
                                }
                                ?>'
                                    placeholder="<?php esc_html_e( "Enter place title", "mycity" ); ?>"/>
                                <!-- Help -->
                                <div class="submit_add_message">
                                    <p><?php esc_html_e( 'Enter Title', 'mycity' ); ?>
                                    </p>
                                    <p class="p_double">
                                        <?php esc_html_e( 'Please no more than 120 characters', 'mycity' ); ?>
                                    </p>
                                </div>
                                <!-- / Help -->
                            </div>
                            <?php if ( current_user_can( 'administrator' ) ) { ?>
                                <div class="submit_slug">

                                    <label class='edited'
                                           id='edited_labeladdplacesslug'><?php echo esc_html( _e( 'Slug',
                                            'mycity' ) ); ?>:</label>
                                    <input
                                        type="text" name='slug' class="form-control title_location" value='<?php
                                    if ( isset( $mycity_postplace->post_name ) && $mycity_postplace->post_name != esc_html__( "Enter the place slug", "mycity" ) ) {
                                        echo esc_html( $mycity_postplace->post_name );
                                    }
                                    ?>'
                                        placeholder="<?php esc_html_e( "Enter place slug", "mycity" ); ?>"/>
                                    <br>
                                </div>
                            <?php } ?>
                            <div class="checkbox">
                                <label>
                                    <?php
                                    $atrr          = '';
                                    $sticky_places = mycity_get_sticky_places();
                                    if ( in_array( $mycity_draft_id, $sticky_places ) ) {
                                        $sticky_places = 'checked';
                                    }


                                    ?>


                                    <input
                                        name="sticky" <?php echo esc_attr( $sticky_places ); ?>
                                        type="checkbox"> <?php esc_html_e( 'Sticky places',
                                        'mycity' ); ?>
                                </label>
                            </div>
                            <div class="submit_place_upload">
                                <div class="row">
                                    <div class="col-md-3">
                                        <i class="close_image fa fa-close pull-right fa_add_1"></i>
                                        <?php
                                        $mycity_small_img = wp_get_attachment_image_src( get_post_meta( $mycity_draft_id, '_small_img', true ),
                                            'thumbnail' );
                                        ?>
                                        <div action="<?php echo
                                        esc_url( plugins_url() ); ?>/GeoCity/media_upload.php?x=small&id=<?php echo esc_html( $mycity_draft_id ); ?>"
                                             class="dropzone pull-left drop1 dropzone_add_img_1">
                                            <div class="dz-message" data-dz-message>
                                                <span> <?php echo esc_html__( 'Drop images here to upload', 'mycity' ) ?></span>
                                            </div>
                                            <div class="fallback">
                                                <input name="file" type="le" class="db_non"/>
                                                <input name='file2src' type='hidden' value=''>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <i class="close_image fa fa-close pull-right fa_close_2"></i>
                                        <div
                                            action="<?php echo esc_url( plugins_url() ); ?>/GeoCity/media_upload.php?x=big&id=<?php echo esc_html( $mycity_draft_id ); ?>"
                                            class="dropzone drop2 dropzone_add_img_2">
                                            <div class="dz-message" data-dz-message>
                                                <span> <?php echo esc_html__( 'Drop images here to upload', 'mycity' ) ?></span>
                                            </div>
                                            <div class="fallback">
                                                <input name="file2" type="file" class="db_non"/>
                                                <input name='file2src' type='hidden' value=''>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <label class='edited'
                                   id='edited_categoryaddplaces'><?php echo esc_html_e( 'Category:', 'mycity' ); ?></label>
                            <?php
                            $mycity_post_terms = wp_get_object_terms( (int) $mycity_draft_id, "places_categories" );
                            $mycity_cats       = get_categories( "taxonomy=places_categories&hide_empty=0" );

                            if ( count( $mycity_cats ) > 0 ) {
                                ?>
                                <select name='place_category' class='form-control' id='category'>
                                    <?php
                                    foreach ( $mycity_cats as $mycity_cat ) {
                                        ?>
                                        <option value='<?php echo (int) $mycity_cat->cat_ID ?>'
                                            <?php
                                            if ( isset( $mycity_post_terms[0] ) && $mycity_post_terms[0]->term_id == $mycity_cat->cat_ID ) {
                                                echo "selected";
                                            } ?>><?php echo esc_html( $mycity_cat->name ); ?></option>
                                    <?php }

                                    ?>
                                </select>
                            <?php } else {
                            ?>
                                <div class="alert alert-info"><?php
                                    echo esc_html__( "Add some places category before submit item!", "mycity" );
                                    ?></div>
                                <script>jQuery(".sub_obj_edit").prop("disabled", true)</script><?php
                            }
                            ?>


                            <label class='edited'
                                   id='edited_tagsaddplaces'><?php esc_html_e( 'Tags:', 'mycity' ); ?></label>
                            <div id='Tags_in'>
                                <div class="submit_add_message">
                                    <p><?php esc_html_e( 'Tags, the more the better. But no more than five.',
                                            'mycity' ); ?></p>
                                    <p class="p_double"><?php esc_html_e( 'Good for SEO optimization.', 'mycity' ); ?></p>
                                </div>
                            </div>
                            <div class="input-group">
                                <input type="text" name='meta_tags' value="<?php if ( isset( $mycity_postplace->ID ) ) {
                                    echo esc_html( get_post_meta
                                    ( (int) $mycity_postplace->ID, '_tags', true ) );
                                } ?>" class="form-control location"
                                       data-role="tagsinput">
                            </div>
                            <!-- <input type="button" value="submit"> -->
                            <div class="map_container">
                                <div id="canvas2">
                                    <input id="pac-input" class="controls" type="text"
                                           placeholder="<?php esc_html_e( "Enter a location", "mycity" ) ?>">
                                    <div id="type-selector" class="controls control-group">
                                        <label class='edited' id='edited_Coordinatesaddplaces'>
                                            <?php esc_html_e( 'Coordinates:', 'mycity' ); ?>
                                        </label>
                                        <input id="cordinats2" type="text" required name="myplugin_new_field"
                                               value="<?php echo
                                               esc_html( @get_post_meta( (int) $mycity_postplace->ID, '_myfield', true ) ); ?>"/>
                                        <label class='edited'
                                               id='edited_Addressaddplaces'> <?php esc_html_e( 'Formatted Address',
                                                'mycity' ); ?></label>
                                        <input id="formatted_address" data-geo="formatted_address"
                                               name="formatted_address" type="text" value="<?php echo
                                        esc_html( @get_post_meta( (int) $mycity_postplace->ID, '_adress', true ) ); ?>">
                                        <label class='edited' id='edited_phoneaddplaces'><?php esc_html_e( 'Phone',
                                                'mycity' ); ?></label>
                                        <input id="phone" data-geo="formatted_address" name="meta_phone" type="text"
                                               value="<?php echo
                                               esc_html( @get_post_meta( (int) $mycity_postplace->ID, '_meta_phone', true ) ); ?>">
                                        <label class='edited' id='edited_Websiteaddplaces'><?php esc_html_e( 'Website',
                                                'mycity' ); ?></label>
                                        <input id="website2" data-geo="formatted_address" name="website2" type="text"
                                               value="<?php echo
                                               esc_html( @get_post_meta( (int) $mycity_postplace->ID, '_meta_website', true ) ); ?>">
                                    </div>
                                    <div id="map-canvas" style="width: 100%; height: 600px; position: absolute;"></div>
                                    <?php
                                    $mycity_allowed_html = array(
                                        'b'      => array(),
                                        'iframe' => array(
                                            'class'           => array(),
                                            'src'             => array(),
                                            'width'           => array(),
                                            'height'          => array(),
                                            'frameborder'     => array(),
                                            'style'           => array(),
                                            'allowfullscreen' => array(),
                                        ),
                                        'br'     => array(),
                                        'strong' => array()
                                    );

                                    ?>
                                </div>
                            </div>
                            <div class="post_inside po">
                                <br>
                                <label for="post_inside">
                                    <?php
                                    esc_html_e( 'Google inside view or business view code:', 'mycity' );
                                    ?>
                                </label>
                            <textarea name='post_inside' rows='2' id="post_inside" class='form-control'><?php
                                if ( @get_post_meta( (int) $mycity_postplace->ID, 'post_inside', true ) ) {
                                    echo wp_kses( get_post_meta( (int) $mycity_postplace->ID, 'post_inside', true ), $mycity_allowed_html );
                                }
                                ?></textarea>
                                <div class="submit_add_message ">
                                    <p> <?php
                                        esc_html_e( 'Enter iframe html code ', 'mycity' );
                                        ?>                   </p>
                                    <p class="p_double">
                                        <?php
                                        esc_html_e( 'Go to the right address on map.google.com Google map, and throw the man to the desired point. Then then click "see inside" then click the ellipsis button > Share or embed image > Embed image and copy the html code   go to the right address on Google map,and throw the man to the desired point,  and then click the ellipsis > Share or embed image > Embed image and copy the html code', 'mycity' );
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="post_street_view por">
                                <label for="post_street_view">
                                    <?php
                                    esc_html_e( 'Google street view:', 'mycity' );
                                    ?>
                                </label>
                            <textarea name='post_street_view' rows='2' id="post_street_view" class='form-control'><?php
                                if ( @get_post_meta( (int) $mycity_postplace->ID, 'post_street_view', true ) ) {
                                    echo wp_kses( get_post_meta( (int) $mycity_postplace->ID, 'post_street_view', true ), $mycity_allowed_html );
                                }
                                ?></textarea>
                                <div class="submit_add_message ">
                                    <p> <?php
                                        esc_html_e( 'Enter iframe html code', 'mycity' );
                                        ?>                   </p>
                                    <p class="p_double">
                                        <?php
                                        esc_html_e( 'Go to the right address on Google map, and throw the man to the desired point,  and then click the ellipsis > Share or embed image > Embed image and copy the html code:', 'mycity' );
                                        ?>
                                    </p>
                                </div>
                            </div>

                            <div id='post_content'>
                                <div class="submit_add_message">
                                    <p class='edited'
                                       id='edited_Entershortaddplaces'><?php esc_html_e( 'Enter short or long description',
                                            'mycity' ); ?></p>
                                    <p class="p_double"><?php esc_html_e( 'Try', 'mycity' ); ?>
                                        [feature]<?php esc_html_e( 'Example feature:yes',
                                            'mycity' ); ?>[/feature] <?php esc_html_e( 'here for small features.
										Or other shortcodes. 
										', 'mycity' ); ?>
                                    </p>
                                </div>
                            </div>

                            <?php
                            $shortcodes = array(
                                '[bigfeature]  :[/bigfeature]' => esc_html__( '[bigfeature] icon :Wi-Fi[/bigfeature]', 'mycity' ),
                                '[feature]  : [/feature]'      => esc_html__( '[feature] icon Work hours:24 hous/s[/feature]', 'mycity' ),

                            );
                            ?>

                            <label class='edited' id='edited_Descriptionaddplaces2'><?php esc_html_e( 'Description',
                                    'mycity' ); ?>


                            </label><Br>
                            <!-- Button trigger modal -->
                            <select style='float:left;margin:4px;' name="shortcode-select" id="fmr-shortcode-select">
                                <option><?php esc_html_e( "Select shortcode to insert", "mycity" ); ?></option>
                                <?php foreach ( $shortcodes as $shortcode => $label ) : ?>
                                    <option
                                        value="<?php echo esc_attr( $shortcode ); ?>"><?php echo esc_html( $label ); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal">
                                <?php echo esc_html_e( 'Insert icon', 'mycity' ); ?>
                            </button>





                        <textarea name='post_content' rows='20' id="post_content_in" class='form-control'><?php echo
                            @esc_textarea( $mycity_postplace->post_content ); ?></textarea>

                            <div id='post_content'>
                                <div class="submit_add_message">
                                    <p class='edited'
                                       id='edited_Entershortaddplaces22'><?php esc_html_e( 'Enter short description. Up to 140 symbols',
                                            'mycity' ); ?></p>
                                    <p class="p_double"><?php esc_html_e( '', 'mycity' ); ?>
                                    </p>
                                </div>
                            </div>
                            <label class='edited'
                                   id='edited_Descriptionaddplaces2'><?php esc_html_e( 'Short description',
                                    'mycity' ); ?></label> <br>
                        <textarea name='smalldescr' rows='2' id="post_content_in" class='form-control'><?php echo
                            @esc_textarea( @get_post_meta( (int) $mycity_postplace->ID, 'smalldescr', true ) ); ?></textarea>


                            <div>
                                <b class='edited'
                                   id='edited_Instagramcheckpointaddplaces'><?php esc_html_e( 'Instagram checkpoint isert your name',
                                        'mycity' ); ?></b>
                                <input type='text' class='form-control' id='instaid' placeholder='Instagram Place ID'
                                       name='instaid' value='<?php echo
                                @get_post_meta( (int) $mycity_postplace->ID, 'instaid', true ); ?>'>
                                <div id='instagrams'>
                                    <!--etot div ne trogat'-->
                                    <div class="submit_add_message">
                                        <p class='edited'
                                           id='edited_ofcheckpointddplaces'><?php esc_html_e( 'Enter the ID of checkpoint or click one below',
                                                'mycity' ); ?></p>
                                        <p class="p_double"><?php esc_html_e( 'Photos of instagrama will be shown on the page of place',
                                                'mycity' ); ?>  </p>
                                    </div>
                                </div>
                            </div>
                            <h2 class='edited' id='edited_SPETIAL-OFFER'><?php esc_html_e( 'SPETIAL OFFER',
                                    'mycity' ); ?></h2>
                            <b class='edited'
                               id='edited_Convert-every'><?php esc_html_e( '  Convert every visitor into customerers by Spetial Offer!',
                                    'mycity' ); ?>
                            </b>
                            <div id='couponsdiv' class='row'>
                                <div class='col-md-8'>
                                    <?php
                                    //Remove the empty posts that are older than one hour.


                                    $mycity_result = $wpdb->get_results( $wpdb->prepare(
                                        "SELECT * FROM $wpdb->posts WHERE post_type='places' and post_title= %s  ORDER BY post_date DESC "
                                        , esc_html__( 'Enter the place name', "mycity" )

                                    ) );

                                    $mycity_curent_date = strtotime( date( "d.m.Y h:i:s" ) );
                                    foreach ( $mycity_result as $mycity_res ) {
                                        $mycity_this_date = strtotime( $mycity_res->post_date ) + 3600; //time in seconds + one hour
                                        if ( $mycity_res->post_title == esc_html__( 'Enter the place name', "mycity" ) && $mycity_this_date < $mycity_curent_date && ( $mycity_res->ID != $mycity_postplace->ID ) ) {
                                            wp_delete_post( $mycity_res->ID );
                                        } // deleted post by id
                                    }

                                    if ( isset( $_POST['coupontitle'] ) ) {
                                        update_post_meta( (int) $mycity_postplace->ID, 'coupontitle', esc_html( $_POST['coupontitle'] ) );
                                    }
                                    ?>
                                    <b class='edited' id='edited_Title-OFFER'>
                                        <?php esc_html_e( ' Title:', 'mycity' ); ?>
                                    </b><br>
                                    <input type='text' class='form-control sp_title' name='coupontitle'
                                           placeholder='<?php esc_html_e( "Get a free drink", "mycity" ); ?>' name=''
                                           value='<?php echo @esc_html( get_post_meta( $mycity_postplace->ID, 'coupontitle', true ) ); ?>'><br>
                                    <div id='sp_title'>
                                        <div class="submit_add_message">
                                            <p><?php esc_html_e( 'Enter short description', 'mycity' ); ?></p>
                                            <p class="p_double"></p>
                                        </div>
                                    </div>
                                    <?php
                                    if ( isset( $_POST['coupondescr'] ) ) {
                                        update_post_meta( (int) $mycity_postplace->ID, 'coupondescr', sanitize_text_field( $_POST['coupondescr'] ) );
                                    }
                                    ?>
                                    <b class='edited' id='edited_Description-OFFER'>
                                        <?php esc_html_e( 'Description', 'mycity' ); ?>
                                    </b><br>
                                <textarea name='coupondescr'
                                          placeholder='<?php esc_html_e( "Just click on share button", "mycity" ); ?>'
                                          class='form-control'><?php echo
                                    esc_html( @get_post_meta( $mycity_postplace->ID, 'coupondescr', true ) ); ?></textarea>
                                    <label class='edited' id='edited_Coupon-code-OFFER'><?php esc_html_e( "Coupon code",
                                            "mycity" ); ?></label>
                                    <?php
                                    if ( isset( $_POST['coupons'] ) ) {
                                        update_post_meta( $mycity_postplace->ID, 'coupons', sanitize_text_field( $_POST['coupons'] ) );
                                    }
                                    ?>
                                    <input type='text' name='coupons' class='form-control coupons' value="<?php echo
                                    @get_post_meta( $mycity_postplace->ID, 'coupons', true ); ?>">
                                    <div id='coupons'>
                                        <div class="submit_add_message">
                                            <p><?php esc_html_e( 'Enter A-z 0-9 ', 'mycity' ); ?></p>
                                            <p class="p_double"></p>
                                        </div>
                                    </div>
                                    <br>
                                    <?php
                                    if ( isset( $_POST['coupons'] ) ) {
                                        update_post_meta( $mycity_postplace->ID, 'coupons', sanitize_text_field( $_POST['coupons'] ) );
                                    }

                                    ?>
                                    <span class='edited' id='edited_Reward-type-OFFER'>
                                <?php esc_html_e( ' Reward type:', 'mycity' ); ?>
                                </span>
                                    <br>
                                    <?php
                                    $mycity_reward_type = @get_post_meta( $mycity_postplace->ID, 'coupons', true );
                                    if ( ! $mycity_reward_type ) {
                                        $mycity_reward_type = 1;
                                    }
                                    ?>
                                    <label><input type='radio' onchange='change_reward(1)'
                                                  name='reward_type' <?php if ( $mycity_reward_type == 1 ) {
                                            echo "checked";
                                        } ?>
                                                  value=''>
                                        <?php esc_html_e( '  Users will post to social networks', 'mycity' ); ?>
                                    </label>

                                    <div id='r2' class="db_non">
                                        <?php esc_html_e( "Price", "mycity" ); ?><br>
                                        <?php
                                        if ( isset( $_POST['couponprice'] ) ) {
                                            update_post_meta( $mycity_postplace->ID, 'couponprice', sanitize_text_field( $_POST['couponprice'] ) );
                                        }
                                        ?>
                                        <input type='text' class='form-control' placeholder='10' name='couponprice'
                                               value='<?php echo
                                               esc_html( @get_post_meta( $mycity_postplace->ID, 'couponprice', true ) ); ?>'><br>
                                        <br>
                                    </div>
                                </div>
                                <div class='col-md-4'>
                                    <img class="w100p" src='http://joxi.ru/EA4Nvx1iveP8mb.jpg'>
                                </div>
                            </div>
                            <br><br>
                            <?php
                            if ( get_current_user_id() ) {
                                ?>
                                <input type='submit' name='goadd' class='sub_obj_edit  btn btn-primary'
                                       value='<?php echo
                                       esc_html__( "Send", "mycity" ); ?>'> <?php esc_html_e( "or", "mycity" ); ?> <a
                                    href='?del=1'><?php esc_html_e( "delete", "mycity" ); ?></a>
                            <?php } else {
                                ?>
                                <?php esc_html_e( 'You are not loged in', 'mycity' ); ?><?php
                            } ?>

                            <?php
                            $fmr_l = fmr_l( "template-finance.php" );
                            if ( strlen( $fmr_l ) > 3 ) {
                                ?>
                                <br><br>
                                <?php
                                esc_html_e( 'You can buy premium listing for this place on ', "mycity" );
                                echo '<a href="' . $fmr_l . '" target="_blank">' . esc_html__( "Finance", "mycity" ) . '</a> ' . esc_html__( "page", "mycity" );

                            }
                            ?>
                        </div>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function ($) {


            jQuery('#fmr-shortcode-select').change(function () {
                var s = $('#fmr-shortcode-select').val();
                jQuery('#post_content_in').insertAtCaret(" " + s + " ");

            });
            jQuery(document).on('focus', '#post_inside', function (e) {
                jQuery('.post_inside .submit_add_message').addClass('slideDownRetourn');
                jQuery('.post_inside .p_double').addClass('slideDownRetournSpeed');
            });
            jQuery(document).on('focusout', '#post_inside', function (e) {
                //jQuery('.post_inside .submit_add_message').removeClass('slideDownRetourn').addClass('slideLeft');
                //jQuery('.post_inside .p_double').addClass('slideLeft').removeClass('slideDownRetournSpeed');
            });
            jQuery(document).on('focus', '#post_street_view', function (e) {
                jQuery('.post_street_view .submit_add_message').addClass('slideDownRetourn');
                jQuery('.post_street_view .p_double').addClass('slideDownRetournSpeed');
            });
            jQuery(document).on('focusout', '#post_street_view', function (e) {
                jQuery('.post_street_view .submit_add_message').removeClass('slideDownRetourn').addClass('slideLeft');
                jQuery('.post_street_view .p_double').addClass('slideLeft').removeClass('slideDownRetournSpeed');
            });

            jQuery(document).on('click', '.close_image', function (e) {

                jQuery(this).parent().find(".dropzone").attr("style", "");
                jQuery(this).parent().find(".dz-complete").html(" ");

            });
        });
        jQuery.fn.extend({
            insertAtCaret: function (myValue) {
                return this.each(function (i) {
                    if (document.selection) {
                        // Internet Explorer
                        this.focus();
                        var sel = document.selection.createRange();
                        sel.text = myValue;
                        this.focus();
                    }
                    else if (this.selectionStart || this.selectionStart == '0') {
                        //  Firefox and Webkit
                        var startPos = this.selectionStart;
                        var endPos = this.selectionEnd;
                        var scrollTop = this.scrollTop;
                        this.value = this.value.substring(0, startPos) + myValue + this.value.substring(endPos, this.value.length);
                        this.focus();
                        this.selectionStart = startPos + myValue.length;
                        this.selectionEnd = startPos + myValue.length;
                        this.scrollTop = scrollTop;
                    } else {
                        this.value += myValue;
                        this.focus();
                    }
                })
            }
        });
    </script>
    <script>

        function initialize_map() {
            if (navigator.geolocation && MyCity_map_init_obj.geolocation == false) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;

                    var mapOptions = {center: new google.maps.LatLng(latitude, longitude), zoom: 13};
                    var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
                    var input = (document.getElementById("pac-input"));
                    var types = document.getElementById("type-selector");
                    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                    map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);
                    var autocomplete = new google.maps.places.Autocomplete(input);
                    autocomplete.bindTo("bounds", map);
                    var infowindow = new google.maps.InfoWindow();
                    var marker = new google.maps.Marker({
                        map: map,
                        draggable: true,
                        anchorPoint: new google.maps.Point(0, -29)
                    });

                    google.maps.event.addListener(autocomplete, "place_changed",
                        function () {
                            infowindow.close();
                            marker.setVisible(false);
                            var place = autocomplete.getPlace();
                            console.log(place);
                            if (!place.geometry) {
                                return;
                            }


                            if (place.geometry.viewport) {
                                map.fitBounds(place.geometry.viewport);
                            } else {
                                map.setCenter(place.geometry.location);
                                map.setZoom(17);
                            }

                            marker.setIcon(({
                                url: place.icon,
                                size: new google.maps.Size(71, 71),
                                origin: new google.maps.Point(0, 0),
                                anchor: new google.maps.Point(17, 34),
                                scaledSize: new google.maps.Size(35, 35)
                            }));
                            marker.setPosition(place.geometry.location);
                            marker.setVisible(true);
                            var crtt = place.geometry.location.lat() + "," + place.geometry.location.lng();
                            var foradre = place.formatted_address;
                            jQuery("#cordinats2").val(crtt);
                            jQuery("#cordinats2").trigger("change");
                            jQuery("#formatted_address").val(foradre);
                            jQuery("#phone").val(place.formatted_phone_number);
                            jQuery("#website2").val(place.website);
                            var address = "";
                            if (place.address_components) {
                                address = [(place.address_components[0] && place.address_components[0].short_name || ""), (place.address_components[1] && place.address_components[1].short_name || ""), (place.address_components[2] && place.address_components[2].short_name || "")].join(" ");
                            }
                            infowindow.setContent("<div><strong>" + place.name + "</strong><br>" + address);
                            infowindow.open(map, marker);
                        }
                    );
                    /*************************/

                    google.maps.event.addListener(marker, "drag", function () {
                        jQuery.getJSON("http://maps.googleapis.com/maps/api/geocode/json?latlng=" + marker.getPosition().lat() + "," + marker.getPosition().lng() + "&sensor=true_or_false", function (data, textStatus) {
                            var adress1 = data.results[0].formatted_address;
                            infowindow.setContent("<div><strong>" + adress1 + "</strong><br>" + data.results[1].formatted_address);
                            jQuery("#formatted_address").val(adress1);
                            jQuery("#cordinats2").val(marker.getPosition().lat() + "," + marker.getPosition().lng());

                        });
                        infowindow.open(map, marker);
                    });
                    function setupClickListener(id, types) {
                        var radioButton = document.getElementById(id);
                        google.maps.event.addDomListener(radioButton, "click", function () {
                            autocomplete.setTypes(types);
                        });
                    }

                    setupClickListener("changetype-all", []);
                    setupClickListener("changetype-address", ["address"]);
                    setupClickListener("changetype-establishment", ["establishment"]);
                    setupClickListener("changetype-geocode", ["geocode"]);

                    /****************************/

                    jQuery(document).ready(function () {
                        jQuery("#cordinats2").on('change', function () {
                            console.log(">>>");
                            jQuery("#instagrams").html("Connecting to Instagram...");
                            var spl = jQuery(this).val();
                            var spl2 = spl.split(",");
                            iurl = "https://api.instagram.com/v1/locations/search?client_id=a79875cd8c844916a4fa0e15b9e35272&lat=" + spl2[0] + "&lng=" + spl2[1];

                            jQuery.ajax({
                                type: "GET",
                                dataType: "jsonp",
                                url: iurl,
                                success: function (data) {
                                    jQuery("#instagrams").html("<?php esc_html_e( "Select one of checkpoint:", "mycity" );?><Br>" + iurl);

                                    jQuery.each(data.data, function (index, element) {
                                        jQuery("#instagrams").append("<a href='#' onclick='jQuery(\"#instaid\").val(" + element.id + ");return false'><i class='fa fa-globe'></i>" + element.name + "</a>");
                                    });
                                }
                            });
                        });
                    });

                });

            } else {
                var mapOptions = {
                    center: new google.maps.LatLng(parseFloat(MyCity_map_init_obj.lat), parseFloat(MyCity_map_init_obj.longu)),
                    zoom: parseInt(MyCity_map_init_obj.zum)
                };
                var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
                var input = (document.getElementById("pac-input"));
                var types = document.getElementById("type-selector");
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.bindTo("bounds", map);
                var infowindow = new google.maps.InfoWindow();
                var marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    anchorPoint: new google.maps.Point(0, -29)
                });

                google.maps.event.addListener(autocomplete, "place_changed",
                    function () {
                        infowindow.close();
                        marker.setVisible(false);
                        var place = autocomplete.getPlace();
                        console.log(place);
                        if (!place.geometry) {
                            return;
                        }


                        if (place.geometry.viewport) {
                            map.fitBounds(place.geometry.viewport);
                        } else {
                            map.setCenter(place.geometry.location);
                            map.setZoom(17);
                        }

                        marker.setIcon(({
                            url: place.icon,
                            size: new google.maps.Size(71, 71),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(35, 35)
                        }));
                        marker.setPosition(place.geometry.location);
                        marker.setVisible(true);
                        var crtt = place.geometry.location.lat() + "," + place.geometry.location.lng();
                        var foradre = place.formatted_address;
                        jQuery("#cordinats2").val(crtt);
                        jQuery("#cordinats2").trigger("change");
                        jQuery("#formatted_address").val(foradre);
                        jQuery("#phone").val(place.formatted_phone_number);
                        jQuery("#website2").val(place.website);
                        var address = "";
                        if (place.address_components) {
                            address = [(place.address_components[0] && place.address_components[0].short_name || ""), (place.address_components[1] && place.address_components[1].short_name || ""), (place.address_components[2] && place.address_components[2].short_name || "")].join(" ");
                        }
                        infowindow.setContent("<div><strong>" + place.name + "</strong><br>" + address);
                        infowindow.open(map, marker);
                    }
                );


                google.maps.event.addListener(marker, "drag", function () {
                    jQuery.getJSON("http://maps.googleapis.com/maps/api/geocode/json?latlng=" + marker.getPosition().lat() + "," + marker.getPosition().lng() + "&sensor=true_or_false", function (data, textStatus) {
                        var adress1 = data.results[0].formatted_address;
                        infowindow.setContent("<div><strong>" + adress1 + "</strong><br>" + data.results[1].formatted_address);
                        jQuery("#formatted_address").val(adress1);
                        jQuery("#cordinats2").val(marker.getPosition().lat() + "," + marker.getPosition().lng());

                    });
                    infowindow.open(map, marker);
                });
                function setupClickListener(id, types) {
                    var radioButton = document.getElementById(id);
                    google.maps.event.addDomListener(radioButton, "click", function () {
                        autocomplete.setTypes(types);
                    });
                }

                setupClickListener("changetype-all", []);
                setupClickListener("changetype-address", ["address"]);
                setupClickListener("changetype-establishment", ["establishment"]);
                setupClickListener("changetype-geocode", ["geocode"]);


                jQuery(document).ready(function () {
                    jQuery("#cordinats2").on('change', function () {
                        console.log(">>>");
                        jQuery("#instagrams").html("<?php esc_html_e( "Connecting to Instagram...", "mycity" );?>");
                        var spl = jQuery(this).val();
                        var spl2 = spl.split(",");
                        iurl = "https://api.instagram.com/v1/locations/search?client_id=a79875cd8c844916a4fa0e15b9e35272&lat=" + spl2[0] + "&lng=" + spl2[1];

                        jQuery.ajax({
                            type: "GET",
                            dataType: "jsonp",
                            url: iurl,
                            success: function (data) {
                                jQuery("#instagrams").html("<?php esc_html_e( "Select one of checkpoint:", "mycity" );?><Br>" + iurl);
                                alert(data.data);
                                jQuery.each(data.data, function (index, element) {
                                    jQuery("#instagrams").append("<a href='#' onclick='jQuery(\"#instaid\").val(" + element.id + ");return false'><i class='fa fa-globe'></i>" + element.name + "</a>");
                                });
                            }
                        });
                    });
                });
            }


        }

    </script>

    <script>
        jQuery(document).ready(function ($) {
            $("#mycity_sub_sh").click(function (e) {
                $('#post_content_in').insertAtCaret("[" + $('#myModal .modal-content i.active').data('icon') + "]");
            });
        });


        jQuery.fn.extend({
            insertAtCaret: function (myValue) {
                return this.each(function (i) {
                    if (document.selection) {
                        // Internet Explorer
                        this.focus();
                        var sel = document.selection.createRange();
                        sel.text = myValue;
                        this.focus();
                    }
                    else if (this.selectionStart || this.selectionStart == '0') {
                        //  Firefox and Webkit
                        var startPos = this.selectionStart;
                        var endPos = this.selectionEnd;
                        var scrollTop = this.scrollTop;
                        this.value = this.value.substring(0, startPos) + myValue + this.value.substring(endPos, this.value.length);
                        this.focus();
                        this.selectionStart = startPos + myValue.length;
                        this.selectionEnd = startPos + myValue.length;
                        this.scrollTop = scrollTop;
                    } else {
                        this.value += myValue;
                        this.focus();
                    }
                })
            }
        });
    </script>
    <!-- Modal -->

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo esc_html_e( 'Icons', 'mycity' ); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12"><b><?php echo esc_html( 'Trendy icon name', 'mycity' ); ?> </b></div>
                    </div>

                    <?php
                    global $mycity_fmr_icon;
                    $exclude = array(
                        'fmr-icon-114',
                        'fmr-icon-268',
                        'fmr-icon-2412',
                        'fmr-icon-3516',
                        'fmr-icon-4412',
                        'fmr-icon-69',
                        'fmr-icon-340',
                        'fmr-icon-483',
                        'fmr-icon-2103',
                        'fmr-icon-2104',
                        'fmr-icon-2104',
                        'fmr-icon-4519'
                    );

                    foreach ( $mycity_fmr_icon as $v ) {
                        if ( in_array( $v, $exclude ) ) {
                            continue;
                        }
                        ?>

                        <i class="fmr extra_admin_1 <?php echo esc_attr( $v ); ?>"
                           data-icon="<?php echo esc_html( $v ); ?>"
                           onclick='jQuery(".extra_admin_1").removeClass("active"); jQuery(this).addClass("active"); '> <?php ?></i>
                        <?php

                    }
                    ?>
                    <div class="row">
                        <div class="col-md-12"><b><?php esc_html_e( 'Font awesome icon name',
                                    'mycity' ); ?> </b></div>
                    </div>


                    <?php
                    global $mycity_fa;
                    foreach ( $mycity_fa as $v ) {
                        ?>
                        <i class="extra_admin_1 fa <?php echo esc_attr( $v ); ?>"
                           data-icon="<?php echo esc_html( $v ); ?>"
                           onclick='jQuery(".extra_admin_1").removeClass("active"); jQuery(this).addClass("active"); '> <?php ?></i>
                        <?php
                    }
                    ?>

                </div>
                <div class="modal-footer">
                    <button id="mycity_sub_sh" type="button" class="btn btn-primary"
                            data-dismiss="modal"><?php echo esc_html_e( 'Insert Icons', 'mycity' ); ?></button>
                </div>
            </div>
        </div>
    </div>
    <?php

    get_footer();

}
?>