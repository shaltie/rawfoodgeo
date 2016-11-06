<?php
global $mycity_is_index;

//get cat id

$mycity_category = @array_pop(get_the_category());

if(isset($mycity_category)) {
    $mycity_cat = @get_cat_ID($mycity_category->cat_name);
    if ($mycity_is_index) { // is the index page cat = 0
        $mycity_cat = 0;
    }
}

$mycity_category = get_category( get_query_var( 'cat' ) );
if(isset($mycity_category->cat_ID)) {
@$mycity_cat = $mycity_category->cat_ID;

}


$posts_per_page = (int)esc_html(get_option('posts_per_page'));
$cats_arr = array();
if (!empty($GLOBALS['mycity_wp_infinitepaginate'])) {
    $cats_arr = $GLOBALS['mycity_wp_infinitepaginate'];
} else {
    $cats_arr = array(
        'paged' => 1,
        'offset' => 0,
        'showposts' => $posts_per_page,
        'cat' => esc_html($cat));
}
$custom_query = new WP_Query($cats_arr);
$i = 0;
$class = "";
$mycity_color = get_theme_mod("colors_m_DD3333", "DD3333"); //red to rgb
$mycity_int = hexdec($mycity_color);
$mycity_red_rgba = array(
    0 => 0xFF & ($mycity_int >> 0x10),
    1 => 0xFF & ($mycity_int >> 0x8),
    2 => 0xFF & $mycity_int);

?>


<?php
if ($custom_query->have_posts()):
    while ($custom_query->have_posts()):
        $custom_query->the_post();
        $mycity_thumbnail = get_the_post_thumbnail(get_the_id(), 'mycity_squarex320x201');
        preg_match_all('#src="(.*?)"#si', $mycity_thumbnail, $thumb_url);
        $mycity_thumb = "";
        $opacity = "0.3";
        if (isset($thumb_url[1][0]))
            $mycity_thumb = $thumb_url[1][0];





?>
  <div class="box col2">
   <div class="col-md-12 place_index_item  wow fadeIn">
        <div class="place_inn">
           <?php
           if(strlen($mycity_thumb) > 3):
           ?>
           <div class="img_place_inn">
        
                <img src="<?php  echo esc_url( $mycity_thumb); ?>" alt="">
        
          </div>   <?php endif; ?>
                
          <div class="pl_descr">
            <a href="<?php  echo esc_url(get_the_permalink()); ?>"><?php    the_title(); ?></a>
           
            <span>
             <?php 
             
              $short_desc = get_post_meta( $post->ID, 'mycity_short_description' , true ) ;
              if(strlen(trim($short_desc)) > 2) {
                echo wp_kses_post($short_desc);
              } else {
                echo str_replace(array('<p>','</p>'),array('',''), get_the_excerpt()); 
              }
             
             
             
             ?>
            </span>
            <p class="pl_descr_date"><?php echo get_the_date(); ?></p>
          </div>
        </div>
</div>
  </div>

<?php
     $i++;
     endwhile;
     else:
    ?>        



<?php
     endif;
     wp_reset_postdata();
    ?>



  



