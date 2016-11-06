<?php
global $mycity_dditional;
$mycity_dditional = "Places_map";
get_header(); ?>
    <script>
        var showsimplemap = 1;
        var mapObject,
            markers = [],
            markersData = {
                <?php
                $mycity_categories = get_categories("taxonomy=places_categories&hide_empty=0");
                $places_categories = array();
                foreach ($mycity_categories as $place_cat)
                {

                $mycity_init_maps_point_by_term_slug = mycity_init_maps_point_by_term_slug($place_cat->term_id);
                if (!$mycity_init_maps_point_by_term_slug) continue;
                ob_start();
                ?>
                '<?php echo sanitize_text_field($place_cat->slug);?>': [
                    <?php
                    echo wp_kses($mycity_init_maps_point_by_term_slug, array());

                    ;?>]
                <?php
                $places_categories[] = ob_get_clean();

                }
                echo implode(",", wp_kses($places_categories, array()));
                ?>
            };

        function initialize_map() {

            document.querySelector('header').className += "sticky";
            document.querySelector('.mycity_o-grid__item').className += ' grid_item_fix';


            loadScript("<?php echo esc_url(get_template_directory_uri()); ?>/js/infobox.js", after_load);
        }

        function after_load() {
            initialize_new();
            <?php
            $mycity_term = "";
            if (isset($wp_query->query_vars['term'])) $mycity_term = sanitize_text_field($wp_query->query_vars['term']);

            if ($mycity_term) {
            ?>
            toggleMarkers('<?php echo esc_html($mycity_term);?>');
            <?php
            }
            ?>
        }

    </script>
<?php
get_sidebar();
?>
    <!-- Site Overlay -->
    <div class="site-overlay"></div>
    <div class="container-fluid menu mobile">
        <div class="row">
            <div class="col-md-12">
                <span><?php esc_html_e('Category menu', 'mycity'); ?></span>
                <a href="#" id="close_menu"><i class="fa fa-times"></i></a>
                <script>


                    function toggleMarkers2(category) {
                        hideAllMarkers();
                        closeInfoBox();

                        //delet  Clusterer
                        Clusterer.clearMarkers();
                        category.forEach(function (item) {
                            if ('undefined' === typeof markers[item])
                                return false;
                            console.log(item);
                            console.log(markers[item]);

                            markers[item].forEach(function (marker) {
                                marker.setMap(mapObject);
                                marker.setAnimation(google.maps.Animation.DROP);

                            });
                            // Clusterer add new Markers
                            Clusterer.addMarkers(markers[item], true);
                        });


                        // Clusterer redraw
                        Clusterer.redraw();
                    };
                </script>
                <ul class="mapmenus">


                    <?php
                    $mycity_cat_parent_arr = array();
                    $mycity_categories = get_categories("child_of=0&paren=0&taxonomy=places_categories&hide_empty=0");
                    $places_categories = array();
                    $all_cats_arr = array();
                    foreach ($mycity_categories as $place_cat) {
                        $termchildren = get_term_children($place_cat->term_id, 'places_categories');


                        if ($place_cat->parent > 0) {
                            $mycity_cat_parent_arr[$place_cat->parent][] = $place_cat->slug;
                            continue;

                        }
                        $icon = get_option("fa_icon_" . (int)$place_cat->term_id);
                        $class = (preg_match('/fmr/', $icon)) ? " fmr " : " fa ";
                        $arr_palces = array();
                        $arr_palces[] = $place_cat->slug;
                        if (count($termchildren) > 0) {
                            $arr_temp = array();
                            foreach ($termchildren as $cat_id) {
                                $cat_ob = get_category($cat_id);
                                $arr_temp[] = $cat_ob->slug;

                            }
                            $arr_palces = array_merge($arr_palces, $arr_temp);

                        }
                        $all_cats_arr = array_merge($all_cats_arr, $arr_palces);
                        ?>
                        <li>
                            <a data-marker="<?php echo esc_html(mycity_js_array($arr_palces)); ?>"
                               href="#"
                               onclick="toggleMarkers2(<?php echo esc_html(mycity_js_array($arr_palces)); ?>);"

                               class="<?php echo esc_html($place_cat->slug); ?>">

                                <i class="<?php echo sanitize_html_class($class) . " " . sanitize_html_class($icon); ?>"></i>
                            </a>
                        </li>
                        <?php

                    }
                    ?>
                    <li>
                        <a data-marker="<?php echo esc_html(mycity_js_array($arr_palces)); ?>"
                           href="#"
                           onclick="toggleMarkers2(<?php echo esc_html(mycity_js_array($all_cats_arr)); ?>);"

                           class="all_cats">
                            <?php esc_html_e('All', 'mycity'); ?>
                      </a>
                    </li>
                    <li class="mobile_menu">
                        <a href="#">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
               
                </ul>
            </div>

        </div>
    </div>
    <div class="ov" id="container">

        <!--Header-->
        <!--categori menu-->

    </div>
    <!--map-->
    <script>

        jQuery(document).ready(function ($) {
            $(document).on("click", '.mapmenus a', function (e) {
                e.preventDefault();
                $(this).addClass('.activmap');
            });
        });
    </script>
<?php

if (isset($wp_query->query["places_categories"])) {
    ?>
    <script>

        jQuery(document).ready(function ($) {
            $(".<?php echo esc_attr($wp_query->query["places_categories"]);?>").addClass('activmap');
            $(document).on("click", '.mapmenus a', function (e) {

                $('.mapmenus a').removeClass('activmap');
                toggleMarkers($(this).attr('class'));
                $(this).addClass('.activmap');
            });
        });
    </script>
    <script>
        jQuery(document).ready(function ($) {
            setTimeout(function(){
                $(".<?php echo esc_attr($wp_query->query["places_categories"]);?>").click();
                console.log($(".<?php echo esc_attr($wp_query->query["places_categories"]);?>"));
            },2000);
        });
    </script>
<?php } ?>
    <div id="map" class="map"></div>
    <!--/map-->


<?php
get_footer();