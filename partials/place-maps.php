<div class="bs-example">
                        <?php
                        $mycity_allowed_html = array(
                            'b' => array(),
                            'iframe' => array(
                                'class' => array(),
                                'src' => array(),
                                'width' => array(),
                                'height' => array(),
                                'frameborder' => array(),
                                'style' => array(),
                                'allowfullscreen' => array(),
                            ),
                            'br' => array(),
                            'strong' => array());
                        ?>
                            <div class="google_place">
                                <ul class="gp_nav">
                                    <li class="tabs_controls_item">
                                        <a href="#" class="active"><i class="fa fa-map-marker"></i><?php  esc_html_e("Map","mycity"); ?></a>
                                    </li>
                                   <?php
								   if (get_post_meta(get_the_ID(), 'post_inside', true)) {
								   ?>
								    <li class="tabs_controls_item">
                                        <a href="#"><i class="fa fa-location-arrow"></i><?php  esc_html_e("Inside View","mycity"); ?></a>
                                    </li>
								   <?php } ?>
                                    <?php
								   if (get_post_meta(get_the_ID(), 'post_street_view', true)) {
								   ?> 
								    <li class="tabs_controls_item">
                                        <a href="#"><i class="fa fa-globe"></i><?php  esc_html_e("Street View","mycity");?></a>
                                    </li>
									<?php } ?>
                                </ul>
                                <ul class="gp_content">
                                    <li class="tabs_item active">  
                                        <div id="map_place" class="map_place"></div>
                                   </li>
                                    <li class="tabs_item">
                                            <?php
                                if (get_post_meta(get_the_ID(), 'post_inside', true)):
                                    ?>
                                <div class='google_view'>
                                    <?php
                                    echo get_post_meta(get_the_ID(), 'post_inside', true);
                                    ?></div>
                                    <?php
                                    endif; ?>
                                    </li>
                                    <li class="tabs_item">
                                           <?php if (get_post_meta(get_the_ID(), 'post_street_view', true)):
                                    ?>
                                    <div class='google_view'>
                                        <?php
                                        echo wp_kses(get_post_meta(get_the_ID(), 'post_street_view', true), $mycity_allowed_html);
                                        ?></div>
                                        <?php
                                        endif; ?>
									</li>
         </ul>
     </div>  
</div>