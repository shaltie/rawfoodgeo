<?php
global $MyCity_class; ?>
<div class="col-md-12">
    <div id="tabs">
        <?php
        $mycity_cat_parent_arr = array();
        $mycity_categories = get_categories("parent=0&taxonomy=places_categories&hide_empty=0");
        $places_categories = array();
        $i = 1; //count tabs
        foreach ($mycity_categories as $place_cat) {
            ?>
            <div id="tab<?php echo $i; ?>" class="active tab2">
                <h5 class="cat">  <?php echo esc_html($place_cat->name); ?> </h5>
                <?php
                $chald = get_term_children($place_cat->term_id, 'places_categories');
                $chald = implode(',', $chald);
                if (!(empty($chald))) {
                    $args = array(
                        'taxonomy' => 'places_categories',
                        'hide_empty' => 0,
                        'include' => $chald
                    );
                    $mycity_categories2 = get_categories($args);
                    //var_dump( $mycity_categories2);
                    ?>
                    <ul class="catalog clearfix">
                        <?php
                        foreach ($mycity_categories2 as $place_cat_chald) {
                            // if($place_cat_chald->count < 1) continue;

                            ?>
                            <li>
                                <a onclick="javascript:toggleMarkers('<?php echo esc_html($place_cat_chald->slug); ?>');"

                                   class="<?php echo esc_html($place_cat_chald->slug); ?>">
                                    <?php echo esc_html($place_cat_chald->name);
                                    ?><span> <?php echo esc_html($place_cat_chald->count); ?></span></a></li>
                            <?php
                        } ?>
                    </ul>
                    <?php
                }
                $mycity_args = array('post_type' => 'places', 'post_status' => 'publish',
                    'showposts' => sanitize_text_field(get_theme_mod('map_style_how_show_places', 0)),
                    'post__not_in' => $MyCity_class->get_empty_places(),

                );
                $mycity_args['tax_query'] = array(array(
                    'taxonomy' => 'places_categories',
                    'terms' => sanitize_text_field($place_cat->slug),
                    'field' => 'slug'));
                $mycity_query_my2 = new WP_Query($mycity_args);
                $GLOBALS['mycity_place_cat_slug'] = sanitize_text_field($place_cat->slug);
                $GLOBALS['mycity_query_my2'] = $mycity_query_my2;
                get_template_part('partials/loop', 'placelist');


                ?>
            </div>
            <?php
            $i++;
        }
        unset($mycity_categories);
        ?>
    </div>
</div>