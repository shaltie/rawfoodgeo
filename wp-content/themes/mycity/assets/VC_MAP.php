<?php
/*==========================================================vc_map==================================*/
add_action('vc_before_init', 'mycity_top_promo_bloc_integrateWithVC');
function mycity_top_promo_bloc_integrateWithVC()
{
    if (!function_exists('vc_map')) return;
    vc_map(array(
        "name" => esc_html__("Mycity top promo bloc", 'mycity'),
        "base" => "mycity_top_promo_bloc",
        "class" => "",
        "category" => esc_html__("MyCity", 'mycity'),
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Text header", 'mycity'),
                "param_name" => "h",
                "value" => esc_html__("welcome to my city guide!", 'mycity'),
                "description" => esc_html__("Text header", 'mycity')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Description under the heading", 'mycity'),
                "param_name" => "desc",
                "value" => esc_html__("See and visit interesting places. Share experiences with your friends. Simply", 'mycity'),
                "description" => esc_html__("Description under the heading.", 'mycity')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Text Find", 'mycity'),
                "param_name" => "find",
                "value" => esc_html__("Find places or events", 'mycity'),
                "description" => esc_html__("Text Find.", 'mycity')
            ),

            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Text Select category", 'mycity'),
                "param_name" => "sc",
                "value" => esc_html__("Select category", 'mycity'),
                "description" => esc_html__("Text Select category.", 'mycity')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_html__("Text Select type", 'mycity'),
                "param_name" => "st",
                "value" => esc_html__("Select type", 'mycity'),
                "description" => esc_html__("Select type Select category.", 'mycity')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_html__("Text Select type places text", 'mycity'),
                "param_name" => "stp",
                "value" => esc_html__("Places", 'mycity'),
                "description" => esc_html__("Text Selectca tegory.", 'mycity')
            ),

            array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_html__("Text Select type All text", 'mycity'),
                "param_name" => "sta",
                "value" => esc_html__("All", 'mycity'),
                "description" => esc_html__("Text Selectca tegory.", 'mycity')
            ),

            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Text button search", 'mycity'),
                "param_name" => "search",
                "value" => esc_html__("search", 'mycity'),
                "description" => esc_html__("Text button search", 'mycity')
            ),


        )
    ));

//Mycity item wide

    //mycity_item_wide
    vc_map(array(
        "name" => esc_html__("Mycity item wide", 'mycity'),
        "base" => "mycity_item_wide",
        "class" => "",
        "category" => esc_html__("MyCity", 'mycity'),
        'is_container' => true,
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Text header1", 'mycity'),
                "param_name" => "h",
                "value" => esc_html__('Features My City', 'mycity'),
                "description" => esc_html__("Text header", 'mycity')
            ),


        ),
        "js_view" => 'VcColumnView',
    ));

    if (class_exists('WPBakeryShortCodesContainer')) {
        class WPBakeryShortCode_mycity_item_wide extends WPBakeryShortCodesContainer
        {
        }
    }

    vc_map(array(
        "name" => esc_html__("Mycity features block", 'mycity'),
        "base" => "mycity_features_block",
        "class" => "",

        "category" => esc_html__("MyCity", 'mycity'),
        'as_parent' => array(
            'only' => 'mycity_item_wide'

        ),
        "params" => array(

            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Text header1", 'mycity'),
                "param_name" => "h",
                "value" => esc_html__('Features My City', 'mycity'),
                "description" => esc_html__("Text header", 'mycity')
            )
        ,

            array(
                "type" => "iconpicker",
                "heading" => esc_html__("The icons 1 ", "mycity"),
                "param_name" => "icon",
                "value" => 'fa-mobile',
                "description" => esc_html__("insert icon", "mycity"),
                "settings" => array(
                    "emptyIcon" => false,
                    "iconsPerPage" => 4000,
                )
            ),
            array(
                "type" => "textarea",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Description", 'mycity'),
                "param_name" => "content",
                "value" => esc_html__('Features My City', 'mycity'),
                "description" => esc_html__("Text header", 'mycity')
            )
        ,
        )
    ));


    /**************************************************************************************/

    vc_map(array(
        "name" => esc_html__("Mycity category block", 'mycity'),
        "base" => "mycity_categori_block",
        "class" => "",
        "category" => esc_html__("MyCity", 'mycity'),
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Text header", 'mycity'),
                "param_name" => "h",
                "value" => esc_html__("We know all the places in your city", 'mycity'),
                "description" => esc_html__("Text header", 'mycity')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Description under the heading", 'mycity'),
                "param_name" => "btn",
                "value" => esc_html__("all places", 'mycity'),
                "description" => esc_html__("Description under the heading.", 'mycity')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("insert url button", 'mycity'),
                "param_name" => "url",
                "value" => '/places',
                "description" => esc_html__("Url to button View all places", 'mycity')
            ),


        )
    ));


    /****************Mycity  map********/

    vc_map(array(
        "name" => esc_html__("Mycity  map", 'mycity'),
        "base" => "mycity_map",
        "class" => "",
        "category" => esc_html__("MyCity", 'mycity'),
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Text header", 'mycity'),
                "param_name" => "h",
                "value" => esc_html__("View full place catalog", 'mycity'),
                "description" => esc_html__("Text header", 'mycity')
            )


        )
    ));

    /****************mycity_users_blocks********/

    vc_map(array(
        "name" => esc_html__("Mycity users blocks", 'mycity'),
        "base" => "mycity_users_blocks",
        "class" => "",
        "category" => esc_html__("MyCity", 'mycity'),
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Text header", 'mycity'),
                "param_name" => "h",
                "value" => esc_html__("The best user weekly", 'mycity'),
                "description" => esc_html__("Text header", 'mycity')
            )


        )
    ));


    vc_map(array(
        "name" => esc_html__("Mycity  table price", 'mycity'),
        "base" => "mycity_price_table",
        "class" => "",
        "category" => esc_html__("MyCity", 'mycity'),
        'custom_markup' => '{{title}}<div class="vc_btn3-container"><h4 class="team-name"></h4></div>',

        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Text header", 'mycity'),
                "param_name" => "h",
                "value" => esc_html__("See and visit interesting places. Share experiences with your friends. Simply", 'mycity'),
                "description" => esc_html__("Text header", 'mycity')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Text button 1", 'mycity'),
                "param_name" => "bt1",
                "description" => esc_html__("Insert text", 'mycity')
            ),

            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("url button 1", 'mycity'),
                "param_name" => "url1",
                "description" => esc_html__("Insert url", 'mycity')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Text button 2", 'mycity'),
                "param_name" => "bt2",
                "description" => esc_html__("Insert text", 'mycity')
            ),

            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("url button 2", 'mycity'),
                "param_name" => "url2",
                "description" => esc_html__("Insert url", 'mycity')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Text button 3", 'mycity'),
                "param_name" => "bt3",
                "description" => esc_html__("Insert text", 'mycity')
            ),

            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("url button 3", 'mycity'),
                "param_name" => "url3",
                "description" => esc_html__("Insert url", 'mycity')
            ),

            array(
                'type' => 'param_group',
                'holder' => 'div',
                'heading' => esc_html__('Other  Details', 'mycity'),
                'param_name' => 'items1',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__('Text', 'mycity'),
                        'param_name' => 'title',
                        'description' => esc_html__('insert text', 'mycity')
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__('Text description', 'mycity'),
                        'param_name' => 'value',
                        'description' => esc_html__('insert number progress from 0 to 100 ', 'mycity')
                    ),


                ),
            ),
            array(
                'type' => 'param_group',
                'holder' => 'div',
                'heading' => esc_html__('Other  Details', 'mycity'),
                'param_name' => 'items2',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__('Text', 'mycity'),
                        'param_name' => 'title',
                        'description' => esc_html__('insert text', 'mycity')
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__('Text description', 'mycity'),
                        'param_name' => 'value',
                        'description' => esc_html__('insert number progress from 0 to 100 ', 'mycity')
                    ),


                ),
            ),
            array(
                'type' => 'param_group',
                'holder' => 'div',
                'heading' => esc_html__('Other  Details', 'mycity'),
                'param_name' => 'items3',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__('Text', 'mycity'),
                        'param_name' => 'title',
                        'description' => esc_html__('insert text', 'mycity')
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__('Text description', 'mycity'),
                        'param_name' => 'value',
                        'description' => esc_html__('insert number progress from 0 to 100 ', 'mycity')
                    ),


                ),
            ),

        )
    ));
    /****************mycity_places_block********/
    $mycity_categories = get_categories("child_of=0&paren=0&taxonomy=places_categories&hide_empty=0");


    $arr_cats = array(
        esc_html__('None', 'rentit') => '0'
    );
    if ($mycity_categories) {
        foreach ($mycity_categories as $place_cat) {
            $arr_cats[$place_cat->name] = $place_cat->slug;
        }
    }

    vc_map(array(
        "name" => esc_html__("Mycity places block", 'mycity'),
        "base" => "mycity_places_block",
        "class" => "",
        "category" => esc_html__("MyCity", 'mycity'),
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Widget title", 'mycity'),
                "param_name" => "h",
                "value" => esc_html__("The best places weekly", 'mycity'),
                "description" => esc_html__("title", 'mycity')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("button text", 'mycity'),
                "param_name" => "btn",
                "value" => esc_html__("all places", 'mycity'),
                "description" => esc_html__("Description under the heading.", 'mycity')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("How show places?", 'mycity'),
                "param_name" => "count",
                "value" => 3,
                "description" => esc_html__("insert number", 'mycity')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("max chars in description", 'mycity'),
                "param_name" => "max_chars",
                "value" => 250,
                "description" => esc_html__("insert number", 'mycity')
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Show rating?', 'mycity'),
                'value' => array(
                    esc_html__('Yes', 'mycity') => '1',
                    esc_html__('No', 'mycity') => '0',

                ),
                'param_name' => 'show_rating'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Custom Categories', 'mycity'),
                'value' => $arr_cats,
                'param_name' => 'cat'
            ),


        )
    ));

}


