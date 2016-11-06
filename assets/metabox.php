<?php



add_action('add_meta_boxes', 'mycity_custom_meta_box');

function mycity_custom_meta_box($postType)
{

    $postType = (isset($postType)) ? $postType : "post";
    add_meta_box('mycity_meta_box',
        'Mycity Custom settings',
        'mycity_header_meta_box',
        $postType,
        'side',
        'low');
}

add_action('save_post', 'mycity_save_metabox');

function mycity_save_metabox()
{
    global $post;

    if ( isset($_POST["mycity_hide_header"]) ) {
        $meta_element_class = $_POST['mycity_hide_header'];
        update_post_meta($post->ID, 'mycity_hide_header', $meta_element_class);
    }else{
        @delete_post_meta($post->ID, 'mycity_hide_header');
    }	

}

function mycity_header_meta_box($post)
{
    $mycity_header = get_post_meta($post->ID, 'mycity_hide_header', true);

    ?>
    <div class="inside">

        <label><strong><?php echo esc_html('Small header','fmr'); ?></strong>
            <input type="checkbox" name="mycity_hide_header" <?php checked($mycity_header,'on'); ?> /></label>
       

    </div>

    <?php
}



add_action( 'add_meta_boxes', 'mycity_adding_new_metaabox' );              
function mycity_adding_new_metaabox($postType) 
{   
        $types = array('post', 'page');
	if(in_array($postType, $types)){
        add_meta_box('html_myid_61_section2',
         esc_html__('Short description (text near title)','mycity'),
          'mycity_my_output_function',
          $postType,
           'normal',
           'high');
    }
}

function mycity_my_output_function( $post ) 
    {
    //so, dont ned to use esc_attr in front of get_post_meta
    $valueeee2=  get_post_meta((int)$_GET['post'], 'mycity_short_description' , true ) ;
    wp_editor( htmlspecialchars_decode($valueeee2), 'mettaabox_ID_stylee', 
    $settings = array('textarea_name'=>'mycity_Inputdesc',
    'textarea_rows' => 3, 'media_buttons' => false) );
    }


function mycity_save_my_postdata( $post_id ) 
{                   
    if (!empty($_POST['mycity_Inputdesc']))
        {
        $datta=htmlspecialchars($_POST['mycity_Inputdesc']);
        update_post_meta($post_id, 'mycity_short_description', $datta );
        }
}
add_action( 'save_post', 'mycity_save_my_postdata' );  





/*>>>>>>>>>>------------------Connect to the admin panel js---------------------*/
function mycity_true_include_myuploadscript() {
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'mycity_true_include_myuploadscript' );
/***************************************/ 
function mycity_true_image_uploader_field( $name, $value = '', $w = 115, $h = 90) {
    $default = get_stylesheet_directory_uri() . '/img/c_interior.png';
    if( $value ) {
        $image_attributes = wp_get_attachment_image_src( $value, array($w, $h) );
        $src = $image_attributes[0];
    } else {
        $src = $default;
    }
    echo '
    <div>
        <img data-src="' . esc_url($default) . '" src="' . esc_url($src) . '" width="' . esc_attr($w) . 'px" height="' . esc_attr($h) . 'px" />
        <div>
            <input type="hidden" name="' . esc_attr($name) . '" id="' . esc_attr($name) . '" value="' . esc_attr($value) . '" />
            <button type="submit" class="upload_image_button button">'.__( "Upload", "mycity" ).'</button>
            <button type="submit" class="remove_image_button button">&times;</button>
        </div>
    </div>
    ';
}
/***************************************/ 
add_action( 'add_meta_boxes', 'mycity_add_my_custom_box' );
add_action( 'save_post', 'mycity_my_save_postdata' );
function mycity_add_my_custom_box()
{	
    add_meta_box(
        'my_sectionid',
        'MAP', 
        'mycity_my_custom_box',
        'places',
        'advanced',
        'low'
    );
}
function mycity_my_custom_box( $post )
{
if (substr_count($_SERVER['SCRIPT_URL'],'wp-admin')) {
	$pgs=get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'template-add.php'
	));

	if (isset($pgs[0]->ID) && $pgs[0]->ID) {
    ?>
    <script>
    window.location='<?php echo get_permalink($pgs[0]->ID);?>';
    </script>
    <?php
	} else {
	echo esc_html__("Add a page with template template-add.php !","mycity")."<script>alert('".esc_html__("Add a page with template template-add.php !","mycity")."')</script>";
	}
	return true;
}
$metadata=get_post_meta($post->ID, '_myfield', TRUE);
$meta_adress=get_post_meta($post->ID, '_adress', TRUE);
$meta_phone=get_post_meta($post->ID, '_meta_phone', TRUE);
$meta_website=get_post_meta($post->ID, '_meta_website', TRUE);
if( function_exists( 'mycity_true_image_uploader_field' ) ) {
        mycity_true_image_uploader_field( 'uploader_custom', get_post_meta($post->ID, 'uploader_custom',true) );
    }
echo '
<div id="canvas2">
<form>
    <input id="pac-input" class="controls" type="text"      placeholder="'.__( "Enter a location", "mycity" ).'">
    <div id="type-selector" class="controls control-group">
    <label>  '.__( "Coordinates:", "mycity" ).' </label><input id="cordinats" type="text" name="myplugin_new_field" value="';        
    if ($metadata==FALSE) echo '';
    else echo esc_attr($metadata);
    echo '"/>
    <label> '.__( "Formatted Address", "mycity" ).'</label>
    <input id="formatted_address" data-geo="formatted_address" name="formatted_address" type="text" value="';
    if ($meta_adress==FALSE) echo '';
    else echo esc_attr($metadata);
    echo   '">
    <label>'.__( "Phone", "mycity" ).'</label>
    <input id="phone" data-geo="formatted_address" name="meta_phone" type="text" value="';
    if ($meta_phone==FALSE) echo '';
    else echo esc_attr($meta_phone);
    echo   '">
    <label>'.__( "Site", "mycity" ).'</label>
    <input id="website2" data-geo="formatted_address" name="website2" type="text" value="';
    if ($meta_website==FALSE) echo '';
    else echo esc_attr($meta_phone);
    echo   '">
    </div>
</form>
<div id="map-canvas"></div> 
<script>      
        function  initialize(){var mapOptions={center:new google.maps.LatLng('.$metadata .'),zoom:13};var map=new google.maps.Map(document.getElementById("map-canvas"),mapOptions);var input=(document.getElementById("pac-input"));var types=document.getElementById("type-selector");map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);var autocomplete=new google.maps.places.Autocomplete(input);autocomplete.bindTo("bounds",map);var infowindow=new google.maps.InfoWindow();var marker=new google.maps.Marker({map:map,draggable:true,anchorPoint:new google.maps.Point(0,-29)});google.maps.event.addListener(autocomplete,"place_changed",function(){infowindow.close();marker.setVisible(false);var place=autocomplete.getPlace();
        console.log(place);
        if(!place.geometry){return;}
        if(place.geometry.viewport){map.fitBounds(place.geometry.viewport);}else{map.setCenter(place.geometry.location);map.setZoom(17);}
            marker.setIcon(({url:place.icon,size:new google.maps.Size(71,71),origin:new google.maps.Point(0,0),anchor:new google.maps.Point(17,34),scaledSize:new google.maps.Size(35,35)}));marker.setPosition(place.geometry.location);marker.setVisible(true);var crtt=place.geometry.location.lat()+","+place.geometry.location.lng();var foradre=place.formatted_address;$("#cordinats").val(crtt);$("#cordinats").trigger("change");$("#formatted_address").val(foradre);$("#phone").val(place.formatted_phone_number);$("#website2").val(place.website);var address="";if(place.address_components){address=[(place.address_components[0]&&place.address_components[0].short_name||""),(place.address_components[1]&&place.address_components[1].short_name||""),(place.address_components[2]&&place.address_components[2].short_name||"")].join(" ");}
            infowindow.setContent("<div><strong>"+place.name+"</strong><br>"+address);infowindow.open(map,marker);});google.maps.event.addListener(marker,"drag",function(){$.getJSON("http://maps.googleapis.com/maps/api/geocode/json?latlng="+marker.getPosition().lat()+","+marker.getPosition().lng()+"&sensor=true_or_false",function(data,textStatus){var adress1=data.results[0].formatted_address;infowindow.setContent("<div><strong>"+adress1+"</strong><br>"+data.results[1].formatted_address);$("#formatted_address").val(adress1);$("#cordinats").val(marker.getPosition().lat()+","+marker.getPosition().lng());});infowindow.open(map,marker);});function setupClickListener(id,types){var radioButton=document.getElementById(id);google.maps.event.addDomListener(radioButton,"click",function(){autocomplete.setTypes(types);});}
            setupClickListener("changetype-all",[]);setupClickListener("changetype-address",["address"]);setupClickListener("changetype-establishment",["establishment"]);setupClickListener("changetype-geocode",["geocode"]);}
        jQuery(document).ready(function(){initialize();});
    </script>
     </div> 
<style>
my_sectionid .inside{min-height:600px}div.gm-style{min-height:500px!important}#canvas2{position:relative;z-index:800;height:600px}#map-canvas{z-index:800;left:90px;min-height:500px!important}html,body,#map-canvas{height:100%;margin:0;padding:0}.controls{margin-top:16px;border:1px solid transparent;border-radius:2px 0 0 2px;box-sizing:border-box;-moz-box-sizing:border-box;height:32px;outline:none;box-shadow:0 2px 6px rgba(0,0,0,0.3);width:100%}#pac-input{background-color:#fff;font-family:Roboto;font-size:15px;font-weight:300;margin-left:12px;padding:0 11px 0 13px;text-overflow:ellipsis;min-width:350px;width:25%}#pac-input:focus{border-color:#4d90fe}.pac-container{font-family:Roboto}#type-selector{color:#fff;background-color:#4d90fe;padding:5px 11px 0;width:25%;height:230px;min-width:350px;margin-top:60px;z-index:5000000!important;position:relative;left:10px!important}#type-selector input{max-width:100%;min-width:100%;margin-right:10px}#type-selector label{font-family:Roboto;font-size:13px;font-weight:300}
</style> ';
    ?>
    <script>
    $("#cordinats").on('change',function(){
        $("#instagrams").html("Connecting to Instagram...");
        var spl = $(this).val();
        var spl2 = spl.split(",");
        iurl = "https://api.instagram.com/v1/locations/search?client_id=a79875cd8c844916a4fa0e15b9e35272&lat="+spl2[0]+"&lng="+spl2[1];
       
        $.ajax({
            type: "GET",
            dataType: "jsonp",
            url: iurl,
            success: function(data) {
                $("#instagrams").html("Select one of checkpoint:<Br>"+iurl);
                
                $.each(data.data, function(index, element) {
                    $("#instagrams").append("<a href='#' onclick='$(\"#instaid\").val("+element.id+");return false'>"+element.name+"</a><br>");
                });
            }
        });
    });
     jQuery(function($){
    $(document).on('click', '.upload_image_button'), function (e) {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = $(this);
        wp.media.editor.send.attachment = function(props, attachment) {
            $(button).parent().prev().attr('src', attachment.url);
            $(button).prev().val(attachment.id);
            wp.media.editor.send.attachment = send_attachment_bkp;
        }
        wp.media.editor.open(button);
        return false;    
    });
    $(document).on('click', '.remove_image_button'), function (e) {
        var r = confirm("<?php esc_html_e( 'Sure?"', 'mycity' ); ?>);
        if (r == true) {
            var src = $(this).parent().prev().attr('data-src');
            $(this).parent().prev().attr('src', src);
            $(this).prev().prev().val('');
        }
        return false;
    });
});
    </script>
    <h2><?php esc_html_e( 'Instagram checkpoint', 'mycity' ); ?></h2>
    <input type='text' class='form-control' id='instaid' placeholder='Instagram Place ID' name='instaid' value='<?php echo esc_attr(get_post_meta($post->ID, 'instaid',true));?>'>
    <div id='instagrams'></div>
    <?php 
}
 /**
  * save postdata description]
  * @param int $post_id id post
  * @return {[mixid]}        [update post]
  */
function mycity_my_save_postdata( $post_id )
{
    global $_POST;
    if (!isset($_POST['myplugin_new_field'])) $_POST['myplugin_new_field'] = "";
    if (!isset($_POST['formatted_address'])) $_POST['formatted_address'] = "";
    if (!isset($_POST['meta_phone'])) $_POST['meta_phone'] = "";
    if (!isset($_POST['website2'])) $_POST['website2'] = "";
    if (!isset($_POST['meta_tags'])) $_POST['meta_tags'] = "";
    $mydata = sanitize_text_field($_POST['myplugin_new_field']);
    $meta_adress = sanitize_text_field($_POST['formatted_address']);
    $meta_phone=sanitize_text_field($_POST['meta_phone']);
    $meta_website=sanitize_text_field($_POST['website2']);
    $meta_tags=sanitize_text_field($_POST['meta_tags']);
$allpostmeta=get_post_custom($post_id);
if (array_key_exists('_myfield', $allpostmeta)) update_post_meta($post_id, '_myfield', sanitize_text_field($mydata));
else add_post_meta($post_id, '_myfield',  sanitize_text_field($mydata), TRUE);
if (array_key_exists('_meta_phone', $allpostmeta)) update_post_meta($post_id, '_meta_phone', sanitize_text_field($meta_phone));
else add_post_meta($post_id, '_meta_phone',  $meta_phone, TRUE);
if (array_key_exists('_meta_website', $allpostmeta)) update_post_meta($post_id, '_meta_website', sanitize_text_field($meta_website));
else add_post_meta($post_id, '_meta_website',  $meta_website, TRUE);
if (array_key_exists('_adress', $allpostmeta)) update_post_meta($post_id, '_adress', sanitize_text_field($meta_adress));
else add_post_meta($post_id, '_adress',  $meta_adress, TRUE);
if (array_key_exists('_tags', $allpostmeta)) update_post_meta($post_id, '_tags', sanitize_text_field($meta_tags));
else add_post_meta($post_id, '_tags',  $meta_tags, TRUE);
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
        return $post_id;
    if (!isset($_POST['uploader_custom'])) $_POST['uploader_custom'] = "";
    update_post_meta( $post_id, 'uploader_custom', sanitize_text_field($_POST['uploader_custom']));
    if (!isset($_POST['instaid'])) $_POST['instaid'] = "";
    update_post_meta( $post_id, 'instaid',sanitize_text_field($_POST['instaid']));
    return $post_id;
}




 ?>