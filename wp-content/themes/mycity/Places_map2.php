<?php
/**
 * Template Name: PLACE-MAP 2 (map2)
 * Preview: http://mycity.vioo.ru/wp-content/themes/mycity_4/02.html
 */

?>

<?php get_header();
global $MyCity_class;

?>
<!--map-->
<script>
    var mapObject,
        markers = [],
        markersData = {
            <?php
            $mycity_categories = get_categories("taxonomy=places_categories&hide_empty=0");
            $places_categories = array();
            //var_dump($mycity_categories);
            foreach ($mycity_categories as $place_cat)
            {
            // var_dump($place_cat->slug);

            $mycity_init_maps_point_by_term_slug = mycity_init_maps_point_by_term_slug($place_cat->term_id, "", 300, 200);
            if (!$mycity_init_maps_point_by_term_slug) {
                continue;
            }
            ob_start();
            ?>
            '<?php echo sanitize_text_field($place_cat->slug);?>': [
                <?php
                echo wp_kses($mycity_init_maps_point_by_term_slug, array("i" => array("class" => array())));

                ;?>]
            <?php
            $places_categories[] = ob_get_clean();

            }
            echo implode(",", wp_kses($places_categories, array("i" => array("class" => array()))));
            ?>
        };

    function initialize_map() {

        document.querySelector('header').className += " sticky";
        document.querySelector('.mycity_o-grid__item').className += ' grid_item_fix';


        loadScript("<?php echo esc_url(get_template_directory_uri()); ?>/js/infobox.js", after_load);
    }

    function after_load() {
        initialize_new();
        <?php
        $mycity_term = "";
        if (isset($wp_query->query_vars['term'])) {
            $mycity_term = sanitize_text_field($wp_query->query_vars['term']);
        }

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


<!--map-->
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
<?php } ?>
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
<div id="map" class="map"></div>

<!--/map-->
<div class="row site">
    <div class="col-md-1 general_menu inner">

        <ul>
            <!--li>
                <a onclick="javascript:initialize_new();" href="javascript:initialize_new();"
                   class="active">

                </a>
            </li-->
            <?php

            $all_cats_arr = array();
            $mycity_cat_parent_arr = array();
            $mycity_categories = get_categories("child_of=0&paren=0&taxonomy=places_categories&hide_empty=0");
            $places_categories = array();

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
                    <a
                        href="#"
                        onclick="toggleMarkers2(<?php echo esc_html(mycity_js_array($arr_palces)); ?>);"

                        class="<?php echo esc_html($place_cat->slug); ?>">

                        <i class="<?php echo sanitize_html_class($class) . " " . sanitize_html_class($icon); ?>"></i>
                    </a>
                </li>
                <?php
                unset($mycity_categories);
                unset($mycity_cat_parent_arr);
                unset($places_categories);


            }
            ?>
            <li>
                <a
                    href="#"
                    onclick="toggleMarkers2(<?php echo esc_html(mycity_js_array($all_cats_arr)); ?>);"

                    class="all_cats">
                    <?php esc_html_e('All', 'mycity'); ?>
                </a>
            </li>

        </ul>

    </div>
    <!--Profile-->


    <!--/my friends-->
    <!--my news-->

    <!--/Profile-->
    <!--Content-->
    <div class="col-md-11 side-bar" id="cont">
        <!--header-->

        <!--/header-->
        <!--Map open (for adaptive)-->
        <div class="row map_open">
            <div class="col-md-12">
                <a href="#" id="map_open">Show map</a>
            </div>
        </div>
        <!--/Map open (for adaptive)-->
        <!--Category menu-->
        <div class="row">

            <?php


            // cahe res
            $map_lop = get_transient('mycity_places_map');
            if (false === $map_lop) {
                ob_start();
                get_template_part('partials/map', 'loop');
                $date = ob_get_clean();
                set_transient('mycity_places_map', $date, 60 * 60);
                echo $date;
                unset($date);
            } else {
                echo get_transient('mycity_places_map');
            }


            ?>


        </div>
        <!--/Category menu-->
        <!--Search-->
        <div class="row search_inner_box">
            <div class="col-md-12">
                <form action="<?php echo esc_url(get_home_url('/')); ?>/places/" method='get'>
                    <input type="hidden" name="showas" value="list">
                    <input type="text" class="form-control input-sm" name="search"
                           placeholder="<?php esc_html_e("Type...", "mycity"); ?>"/>
                    <button type="submit" class="btn_promo_search-map"><?php esc_html_e("Search", "mycity"); ?></button>

                    <a href="" class="btn_promo_show-place"
                       onclick='find_me();return false'><?php esc_html_e("Show places near me", "mycity"); ?></a>

                </form>
            </div>
        </div>
        <!--/search-->

    </div>
    <!--/Content-->
</div>

<?php

@wp_footer();
?><!--Script for worked left smile categoryes menu-->
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        jQuery(".inner ul li a").each(function (i) {
            jQuery(".inner ul li a:eq(" + i + ")").click(function () {
                ///alert(2);
                var tab_id = i + 1;
                jQuery(".inner ul li a").removeClass("active");
                jQuery("#tabs .active").removeClass("active");
                jQuery(this).addClass("active");
                jQuery("#tabs div").stop(false, false).hide();
                jQuery(".places_list_my, .places_list_my div ").stop(false, false).show();
                jQuery("#tab" + tab_id).stop(false, false).show();
                //toggleMarkers( jQuery(this).attr('class'));
                //return false;
            })
        });

        $('.all_cats').click(function () {
            $('.tab2').addClass("active");
        });
    })
</script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#tabs_point li a").each(function (i) {
            jQuery("#tabs_point li a:eq(" + i + ")").click(function () {
                //alert(3);
                var tab_id = i + 1;
                jQuery("#tabs_point li a").removeClass("active");
                jQuery(".tabs_block_point .active").removeClass("active");
                jQuery(this).addClass("active");
                jQuery(".tabs_block_point div").stop(false, false).hide();
                jQuery("#point_tab" + tab_id).stop(false, false).show();
                return false;
            })
        })
    })
</script>
<!--/Script for worked left smile categoryes menu-->
<!--Script for worked profile page-->

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('.general_menu li a').click(function (e) {
            e.preventDefault();

        });
        jQuery('#link_open').on('click', function () {
            if (jQuery('#link_open').hasClass("clooses")) {
                jQuery("#open_span").removeClass("close_span").addClass("open_span");
                jQuery("#profile").removeClass("profile_closed");
                jQuery("#link_open").removeClass("clooses");
                jQuery("#cont").addClass("none");
            }
            else {
                jQuery("#open_span").addClass("close_span").removeClass("open_span");
                jQuery("#profile").addClass("profile_closed");
                jQuery("#link_open").addClass("clooses");
                jQuery("#cont").removeClass("none");
            }
        })
        jQuery('#map_open').on('click', function () {
            jQuery("#cont").addClass("none");
            jQuery("#Show_cont").removeClass("none");

        })
        jQuery('#Show_cont').on('click', function () {
            jQuery("#cont").removeClass("none");
        })
    });
</script>
<script>

</script>
<?php
if (isset($wp_query->query["places_categories"])) {
    ?>
    <script>
        jQuery(document).ready(function ($) {
            setTimeout(function () {
                $(".<?php echo esc_attr($wp_query->query["places_categories"]);?>").click();
                console.log($(".<?php echo esc_attr($wp_query->query["places_categories"]);?>"));
            }, 2000);
        });
    </script>
<?php } ?>

</body>
</html>


