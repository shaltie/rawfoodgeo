<?php
$name = get_post_meta(get_the_ID(), 'instaid',true);
//the_luxury_life
$media_array = mycity_scrape_instagram($name);
if (!is_wp_error($media_array) && is_array($media_array)) {

?>
<div  class="big_tremula" >

    <div class="tremulaContainer main"></div>
    <div class="debug"></div>
</div>




<script type="text/javascript">
    jQuery().ready(function ($) {
        setTimeout(function () {
            var tremula = tremulaInit();

            attachDemoControls(tremula);
            loadFlickr();
            jQuery(".cssload-cube").hide(1500);
            window.tremula = tremula; //does not need to be on the window -- implemented here for convienience.

            jQuery('body').removeClass('doReflect');

            $('.tremulaContainer').trigger('resize');

        }, 100);
        setTimeout(function () {
            jQuery('.tremulaContainer').trigger('resize');
        }, 500);
    });

    function tremulaInit() {


        $tremulaContainer = jQuery('.tremulaContainer');
        var tremula = new Tremula();
        var config = tremulaConfigs.default.call(tremula);
        tremula.init($tremulaContainer, config, this);
        var doScrollEvents = function (o) {
            if (debugLoop)
                debugLoop(o);
            if (o.scrollProgress > .7) {
                if (!tremula.cache.endOfScrollFlag) {
                    tremula.cache.endOfScrollFlag = true;
                    console.log('END OF SCROLL!');
                    loadFlickr();
                }
            }

        }
        tremula.setOnChangePub(doScrollEvents);
        return tremula;
    }


    /*-------------------------------*/


    var pageCtr = 1;
    function loadFlickr(){
        var dataUrl = 'http://city1.wpmix.net/wp-admin/admin-ajax.php/?action=mycity_get_insta';
        console.log(dataUrl)      ;

       /* jQuery.ajax({
                url:dataUrl
                ,dataType: 'jsonp'
                ,jsonp: 'jsoncallback'
            })
            .done(function(res){
                console.log('API success',res.photos.photo);
                if (res.stat=='fail')alert('Dang. Looks like Flickr has lost its pancakes... '+res.message);
                var rs = res.photos.photo.filter(function(o,i){return o.height_n > o.width_n * .5});//filter out any with a really wide aspect ratio.

                tremula.appendData(res.photos.photo,flickrDataAdapter);//flicker
                tremula.cache.endOfScrollFlag = false;
            })
            .fail( function(d,config,err){console.log('API FAIL. '+err) })
              */

jQuery.ajax({
     url: "<?php echo esc_url(site_url()); ?>/wp-admin/admin-ajax.php",
	 type: "GET",
    data: "action=mycity_get_insta&id=<?php echo esc_html(get_the_ID()); ?> ",
    success: function(response) {
      //  response2 = jQuery.parseJSON(response);
        console.log('aaaaaaaaaaaaaaaaa',response);
        tremula.appendData(response,flickrDataAdapter);//flicker
        tremula.cache.endOfScrollFlag = false;
    },
    error: function(xhr, status, error) {
        console.log(status + '; ' + error);
    }
});


    }


    function exec_media(dataUrl) {

        jQuery.ajax({
                type: "GET",
                cache: true,
                url: 'http://city1.wpmix.net/wp-admin/admin-ajax.php/?action=mycity_get_insta',

            })
            .done(function (res) {
                console.log(res);
                tremula.appendData(res, flickrDataAdapter);
                tremula.cache.endOfScrollFlag = false;
            })
            .fail(function (d, config, err) {
                console.log('API FAIL. ' + err)
            })

    }

    function flickrDataAdapter(data,env){
        this.data = data;
        this.w = this.width = 250;
        this.h = this.height =250;
        this.imgUrl = data['url'];
        this.auxClassList = "flickrRS";//stamp each mapped item with map ID
        this.template = this.data.template||('<img draggable="false" class="moneyShot" onload="imageLoaded(this)" src=""/>');
    }

</script>
<script type="text/javascript">
    showControlData = function (o) {
        if (!this.$debug)
            this.$debug = jQuery('.debug');
    }

    debugLoop = null;

    toggleDebug = function toggleDebug() {
        if (debugLoop) {
            debugLoop = null;
            jQuery('.debug').removeClass('show');
        } else {
            debugLoop = showControlData;
            jQuery('.debug').addClass('show');
            showControlData({});
        }

    }


</script>


<?php  } ?>