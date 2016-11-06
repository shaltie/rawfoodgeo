jQuery(document).ready(function ($) {


    $(".btn_scroll_down").click(function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop : $(".phone_email").offset().top - 85,


        }, 800);
        $('html, body').animate({
            opacity : 1

        }, 1);
    });



    $(".header_section .icons i").click(function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop : $(".phone_email").offset().top - 85,


        }, 800);
        $('html, body').animate({
            opacity : 1

        }, 1);
    });

    jQuery(document).on("click", '#edited_Searchindex', function (e) {
        jQuery('#search_cat_hide').val(jQuery('.dropdown-toggle a').data('catis'));

    });
});
jQuery(document).ready(function ($) {

    jQuery(document).on("click", '#edited_Searchindex', function (e) {
        jQuery('#search_cat_hide').val(jQuery('.dropdown-toggle a').data('catis'));

    });
});

var res = jQuery('#hero-bg').attr('data-img');
jQuery('#hero-bg').hide();
var pic = new Image();
pic.src = res; //
jQuery(pic).load(function () {
    jQuery('#hero-bg').css('background-image', 'url(' + res + ')');
    setTimeout(function () {
        jQuery(".body_opacity").addClass('fade_op');
    }, 100);

    jQuery('#hero-bg').addClass('fade-hero');
});
jQuery(document).ready(function ($) {

    // $('.navigate .menu-item-has-children').mouseover(function(){
    // 	alert('1');
    // });

    $('.map-toggle').click(function () {
        $('.side-bar').fadeToggle();
        $(this).toggleClass('active');
    });
    if ($('.fmr_chat_right').length > 0) {
        $('.anchor').hide();
    }

    if ($(window).width() > 768) {
        new WOW().init();
    }


    $('.template-item-minimal.wide .start_descrition').addClass('animated fadeIn');
    $('.home .start_descrition').addClass('animated fadeIn');
    if ($('body').hasClass('small_header') || $('body').hasClass('bbpress')) {
        $('.open.single_h1 p').hide();
        $('.small_header .blog_category').css({
            'top': '0',
            'margin-top': '75px'
        });
        $('.bbpress .blog_category').css({
            'top': '0',
            'margin-top': '75px'
        });
    }
    if ($('body').hasClass('have_dialog')) {
        $('.anchor').hide();
    }
    if ($('#auth_menu .fa-user-plus').hasClass('fa-2x')) {
        $('body').addClass('total-registration');
    }
    else {
        $('body').addClass('sms-registration');
    }
    var ccc = 'Login / Sing up';
    $('.sms-registration .btn-front .auth_p').html(ccc);

    $(document).on("click", '.select-L > a', function (e) {
        e.preventDefault();
        $('.select-lang').fadeToggle();
        $('.select-L .fa').toggleClass('aaaa');

        //alert(getCookie("showmodalka"));
        if (getCookie("showmodalka") != 1) {
            setCookie("showmodalka", 1);
            $("#imodalko1").fadeIn();
        }

        $("#imodalko1").fadeIn();

    });
    $(document).on("click", '.imodal-p .fa', function (e) {
        $('#imodalko1').fadeOut(500);
    });


    $(document).on("click", '.select-L ul a', function (e) {
        e.preventDefault();
        location.reload();
        $('.select-L .fa').removeClass('aaaa');
        $('.select-lang').fadeOut();
        $(this).parents('.select-L').find('a').appendTo('.select-L ul');
        var this_a = $(this).clone(),
            this_language = $(this).html();
        this_a.prependTo('.select-L');
        $(this).remove();
        setCookie("lang", this_language);
        this_a.prependTo('.select-L');


    });
    var place_map_height = $('.icon_descr_block .cols').height();
    $('.icon_descr_block .bubble').height(place_map_height);
    $('.woocommerce-cart .post_info').wrap('<div class="col-md-12 blog_category"></div>');
    $('.woocommerce-cart .blog_category').wrap('<div class="container page_info place_info"></div>');


    $('#cupon_code_place').attr('type', 'text');
    $(document).on("click", '.a2a_kit a', function (event) {

        setTimeout(function () {
            // alert(2);
            $('.a2a_kit').hide();
            $('.cupon_code_new').text($('#cupon_code_place').val());
        }, 4000);

    })
});
jQuery(document).ready(function ($) {
    $(document).on("click", '.add_to_cart', function (event) {

        event.preventDefault();
        var button_type = $(this).attr('data-button-type');

        $(this).fadeTo("fast", 0.1);

        var current_form = $(this).parents('form.cart_form');
        var ticket_id = current_form.find(".ticket_id").val();
        var qty = $(this).closest('tr').find('.tc_quantity_selector').val();

        //$( this ).closest( 'tr' ).find( '.tc_quantity_selector' ).attr( 'disabled', 'disabled' );

        $.post(tc_ajax.ajaxUrl, {
            action: "add_to_cart",
            ticket_id: ticket_id,
            tc_qty: qty
        }, function (data) {
            if (data != 'error') {
                current_form.html(data);

                if ($('.tc_cart_contents').length > 0) {
                    $.post(tc_ajax.ajaxUrl, {
                        action: "update_cart_widget"
                    }, function (widget_data) {
                        //$('#tc_cart_widget').fadeTo("fast", 0.0);
                        $('.tc_cart_contents').html(widget_data);
                        //$('#tc_cart_widget').fadeTo("fast", 1);
                    });
                }

                if (button_type == 'buynow') {
                    window.location = tc_ajax.cart_url;
                }

            } else {
                current_form.html(data); //Show error message
            }
            $(this).fadeTo("fast", 1);

        });
    });

});

/******************************ajax avatar **********************************/

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#image').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

jQuery("#imgInput").change(function () {
    readURL(this);
});


/*======================================================*/

var files;
jQuery(document).ready(function ($) {
    jQuery('input[type=file]').change(function () {
        files = this.files;
    });
    winHeight = $(window).height() + 50;

    $('#hero-bg').css({
        minHeight: winHeight
    });
    jQuery("#imgInput").change(function (event) {
        //alert("ok");
        var l2 = Ladda.create(document.querySelector('.my-button2'));

        // Start loading
        l2.start();

        event.stopPropagation();
        event.preventDefault();

        //files

        var data2 = new FormData();
        $.each(files, function (key, value) {
            data2.append(key, value);
        });
        data2.append('action', 'mycity_fiu_upload_file');

        $.ajax({
            url: MyCity_map_init_obj.ajaxurl,
            type: 'POST',
            data: data2,
            cache: false,
            processData: false, //Don't process the files)
            contentType: false, // this is not string
            success: function (respond, textStatus, jqXHR) {


                l2.stop();


            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });


    });
});

/***************************end ajax avatar ************************************/
function setComments_img() {

    $(".comments_img").each(function (i) {
        var comImg = $(this).parent().height();
        $(this).height(comImg);
    });
}


jQuery(document).ready(function ($) {

    $(document).on("click", '.h_post', function (e) {
        var sub_distance = ($(this).parent().offset().top - $(window).scrollTop()) - 30;
        var sub_distance_left = $(this).parent().offset().left + 30;
        var sub_distanceText = ($(this).parent().siblings('.p_text').offset().top - $(window).scrollTop()) - 30;
        var sub_distance_date = ($(".comments_date[rel=" + $(this).attr("rel") + "]").offset().top - $(window).scrollTop()) - 30;
        var sub_distance_left_date = $(".comments_date[rel=" + $(this).attr("rel") + "]").offset().left + 30;
        var windowHeight = $(window).height();
        var sub_distance_img = ($(".comments_img[rel=" + $(this).attr("rel") + "]").offset().top - $(window).scrollTop()) - 30;
        $('.comments_img').height(windowHeight);
        $('body').addClass('news-open');
        $('.grid_cont').height(windowHeight);
        $('.grid_cont .cont').height(windowHeight);
        $('.com_a').remove();
        e.preventDefault();
        $(this).parents('.se-slope').siblings().hide();
        if ($(window).width() < 768) {
            $('.Category_page.wide footer').css({
                'margin-top': '-150px'
            })
        }
        $(window).scrollTop(0);
        $(this).parents('.se-slope').addClass('se_rotate');
        $(this).parent().addClass('h_fixed').css("left", sub_distance_left + "px").css("top", sub_distance + "px");
        $(this).parent().siblings('.p_text').addClass('p_fixed').css("left", sub_distance_left + "px").css("top", sub_distanceText + "px");
        $(".comments_date[rel=" + $(this).attr("rel") + "]").addClass('h_fixed').css("left", sub_distance_left_date + "px").css("top", sub_distance_date + "px");
        $(".comments_date[rel=" + $(this).attr("rel") + "]").css("display", "block");
        $(".comments_img[rel=" + $(this).attr("rel") + "]").css("top", sub_distance_img + "px").css("transform", "rotate(0deg)");


        var cscreen = $(window).height() / 2;
        var delta = cscreen - sub_distance;

        var delta2 = cscreen - sub_distanceText + 20;

        $(".h_fixed").animate({top: "+=" + (delta - 60) + "px"}, 100);
        $(".p_text").animate({top: "+=" + delta2 + "px"}, 1000);

        $(".comments_img").animate({top: "0px"}, 1000);

        $('.se-container').addClass('news_up');
        $(this).parents('.se-content').css({
            height: jQuery(window).height() + 60 + 'px',
            'transform': 'rotate(0deg)'
        });

        $('.comments_content').css("margin-left", "0px");
        //$(this).siblings('span').addClass('span_center');
        $('.page_info,.btn-continue').hide();
        $('.post_info').addClass('post_info_margin');
        $('.more_btn2').hide();

        var ajax_url = $(this).attr("data-url");

        $.ajax({
            type: "POST",
            url: ajax_url + "?ajax=1",
            success: function (data) {
                $('#ad_ajax').html(data);

                window.setTimeout(function () {
                    $(".item_wide_container").addClass("changed");
                }, 700);
                $('.item_wide_container').show().addClass('animated bounceInUp');
                history.pushState(null, null, ajax_url);
            }
        });
        $('#ad_ajax').show();
        jQuery('#container').height();
        winHeight = $(window).height() - 50;

        $('#hero-bg').css({
            minHeight: winHeight
        });
    });

    "use strict";
    $('#hero-bg').height($('.submit_place_wrapper').outerHeight(true));

    setTimeout(function () {
        if ($(".evoShow_more_events"))
            $(".evoShow_more_events").click();
    }, 700);


    // $('.se-content').mouseout(function(){
    // 	$(this).siblings('.bright_slope').children('.comments_img').removeClass('hopacity');
    // });
    // $('.se-content').mouseout(function(){
    // 	$(this).siblings('.bright_slope').removeClass('hopacity');
    // });
});

jQuery(window).load(function ($) {
    "use strict";
    // jQuery('.item_wide_container').addClass('animated rubberBand');
    jQuery('.flickr_photo ul li').append('');
});
jQuery(document).on("scroll", function ($) {

    "use strict";
    if (jQuery("footer").length > 0) {
        var footerOffset = jQuery('footer').offset().top - 400;
        var Scrolling = jQuery(this).scrollTop();

        if (Scrolling > footerOffset) {
            jQuery('.copyright-area svg').attr('class', function (index, classNames) {
                return classNames + ' haha';
            });
        } else {
            jQuery('.copyright-area svg').attr('class', function (index, classNames) {
                return classNames.replace('haha', 'svg_2');
            });

        }
    }

});
jQuery(document).ready(function ($) {
    $('.places_index_block').each(function () {
        var highestBox = 0;
        $('.pl_descr', this).each(function () {

            if ($(this).height() > highestBox)
                highestBox = $(this).height();

        });
        $('.pl_descr', this).height(highestBox);
    });

    "use strict";
    //tabs in google_places
    $(document).on("click", '.google_place ul li a', function (e) {
        e.preventDefault();
        var item = $(this).closest('.tabs_controls_item'),
            contentItem = $('.tabs_item'),
            itemPosition = item.index();
        contentItem.eq(itemPosition).addClass('active').siblings().removeClass('active');
        $(this).addClass('active');
        $(this).parent().siblings().children('a').removeClass('active');

    });
    if ($('.ttshowcase_rl_quote').hasClass('get_drink')) {

    }
    else {
        $('body').addClass('no_get_drink');

    }
    $('body').on("mouseenter", '.places_list_my', function (e) {
        $(this).children('.grid_h1').fadeOut(200);
    });
    $('body').on("mouseleave", '.places_list_my', function (e) {
        $(this).children('.grid_h1').fadeIn(200);
    });
    $('body').on("click", '.anchor', function (e) {

        $('html, body').animate({
            scrollTop: $(".toptop").offset().top
        }, 1000);
    });

    $('body').on("mouseover", '.btn-continue', function (e) {
        $('.btn-continue .fa').addClass('faRun');
    });

    $('body').on("mouseout", '.btn-continue', function (e) {
        $('.btn-continue .fa').removeClass('faRun');
    });
    $('footer .container .row > div').addClass('col-sm-6');

    $('body').on("mouseover", '.img_container', function (e) {
        $('.img_container img').addClass('img_container_scale');
    });

    $('body').on("mouseout", '.img_container img', function (e) {
        $('.img_container img').removeClass('img_container_scale');
    });
    // $(".svg_1").click(function() {
    //    	this.classList.add("haha");
    // });
    $(document).on("click", '#submit_rewiew', function (e) {
        e.preventDefault();
        $('.modal_popup, #msity_rewiew').fadeIn();
        return false;
    });
    $(document).on("click", '.close_msity,.modal_popup', function (e) {
        e.preventDefault();
        $('.modal_popup, #msity_rewiew').fadeOut();
        return false;
    });
    $('#ttshowcase_form input,#ttshowcase_form select,#ttshowcase_form textarea').addClass('form-control');
    $('.tt_form_button').addClass('btn-primary');

    if (jQuery('ul').is('.head_nav') == true) {

        var topHeaderPosTop = $('.head_nav').position().top;

        if (topHeaderPosTop > 20 || jQuery(window).width() < 768) {
            $('body').addClass('navigate_width');
            $('body').on("click", '.logo', function (e) {
                $('.head_nav').fadeToggle();
                $('.fa-angle-down').toggleClass('rotate_arrow');
                return false;
            });
        }
    }
    $('.places_cat a').each(function () {
        var location = window.location.href;
        var link = this.href;
        if (location == link) {
            $(this).addClass('active');

        }
    });

    $('#container  a').each(function () {
        var location = window.location.href;
        var link = this.href;
        if (location == link) {
            $(this).addClass('active');

        }
    });

    // show  weather


    var latitude = parseFloat(MyCity_map_init_obj.weather_latitude);
    var longitude = parseFloat(MyCity_map_init_obj.weather_longitude);
    var W_APPI = MyCity_map_init_obj.weather_APPID;

    var gradus = "&deg C";

    if (MyCity_map_init_obj.weather == "s1") {
        gradus = "&deg F";
    }

   // console.log("http://api.openweathermap.org/data/2.5/weather?lat=" + latitude + "&lon=" + longitude + "&APPID=" + W_APPI);


    if (MyCity_map_init_obj.weather != "s3" && W_APPI.length > 5) {
        $.getJSON("http://api.openweathermap.org/data/2.5/weather?lat=" + latitude + "&lon=" + longitude + "&APPID=" + W_APPI, function (data) {
            var temp = Math.round(data.main.temp - 273, 15).toFixed(0);

            if (MyCity_map_init_obj.weather == "s1") {
               // temp = Math.round(9 * (data.main.temp - 273, 15) / 5 + 32).toFixed(0);
                temp = (temp * (9 / 5)) + 32;
                temp = temp.toFixed(0)
            }
            temp += gradus;
            if (parseInt(temp) > 0) {
                temp = "+ " + temp;
            } else {
                temp = "" + temp;
            }

            var direct = MyCity_map_init_obj.direct.replace('\/', '/');
            direct = direct.replace('"', '');

            if (data.rain) {
                var url = direct + "/img/icon/rain-xxl.png";
                $(".weather").prepend('<img src="' + url + '" style="margin-left: 10px;" width="35" height="35">');

            } else if (parseInt(data.clouds.all) > 1) {
                var url = direct + "/img/icon/cloud-2-xl.png";

                $(".weather").prepend('<img src="' + url + '" style="margin-left: 10px;"  width="35" height="35">');

            } else {
                var url = direct + "/img/icon/sun-xl.png";

                $(".weather").prepend('<img src="' + url + '" style="margin-left: 10px;"  width="35" height="35">');

            }
            $(".weather > span").html(temp);

        });
    }
    $('body').on("mouseenter", '.blog_cat > .main-menu-itemmenu-item-evenmenu-item-depth-0 > a', function (e) {
        $(this).parent().children('.menu-odd').addClass('animated bounceInDown').removeClass('z-index-index');
        $(this).parent().children('.sub-sub-menu').removeClass('animated bounceInDown');
        $(this).parent().siblings().children('.menu-odd').addClass('z-index-index').removeClass('animated bounceInDown');
        $(this).parent().siblings().children('.menu-odd').find('li').children('.sub-sub-menu').removeClass('animated bounceInDown');

    });
    $('.blog_cat .menu-odd li.menu-item-has-children').append('<i class="fa fa-angle-up"></i>');
    $('.blog_cat .children').parent('li').append('<i class="fa fa-angle-up"></i>');
    $('.blog_cat > li.menu-item-has-children > a').append('<i class="fa fa-angle-up"></i>');
    $('body').on("mouseenter", '.blog_cat .menu-odd > .menu-item-has-children', function (e) {
        // alert(1);
        $(this).children('.sub-sub-menu').addClass('animated bounceInDown');
        $(this).siblings().children('.sub-sub-menu').removeClass('animated bounceInDown');
    });
    $('body').on("mouseenter", '.blog_cat > li > a', function (e) {
        // alert('1');
        $(this).parent().children('.children').addClass('animated bounceInDown');

        $(this).parent().siblings().children('.children').removeClass('animated bounceInDown');
    });

    // $('.menu-short-container .blog_cat li .sub-menu .sub-menu').css({
    // 	'left':'0px'
    // });
    // $('body').on("mouseover", '.menu-odd li', function (e) {
    // 	$(this).children('.sub-sub-menu').addClass('animated bounceInDown');
    // 	$(this).siblings().children('.sub-sub-menu').removeClass('animated bounceInDown');
    // });
    // $('body').on("mouseout", '.menu-odd li', function (e) {
    // 	$(this).children('.sub-sub-menu').removeClass('animated bounceInDown');
    // });

    //    $('body').on("mouseout", '.blog_cat li', function (e) {


    // 		$(this).children('.sub-menu').removeClass('animated bounceInDown');

    // });
    // $('.blog_cat li').mouseover(function(){
    // 	$('.children').removeClass('animated bounceInDown');
    // 	$('.children').addClass('animated zoomOut children_z_index');
    // });
    $('.blog_cat .children').prepend('<div class="exit_block"><i class="fa fa-times"></i></div>');
    // $('#menu-short > .menu-item-has-children > a').append('<i class="fa fa-angle-right"></i>');
    //$('#container .blog_cat li .children').parent().append('<i class="fa fa-angle-right"></i>');
    $('footer .children').remove();
    $('.menu-testing-menu-container').parent('div').hide();
    $('.blog_cat > li > .children').siblings('a').css("padding-right", "30px");
});

"use strict";
jQuery(document).ready(function ($) {
    "use strict";
    $(".blog_cat .menu-odd").each(function () {
        var widthListPr = 0;
        $(this).children('.sub-menu-itemmenu-item-oddmenu-item-depth-1').each(function () {
            widthListPr = widthListPr + $(this)[0].getBoundingClientRect().width;

        });
        $(this).css({
            'width': widthListPr + 'px'
        });
        //$(this)[0].getBoundingClientRect().width = widthListPr;

        $(this).css({
            'margin-left': ((widthListPr / 2) * (-1)) + 'px'
        });

    });

    $(".blog_cat .menu-even").each(function () {
        var widthListPr2 = 0;
        $(this).children('.sub-menu-itemsub-sub-menu-itemmenu-item-evenmenu-item-depth-2').each(function () {
            widthListPr2 = widthListPr2 + $(this)[0].getBoundingClientRect().width;
        });
        $(this).css({
            'width': widthListPr2 + 'px'
        });
        //$(this)[0].getBoundingClientRect().width = widthListPr;

        $(this).css({
            'margin-left': ((widthListPr2 / 2) * (-1)) + 'px'
        });

    });

    $(".blog_cat .children").each(function () {
        var widthListPr3 = 0;

        $(this).children('li.cat-item').each(function () {
            widthListPr3 = widthListPr3 + $(this)[0].getBoundingClientRect().width;
        });
        $(this).css({
            'width': widthListPr3 + 'px'
        });
        //$(this)[0].getBoundingClientRect().width = widthListPr;

        $(this).css({
            'margin-left': ((widthListPr3 / 2) * (-1)) + 'px'
        });
    });


    $(window).scroll(function () {
        if ($(this).scrollTop() > 500) {
            $('.anchor').removeClass('rotateOut').addClass('animated bounceIn');
        } else {
            $('.anchor').removeClass('bounceIn').addClass('animated rotateOut');
        }
    })
});

jQuery(document).ready(function ($) {
    "use strict";

    $(window).scroll(function () {
        if ($(this).scrollTop() > 500) {
            $('.anchor').removeClass('rotateOut').addClass('animated bounceIn');
        } else {
            $('.anchor').removeClass('bounceIn').addClass('animated rotateOut');
        }
    })
});
/*$(document).on("click", '#map"', function (e) {
 if (jQuery(e.target).closest("div.infoBox").length == 0) {
 jQuery('div.infoBox').remove();
 }
 });*/

jQuery(function () {
    jQuery('#container_1').masonry({
        itemSelector: '.box',
        columnWidth: 0
    });

});
jQuery(document).ready(function ($) {
    "use strict";
    jQuery("body").addClass("body_visible");
    jQuery('.addtoany_list').addClass('addtoany_list_center');
    if ($('footer > div').hasClass('container')) {
    }
    else {
        $('footer').css({
            'padding-top': '0px'
        })
    }
    // if (jQuery('body').hasClass('wp-customizer')) {

    // }


});
function lol_shared() {
    "use strict";
    setTimeout(function () {
        $(".btn_block_banner input").val($(".btn_block_banner input").attr("rel"));
    }, 1500);

}

if (typeof(a2a_config) != 'undefined') {
    a2a_config.callbacks.push({
        share: lol_shared
    });
}
//============


//submit place//////


function change_reward(r) {
    jQuery("#r1,#r2").hide();
    if (r == 1)
        jQuery("#r1").show();
    if (r == 2)
        jQuery("#r2").show();
}

//addtoany
if (typeof(a2a_config) != 'undefined') {

    a2a_config.callbacks.push({
        share: function (data) {
            // Do something with the data object here
            ////console.log(data);
        }
    });

}
////Index one block height//////


function setHeiHeightChatLogedin() {
    "use strict";
    jQuery('.chat_messages').css({
        height: jQuery(window).height() - 267 + 'px'
    });

}
function setHeiHeightChat() {
    "use strict";
    jQuery('.chat_messages').css({
        height: jQuery(window).height() - 234 + 'px'
    });
}
function setHeiHeightChat_adaptive() {
    "use strict";
    jQuery('.chat_messages').css({
        height: jQuery(window).height() - 214 + 'px'
    });
}
function setHeiHeightRegister() {
    "use strict";
    jQuery('.auth_login').css({
        height: jQuery(window).height() - 390 + 'px'
    });
}
function setHeiHeightRegister_p() {
    "use strict";
    jQuery('.register_p .auth_login').css({
        height: jQuery(window).height() - 270 + 'px'
    });
}
function setHeiHeightItemsContainer() {
    "use strict";

    jQuery('.cart_items_container').css({
        height: jQuery(window).height() - 135 + 'px'
    });
}
function setHeiHeightItemsContainer_logedin() {
    "use strict";

    jQuery('.cart_items_container').css({
        height: jQuery(window).height() - 167 + 'px'
    });
}
if (jQuery('html').hasClass('logedin')) {
    setHeiHeightChatLogedin();
    // alert('1');
    setHeiHeightItemsContainer_logedin()
} else {
    setHeiHeightItemsContainer();
    setHeiHeightChat();

}

jQuery(document).ready(function ($) {
    if (jQuery(window).width() > 768) {
        $(window).scroll(function () {
            'use strict';
            if ($(this).scrollTop() > 1) {

                $('header').addClass("sticky");
                $('.mycity_o-grid__item').addClass('grid_item_fix');
            } else {
                if (!($('div').is('#tabs') )) {
                    $('header').removeClass("sticky");
                    $('.mycity_o-grid__item').removeClass('grid_item_fix');
                }
            }


        });
        $('.head_nav > .menu-item-has-children > a').append('<i class="fa fa-angle-down"></i>');
        //$('.sub-menu > .menu-item-has-children a').append('<i class="fa fa-angle-right"></i>');

        $('body').on("mouseover", '.blog_cat > li > a', function (e) {
            $(this).addClass('blog_cat_hover');
            $(this).parent().siblings().find('a').addClass('cat_opacity');
        });

        $('body').on("mouseout", '.blog_cat > li > a', function (e) {
            $(this).removeClass('blog_cat_hover');
            $(this).parent().siblings().find('a').removeClass('cat_opacity');
        });
    }

    if (jQuery(window).width() < 768) {
        $('.sidebar #myAffix2').removeAttr('id');
        $(document).on("click", '.filter', function (e) {
            $('.sidebar').fadeToggle();
        });
        $(window).scroll(function () {
            if ($(this).scrollTop() > 1) {
                $('.filter').removeClass('rotateOut').addClass('animated bounceIn');
            } else {
                $('.filter').removeClass('bounceIn').addClass('animated rotateOut');
            }
        });
    }

    //  $('.chat_ava_exit ').click(function(){
    //   alert('1');
    // });
    // if(jQuery(window).width() < 992){
    //   $('.cart_items').click(function(){
    //     $('.chat_box .mainFeedback').removeClass('perspectiveRightRetourn').addClass('slideLeft');
    //     $('.chat_static').removeClass('slideLeft').addClass('perspectiveRightRetourn');
    // });
    // $('.chat_ava_exit').click(function(){
    //   $('.chat_box .mainFeedback').removeClass('slideLeft').addClass('perspectiveRightRetourn');
    //     $('.chat_static').removeClass('perspectiveRightRetourn').addClass('slideLeft');

    // });
    if (jQuery(window).width() > 760) {


        $('body').on("mouseover", 'header .menu-item-has-children', function (e) {
            $(this).children('.sub-menu').show();
        });

        $('body').on("mouseout", 'header .menu-item-has-children', function (e) {
            $(this).children('.sub-menu').hide();
        });

    }
    if (jQuery(window).width() < 768) {
        $('.sub-menu').prepend('<li class="back_button"><a class="back"><i class="fa fa-angle-left"></i>Back</a></li>');
        $('.head_nav .menu-item-has-children > a').append('<i class="fa fa-angle-right"></i>');


        $(".comments_img").each(function (i) {
            var comImg = $(this).parent().height();
            $(this).height(comImg);
        });

        $(document).on("click", '.head_nav > li.menu-item-has-children > a', function (e) {
            $(this).siblings('.sub-menu').fadeIn();
            e.preventDefault();
            e.stopPropagation();
            return false;
        });
        $(document).on("click", '.head_nav .sub-menu li.menu-item-has-children a', function (e) {
            $(this).siblings('.sub-sub-menu').fadeIn();
            e.preventDefault();
            e.stopPropagation();
            return false;
        });
        $(document).on("click", '.sub-menu .back', function (e) {
            $(this).closest('.sub-menu').fadeOut();
            e.stopPropagation();
            return false;
        });
        // $(document).on("click", '.sub-sub-menu .back', function (e) {
        // 	$(this).$('.sub-sub-menu').fadeOut();
        // 	e.stopPropagation();
        // 	return false;
        // });

        //      $('body').on('click','.cart_items', function (e) {
        // 	$('.chat_box .mainFeedback');
        // 	$('.chat_static')
        // });
        $('body').on('click', '.chat_ava_exit', function (e) {

            $('.chat_pad').removeClass('slideLeft').addClass('perspectiveRightRetourn');
            $('.chat_static').removeClass('perspectiveRightRetourn').addClass('slideLeft');
        });
        setHeiHeightChat_adaptive();
        setHeiHeightRegister();
        setHeiHeightRegister_p();

    }

    //////Add place//////
    jQuery(document).on('click', "#ad", function (e) {

        jQuery('#pl').removeClass("none");
    });
    jQuery(document).on("click", '#close', function (e) {

        jQuery('#pl').addClass("none");
    });
    //////Autorization//////
    // jQuery('.log_btn').on('click', function () {
    //   "use strict";
    //   jQuery('#autorized').removeClass("none");
    // })
    jQuery(document).on('click', function (e) {
        "use strict";
        jQuery('#autorized').addClass("none");
    });
    //////Page load//////

    jQuery(document).on("click", 'a.transition', function (e) {
        "use strict";
        e.preventDefault();
        linkLocation = this.href;
        jQuery("body").fadeOut(900, redirectPage);
    });
    function redirectPage() {
        "use strict";
        window.location = linkLocation;
    }

    //////Mobile menu in map page (01.html)//////
    jQuery(document).on('click', '.mobile_menu', function () {
        "use strict";
        jQuery('.container-fluid.menu').removeClass("mobile");
    });
    jQuery(document).on('click', '#close_menu', function () {
        "use strict";
        jQuery('.container-fluid.menu').addClass("mobile");
    });
    jQuery('.container-fluid.menu a').on('click', function () {
        "use strict";
        jQuery('.container-fluid.menu').addClass("mobile");
    });
    $('body').on("click", '#chat_menu', function (e) {
        $('.cart_items_container').slideToggle(500);
    });


    $('body').on("click", '.dropdown-menu-right li a', function (e) {


        console.log('drop1');
        e.preventDefault();
        $('.dropdown-toggle').html(' ');
        $(this).clone().appendTo($('.dropdown-toggle'));
        jQuery('#search_cat_hide').val(jQuery('.dropdown-toggle a').data('catis'));
    });
    $('body').on("click", '.dropdown-menu-right2 li a', function (e) {
        console.log('drop2');
        e.preventDefault();
        $('.dropdown-toggle2').html(' ');
        $(this).clone().appendTo($('.dropdown-toggle2'));
        jQuery('#search_type_hide').val(jQuery('.dropdown-toggle2 a').data('catis'));
    });


});
//////Side menu//////
jQuery(document).ready(function ($) {
    function a() {
        e.toggleClass(j),
            d.toggleClass(i),
            f.toggleClass(k),
            g.toggleClass(l)
    }

    function b() {
        e.addClass(j),
            d.animate({
                left: "0px"
            }, n),
            f.animate({
                left: o
            }, n),
            g.animate({
                left: o
            }, n)
    }

    function c() {
        e.removeClass(j),
            d.animate({
                left: "-" + o
            }, n),
            f.animate({
                left: "0px"
            }, n),
            g.animate({
                left: "0px"
            }, n)
    }

    var d = $(".pushy"),
        e = $("body"),
        f = $("#container"),
        g = $(".push"),
        h = $(".site-overlay"),
        i = "pushy-left pushy-open",
        j = "pushy-active",
        k = "container-push",
        l = "push-push",
        m = $(".mycity_menu-btn, .pushy a"),
        n = 200,
        o = d.width() + "px";
    if (cssTransforms3d = function () {
            var a = document.createElement("p"),
                b = !1,
                c = {
                    webkitTransform: "-webkit-transform",
                    OTransform: "-o-transform",
                    msTransform: "-ms-transform",
                    MozTransform: "-moz-transform",
                    transform: "transform"
                };
            document.body.insertBefore(a, null);
            for (var d in c)
                void 0 !== a.style[d] && (a.style[d] = "translate3d(1px,1px,1px)", b = window.getComputedStyle(a).getPropertyValue(c[d]));
            return document.body.removeChild(a),
            void 0 !== b && b.length > 0 && "none" !== b
        }
        ())m.click(function () {
        a()
    }), h.click(function () {
        a()
    });
    else {
        d.css({
            left: "-" + o
        }),
            f.css({
                "overflow-x": "hidden"
            });
        var p = !0;
        m.click(function () {
            p ? (b(), p = !1) : (c(), p = !0)
        }),
            h.click(function () {
                p ? (b(), p = !1) : (c(), p = !0)
            })
    }
});
jQuery(document).on("click", '.site-overlay', function (e) {
    jQuery('.c-hamburger').removeClass('is-active');

});
function loadScript(src, callback) {
    var s,
        r,
        t;
    r = false;
    s = document.createElement('script');
    s.type = 'text/javascript';
    s.src = src;
    s.onload = s.onreadystatechange = function () {
        ////console.log( this.readyState ); //uncomment this line to see which ready states are called.
        if (!r && (!this.readyState || this.readyState == 'complete')) {
            r = true;
            callback();
        }
    };
    t = document.getElementsByTagName('script')[0];
    t.parentNode.insertBefore(s, t);

}

jQuery(document).ready(function ($) {




//	setHeiHeight_Promo();
    $('#footer_widget').children().addClass('col-md-4');

    $(".title_location").focus();

    $('.submit_title .submit_add_message').addClass('slideDownRetourn');
    $('.submit_title .p_double').addClass('slideDownRetournSpeed');

    $('body').on("focus", '#feed_in', function (e) {
        $('.feed_input_func').slideDown(500);
    });


    $('body').on("click", '.pensil', function (e) {
        $('.feed_bottom').addClass('slideDownRetourn');
    });
    $('body').on("click", '.feed_close', function (e) {
        $('.feed_bottom').removeClass('slideDownRetourn').addClass('slideDown');
    });

    $('body').on("focus", '.title_location', function (e) {
        $('.submit_title .submit_add_message').addClass('slideDownRetourn');
        $('.submit_title .p_double').addClass('slideDownRetournSpeed');
    });
    $('body').on("focusout", '.title_location', function (e) {
        $('.submit_title .submit_add_message').removeClass('slideDownRetourn').addClass('slideLeft');
        $('.submit_title .p_double').addClass('slideLeft').removeClass('slideDownRetournSpeed');
    });
    $('body').on("focus", '#instaid', function (e) {

        $('#instagrams .submit_add_message').addClass('slideDownRetourn');
        $('#instagrams .p_double').addClass('slideDownRetournSpeed');
    });
    $('body').on("focusout", '#instaid', function (e) {
        $('#instagrams .submit_add_message').removeClass('slideDownRetourn').addClass('slideLeft');
        $('#instagrams .p_double').addClass('slideLeft').removeClass('slideDownRetournSpeed');
    });
    $('body').on("focus", '.sp_title', function (e) {
        $('#sp_title .submit_add_message').addClass('slideDownRetourn');
        $('#sp_title .p_double').addClass('slideDownRetournSpeed');
    });

    $('body').on("focusout", '.sp_title', function (e) {
        $('#sp_title .submit_add_message').removeClass('slideDownRetourn').addClass('slideLeft');
        $('#sp_title .p_double').addClass('slideLeft').removeClass('slideDownRetournSpeed');
    });
    $('body').on("focus", '.coupons', function (e) {
        $('#coupons .submit_add_message').addClass('slideDownRetourn');
        $('#coupons .p_double').addClass('slideDownRetournSpeed');
    });
    $('body').on("focusout", '.coupons', function (e) {
        $('#coupons .submit_add_message').removeClass('slideDownRetourn').addClass('slideLeft');
        $('#coupons .p_double').addClass('slideLeft').removeClass('slideDownRetournSpeed');
    });
    $('body').on("focus", '.stext', function (e) {
        $('#stext .submit_add_message').addClass('slideDownRetourn');
        $('#stext .p_double').addClass('slideDownRetournSpeed');
    });
    $('body').on("focusout", '.stext', function (e) {
        $('#stext .submit_add_message').removeClass('slideDownRetourn').addClass('slideLeft');
        $('#stext .p_double').addClass('slideLeft').removeClass('slideDownRetournSpeed');
    });
    $('body').on("focus", '#post_content_in', function (e) {
        $('#post_content .submit_add_message').addClass('slideDownRetourn');
        $('#post_content .p_double').addClass('slideDownRetournSpeed');
    });
    $('body').on("focusout", '#post_content_in', function (e) {
        $('#post_content .submit_add_message').removeClass('slideDownRetourn').addClass('slideLeft');
        $('#post_content .p_double').addClass('slideLeft').removeClass('slideDownRetournSpeed');
    });
    $('body').on("focus", '.bootstrap-tagsinput input', function (e) {
        $('#Tags_in .submit_add_message').addClass('slideDownRetourn');
        $('#Tags_in .p_double').addClass('slideDownRetournSpeed');
    });
    $('body').on("focusout", '.bootstrap-tagsinput input', function (e) {
        $('#Tags_in .submit_add_message').removeClass('slideDownRetourn').addClass('slideLeft');
        $('#Tags_in .p_double').addClass('slideLeft').removeClass('slideDownRetournSpeed');
    });
    $('body').on("focus", '#post_inside', function (e) {
        $('#post_inside .submit_add_message').addClass('slideDownRetourn');
        $('#post_inside .p_double').addClass('slideDownRetournSpeed');
    });
    $('body').on("focusout", '#post_inside', function (e) {
        $('.post_inside .submit_add_message').removeClass('slideDownRetourn').addClass('slideLeft');
        $('.post_inside .p_double').addClass('slideLeft').removeClass('slideDownRetournSpeed');
    });


    //Add Classes in DOM
    $('.addtoany_list').parent('div').addClass('center');
    $('.widget-area input#s').addClass('form-control');
    $('.widget-area #searchsubmit').addClass('btn btn-success');
    $('.reviews input').addClass('form-control');

    //Add inner head
    $('html').on('DOMMouseScroll mousewheel', function (e) {
        if ($('body').scrollTop() > 20) {
            $("#main_header").addClass("header").addClass("inner_head");
        } else {
            $("#main_header").removeClass("header").removeClass("inner_head");
        }
    });

    // On click show menu on small screen

    $('body').addClass('js');
    var $menu = $('#menu'),
        $menulink = $('.menu-link');

    $menulink.click(function () {
        $menulink.toggleClass('active');
        $menu.toggleClass('active');
        return false;
    });

    var toggled = 0;

    $('.menu-link').click(function () {
        if (toggled == 0) {
            $('.bar3').stop().transition({
                rotate: "45",
                "margin-top": "13px"
            });
            $('.bar2').stop().transition({
                opacity: "0"
            }, "fast");
            $('.bar1').stop().transition({
                rotate: "-45",
                "margin-top": "13px"
            });
            toggled++;
            ////console.log("toggled down")
        } else {

            $('.bar3').stop().transition({
                rotate: "+=135",
                "margin-top": "3px"
            });
            $('.bar2').transition({
                opacity: "1"
            }, "fast");
            $('.bar1').stop().transition({
                rotate: "-=135",
                "margin-top": "23px"
            });
            toggled--;
        }
    });

});

//Toggle hamburger

(function () {

    "use strict";

    var toggles = document.querySelectorAll(".c-hamburger");

    for (var i = toggles.length - 1; i >= 0; i--) {
        var toggle = toggles[i];
        toggleHandler(toggle);
    }
    ;

    function toggleHandler(toggle) {
        toggle.addEventListener("click", function (e) {
            e.preventDefault();
            (this.classList.contains("is-active") === true) ? this.classList.remove("is-active") : this.classList.add("is-active");
        });
    }

})();

(function () {
    var requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
        window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
    window.requestAnimationFrame = requestAnimationFrame;
})();

//Btn-hack in registration
jQuery(document).ready(function ($) {

    var btn;
    if (document.querySelector('.btn-hack')) {
        btn = document.querySelector('.btn-hack');

        var btnFront;
        btnFront = btn.querySelector('#auth_menu'); // !== null;

        if (btnFront) {
            var btnYes = btn.querySelector('.btn-back .yes'),
                btnNo = btn.querySelector('.btn-back .no');

            jQuery('#reg_close').on('click', function (event) {
                event.preventDefault();
                $(this).parents(".is-open").removeClass("is-open");

            });

            jQuery('#auth_menu').on('click', function (event) {

                var mx = event.clientX - btn.offsetLeft,
                    my = event.clientY - btn.offsetTop;
                event.preventDefault();
                var w = btn.offsetWidth,
                    h = btn.offsetHeight;

                var directions = [{
                    id: 'top',
                    x: w / 2,
                    y: 0
                }, {
                    id: 'right',
                    x: w,
                    y: h / 2
                }, {
                    id: 'bottom',
                    x: w / 2,
                    y: h
                }, {
                    id: 'left',
                    x: 0,
                    y: h / 2
                }
                ];

                directions.sort(function (a, b) {
                    return distance(mx, my, a.x, a.y) - distance(mx, my, b.x, b.y);
                });

                btn.setAttribute('data-direction', directions.shift().id);
                btn.classList.add('is-open');
                return false;
            });
            /*
             btnYes.addEventListener( 'click', function( event ) {
             btn.classList.remove( 'is-open' );
             return false;
             } );

             btnNo.addEventListener( 'click', function( event ) {
             btn.classList.remove( 'is-open' );
             return false;
             } ); */
        }
    }

    function distance(x1, y1, x2, y2) {
        var dx = x1 - x2;
        var dy = y1 - y2;
        return Math.sqrt(dx * dx + dy * dy);
    }

});

"use strict";

var height = 0;
if (jQuery('#wpadminbar')) {
    height = 350;
} else {
    height = jQuery('.page_info').outerHeight(true) - jQuery('.map_header').outerHeight(true);
}


if (jQuery('#myAffix')) {
    jQuery('#myAffix').affix({
        offset: {
            top: 350,
            bottom: function () {
                return (this.bottom = jQuery('footer').outerHeight(true))
            }

        }
    });
}
function parallaxHeight() {
    var windowW = jQuery(window).width(),
        windowhH = jQuery(window).height();
    if (windowW > 1500) {
        jQuery('#hero-bg').css({
            'min-height': windowhH + 'px'
        });
    }
}
//Affix
jQuery(document).ready(function ($) {
    setTimeout(function () {
        var basic_h = $('.place-container-boxed .basic').outerHeight();
        $('.place-container-boxed .sidebar').outerHeight(basic_h);

    }, 4000);

    $('.tickera-input-field').addClass('form-control');
    parallaxHeight();
    jQuery(window).resize(function () {
        parallaxHeight();
    });

    $('.event_tickets').removeClass('tickera');

    /*if ($('div').is("#myAffix2")) {
     var str = 0;

     $(window).scroll(function () {
     var offset = $("#myAffix2").offset();
     var x = $("footer").offset();
     var topPadding = 0,
     bottomPadding = x.top;
     /*scroll*/
    /*	if ($(window).scrollTop() +100 > $(".sidebar").offset().top) {
     var height_ofset = jQuery('header.sticky').outerHeight(true);
     if ($('div').is('#wpadminbar')) {
     height_ofset = height_ofset + jQuery('#wpadminbar').outerHeight(true);
     }
     if (bottomPadding > $(window).scrollTop() + $("#myAffix2").height()) {
     if ($(this).scrollTop() > 1) {
     $("#myAffix2").css({
     "top" : "60px"
     });
     } else {
     $("#myAffix2").css({
     "top" : "121px"
     });
     }
     str = $(window).scrollTop() - offset.top + topPadding;

     $("#myAffix2").addClass("fixed");
     }
     if (bottomPadding < $(window).scrollTop() + $("#myAffix2").height()) {
     $("#myAffix2").removeClass("fixed");
     $("#myAffix2").css({
     "top" : str
     });
     }
     } else {
     $("#myAffix2").removeClass("fixed");
     $("#myAffix2").css({
     "top" : "0px"
     });
     }
     });
     }*/
});

function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}


function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
