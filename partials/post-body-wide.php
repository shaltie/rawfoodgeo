<div class="item_wide_container">
	<div class="<?php global $MyCity_class; echo  esc_attr($MyCity_class->mycity_container_class()); ?>  shortcodes">
		<div class="row">
			<div class="col-md-12 single_post_row">
				<div class="place_li_cont">
					<div class="post container p_style_one open"  id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="item_border"></div>
						<div class="post_content">	
						<?php
						if( have_posts()):
							while ( have_posts() ) :
								the_post();
								the_content();
							endwhile;
						else:
						the_content();
						endif;
							if (get_theme_mod('single_post_single_post_control') == false) {
								get_template_part("partials","subscribe");
							}	
							if (!is_page())
							{
							
								get_template_part("partials/single","footerpost");
								
								if (strlen(esc_html(the_author_meta('description', $post->post_author))) > 0) {
									get_template_part("partials/single","autorinfo");
								}
							
							}
                            ?>
                            <div class="post_pagination">
                                <?php 
                                echo mycity_link_pages();
                               ?>
                            </div>
						</div>
						<?php
						if ( comments_open() || get_comments_number() ) :
							echo '<div class="post_content">';
		                     comments_template();
							echo '</div>';
	                    endif;					
                            
						?>
					</div>		
				</div>
			</div>
		</div>
	</div>
</div>