<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 11.12.2015
 * Time: 9:35
 */?>
<script>
    var
        mapObject,
        markers = [],
        markersData = {<?php

		$mycity_categories=  get_categories("taxonomy=places_categories&hide_empty=0");
		$places_categories = array();

		foreach ($mycity_categories  as $mycity_place_cat) {
			$mycity_init_maps_point_by_term_slug = mycity_init_maps_point_by_term_slug($mycity_place_cat->term_id);
			if (!$mycity_init_maps_point_by_term_slug) continue;

               $places_categories[] = "'" . esc_html($mycity_place_cat->slug)."': [".  print_r($mycity_init_maps_point_by_term_slug,true) ."]";
        }

         implode(",",$places_categories);

        ?>
        };
    var global_scrollwheel = false;
    var global_drag = false;

    function initialize_map() {
        loadScript("<?php echo esc_url( get_template_directory_uri() ); ?>/js/infobox.js",after_load);
    }

    function after_load() {

        var global_scrollwheel = true;
        var markerClusterer = null;
        var markerCLuster;
        var Clusterer;

        initialize_new();

    }
</script>
<div class="index_map" id="map"></div>
