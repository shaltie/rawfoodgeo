<div id="myAffix2">
    <ul class="places_cat">
        <?php
        $mycity_categories  = get_categories("taxonomy=places_categories&hide_empty=0");
        foreach ($mycity_categories  as $place_cat) {
            $class = (preg_match('/fmr/', get_option("fa_icon_" . (int)$place_cat->
                term_id))) ? " fmr " : " fa ";
            ?>
            <li><a href="<?php echo esc_url(get_term_link($place_cat)); ?>?showas=list"
                   class="<?php echo
                   esc_html($place_cat->slug); ?>"><i
                        class="<?php echo esc_html( $class . ' '. get_option("fa_icon_" . (int)$place_cat->
                            term_id)); ?>"></i><?php echo esc_html($place_cat->name); ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
    <div class="tag">
        <h3 class='edited' id='edited_tag_h3_grid'>
            <?php esc_html_e('Tag', 'mycity'); ?>
        </h3>

        <ul>
            <?php
            //===================tags

            global $mycity_arry_tags;
            $mycity_result = $wpdb->get_results($wpdb->prepare(
                "SELECT * FROM  `$wpdb->postmeta`  WHERE  meta_key=%s and meta_value !=''  ORDER BY meta_value DESC",
                '_tags'
            ));
            foreach ($mycity_result as $res) {

                $tag = explode(",", $res->meta_value);
                for ($i = 0; $i < count($tag); $i++) {
                    $mycity_arry_tags[] = $tag[$i];
                }
            }
            $mycity_result = array_unique($mycity_arry_tags);
            sort($mycity_result);
            for ($j = 0; $j < count($mycity_result); $j++) {
                echo '<li><a href="?showas=list&#038;tags=' . esc_html($mycity_result[$j]) . '">' . esc_html($mycity_result[$j]) .
                    '</a></li>' . "\n";

            }

            ?>
        </ul>
    </div>
</div>