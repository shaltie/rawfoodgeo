<?php
/**
 * Adds sections and settings to customizer
 *
 * @param $wp_customize
 */
function mycity_true_customizer_init( $wp_customize ) {
	//Panels
	$wp_customize->add_panel( 'panel1', array(
		'title'       => esc_html__( 'Main page', 'mycity' ),
		'description' => esc_html__( 'Settings of the main page', 'mycity' ),
	) );
	$wp_customize->add_panel( 'panel2', array(
		'title'       => esc_html__( 'Members', 'mycity' ),
		'description' => esc_html__( 'Settings of the main page', 'mycity' ),
	) );

	/*-------------------------------weather ------------------------------*/
	//Member list styles 2
	$tmp_sectionname = "weather";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'       => esc_html__( 'Weather', 'mycity' ),
		'priority'    => 29,
		'description' => ''
	) );
	$tmp_settingname = $tmp_sectionname . '_weather_control';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => 's2',
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Weather options', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'radio',
		'choices'  => array(
			's1' => esc_html__( 'Degrees Fahrenheit', 'mycity' ),
			's2' => esc_html__( 'Degrees celsius', 'mycity' ),
			's3' => esc_html__( 'Do not show weather on site', 'mycity' ),
		)
	) );
	$tmp_settingname = $tmp_sectionname . '_weather_latitude';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Weather  cordinats latitude  ', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );
	$tmp_settingname = $tmp_sectionname . '_weather_longitude';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Weather  cordinats longitude  ', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );

	//APPID=5deaff61bf92480a0a73e9a29d4fc9de
	$tmp_settingname = $tmp_sectionname . '_weather_APPID';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Weather  APPDI KEY  http://openweathermap.org/appid ', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );


	/*---------------------------------------events-----------------------------------------------*/

	//Member list styles 2
	$tmp_sectionname = "events";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'       => esc_html__( 'Events', 'mycity' ),
		'priority'    => 29,
		'description' => ''
	) );
	$tmp_settingname = $tmp_sectionname . '_events_control';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => false,
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Events default style?', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );

	/*---------------------------------------Mobile-----------------------------------------------*/

	//Member list styles 2
	$tmp_sectionname = "mobile";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'       => esc_html__( 'Mobile', 'mycity' ),
		'priority'    => 29,
		'description' => ''
	) );
	$tmp_settingname = $tmp_sectionname . '_bg';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => true,
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Enable background on Mobile device? ', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );

	/*--------------------------------------------------- performans----------------------*/
	$tmp_sectionname = "performans";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'       => esc_html__( 'Performance', 'mycity' ),
		'priority'    => 31,
		'description' => ''
	) );
	$tmp_settingname = $tmp_sectionname . '_paralax_hidde';

	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => false,
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Disable Paralax?', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );
	/*Enable Smoth Scroll*/
	$tmp_settingname = $tmp_sectionname . '_scroll_hidde';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => false,
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Enable Smoth Scroll?', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );


	/*Enable smail header*/
	$tmp_settingname = $tmp_sectionname . '_small_h';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => true,
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'small header in list?', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );

	/*Enable Get Directions*/
	$tmp_settingname = $tmp_sectionname . '_directories';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => true,
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    =>  esc_html__( 'Enable Get Directions button ?', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );


	/*-----------
	/*---------------------------------------------------  Airbnb ----------------------*/
	$tmp_sectionname = "airbnb";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'       => esc_html__( 'Airbnb', 'mycity' ),
		'priority'    => 31,
		'description' => ''
	) );
	$tmp_settingname = $tmp_sectionname . '_url';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_url'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( ' Insert a link on the search results Airbnb.', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );


	$tmp_settingname = $tmp_sectionname . '_referal';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_url'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Referal link.', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );

	/*--------------------------  Premium payment ----------------------*/
	$tmp_sectionname = "premium";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'       => esc_html__( 'Premium listing', 'mycity' ),
		'priority'    => 31,
		'description' => ''
	) );

	$tmp_settingname = $tmp_sectionname . '_stripesecret';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_html'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( ' Stripe Secret API key.', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );

	$tmp_settingname = $tmp_sectionname . '_stripepub';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_html'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( ' Stripe Publish API key.', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );

	$tmp_settingname = $tmp_sectionname . '_tarif1n';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_html'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Tarif1 name', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );
	$tmp_settingname = $tmp_sectionname . '_tarif1price';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_html'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Tarif1 price', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );

	$tmp_settingname = $tmp_sectionname . '_tarif2n';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_html'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Tarif2 name', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );
	$tmp_settingname = $tmp_sectionname . '_tarif2price';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_html'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Tarif2 price', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );
	/*--------------------------------------------------- UBER ----------------------*/
	$tmp_sectionname = "uber";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'       => esc_html__( 'Routing & Uber taxi', 'mycity' ),
		'priority'    => 31,
		'description' => ''
	) );

	$tmp_settingname = $tmp_sectionname . '_show_distance';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Show distance and Estimate Time of Arrival based on coordinates', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );

	$tmp_settingname = $tmp_sectionname . '_show_distance_txt';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => 'About XX min. from you (~ YY km)',
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Distance text (Not showing if guest far then 100km)', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );

	$tmp_settingname = $tmp_sectionname . '_show_distance_speed';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '15',
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Average speed in the city (km/h)', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );

	$tmp_settingname = $tmp_sectionname . '_client_id';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Client id', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );


	$tmp_settingname = $tmp_sectionname . '_unavailable_button';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => false,
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Hide button "Go" if service unavailable', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );


	$tmp_settingname = $tmp_sectionname . '_unavailable_message';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => 'Taxi service unavailable for your location :(',
		'sanitize_callback' => 'sanitize_text_field'
	) );
	$wp_customize->add_control( $tmp_sectionname . '_control', array(
		'label'    => esc_html__( 'Taxi unavailable message', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );

	$tmp_settingname = $tmp_sectionname . '_unavailable_text_2';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => esc_html__( 'Go', 'mycity' ),
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Text Go button ', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );


	$tmp_settingname = $tmp_sectionname . '_url_go';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field'
	) );
	$wp_customize->add_control( $tmp_sectionname . '_control', array(
		'label'    => esc_html__( 'Url Go button', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );


	$tmp_settingname = $tmp_sectionname . '_more_button';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => false,
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Enable More button mode?', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );

	/*---------------------------------------------------Fonts----------------------*/
	$tmp_sectionname = "fonts";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'       => esc_html__( 'Fonts', 'mycity' ),
		'priority'    => 31,
		'description' => esc_html__( 'Enter the url font google and font name', 'mycity' )
	) );
	$tmp_settingname = $tmp_sectionname . '_url';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => "",
		'sanitize_callback' => 'esc_html'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'url google fonts', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );

	$tmp_settingname = $tmp_sectionname . '_name';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => "",
		'sanitize_callback' => 'wp_kses_post'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'name google fonts', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );


	/*---------------------------------------------------mailchimp----------------------*/
	$tmp_sectionname = "mailchimp";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'       => esc_html__( 'Mailchimp', 'mycity' ),
		'priority'    => 31,
		'description' => esc_html__( 'Specify api key and ID list', 'mycity' )
	) );
	$tmp_settingname = $tmp_sectionname . '_api_control';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => "",
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( '_control', array(
		'label'    => esc_html__( 'API key', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );


	$tmp_settingname = $tmp_sectionname . 'id_list_control';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => "",
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'ID list', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );


	$tmp_settingname = $tmp_sectionname . 'id_list_control2';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => "",
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'ID list2', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );


	/*---------------------------------------------------langs----------------------*/
	$tmp_sectionname = "langs";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'    => esc_html__( 'Language', 'mycity' ),
		'priority' => 31,
	) );
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => false,
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Enable multilang? [beta]', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );


	$tmp_settingname = $tmp_sectionname . '_lang';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => true,
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Users can change the language', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );
	/*---------------------------------------------------Single post----------------------*/
	$tmp_sectionname = "single_post";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'       => esc_html__( 'Single post/page', 'mycity' ),
		'priority'    => 31,
		'description' => ''
	) );
	$tmp_settingname = $tmp_sectionname . '_single_post_control';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => false,
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Hide Subscribe?', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );

	$tmp_settingname = $tmp_sectionname . '_hide_excerpt';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => false,
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Hide the text under the title?', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );


	/*---------------------------------------------------Item page----------------------*/
	$tmp_sectionname = "item_page";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'       => esc_html__( 'Items', 'mycity' ),
		'priority'    => 31,
		'description' => ''
	) );
	$tmp_settingname = $tmp_sectionname . '_control_share';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => true,
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Show share button?', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );
	/**/
	$tmp_settingname = $tmp_sectionname . '_phone';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => true,
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Show the phone and website in places?', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );
	/**/
	$tmp_settingname = $tmp_sectionname . '_follow2';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => true,
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Include the ability to follow?', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'checkbox'
	) );


	$tmp_settingname = $tmp_sectionname . '_firststatus';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => 'publish',
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Status place when adding', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'select',
		'choices'  => array(
			'publish' => esc_html__( 'Publish', 'mycity' ),
			'draft'   => esc_html__( 'Draft', 'mycity' ),
		)
	) );
	/*-----------------------------Sotial networks---------------------------*/
	$tmp_sectionname = "sotial_networks";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'       => esc_html__( 'Social networks', 'mycity' ),
		'priority'    => 31,
		'description' => esc_html__( 'Enter url desired social networks so that they appear on the site', 'mycity' )
	) );
	/*Google */


	$tmp_settingname = $tmp_sectionname . '_control_google';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_url'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Google + url', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );
	/*VK*/
	$tmp_settingname = $tmp_sectionname . '_control_VK';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_url'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'VK  url', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );
	/*facebook*/
	$tmp_settingname = $tmp_sectionname . '_control_facebook';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_url'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Facebook  url', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );
	/*instagram*/
	$tmp_settingname = $tmp_sectionname . '_control_instagram';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_url'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Instagram  url', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );
	/*twitter*/
	$tmp_settingname = $tmp_sectionname . '_control_twitter';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'esc_url'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Twitter url', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'text'
	) );
	/*-----------------------------Site Identity---------------------------*/
	$tmp_sectionname = "site_Identity";


	$wp_customize->add_section( $tmp_sectionname . '_section_m', array(
		'title'       => esc_html__( 'Site Identity', 'mycity' ),
		'priority'    => 31,
		'description' => ''
	) );

	$tmp_settingname = $tmp_sectionname . '_modern';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => 's2',
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Archive style', 'mycity' ),
		'section'  => 'title_tagline',
		'settings' => $tmp_settingname,
		'type'     => 'select',
		'choices'  => array(
			's1' => esc_html__( 'modern', 'mycity' ),
			's2' => esc_html__( 'masonry', 'mycity' ),
		)
	) );


	$tmp_sectionname = "site_Identity";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'       => esc_html__( 'Site Identity', 'mycity' ),
		'priority'    => 31,
		'description' => ''
	) );

	$tmp_settingname = $tmp_sectionname . '_layout';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => 's2',
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Layout', 'mycity' ),
		'section'  => 'title_tagline',
		'settings' => $tmp_settingname,
		'type'     => 'select',
		'choices'  => array(
			's1' => esc_html__( 'boxed', 'mycity' ),
			's2' => esc_html__( 'wide', 'mycity' ),
		)
	) );

	/********************************/


	$tmp_settingname = $tmp_sectionname . '_single_post_typed_news_2';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => false,
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Show 1st post instead of the title and category description', 'mycity' ),
		'section'  => 'title_tagline',
		'settings' => $tmp_settingname,
		'type'     => 'checkbox',
	) );

	$tmp_settingname = $tmp_sectionname . '_single_hide_cat';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => false,
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Hide categories', 'mycity' ),
		'section'  => 'title_tagline',
		'settings' => $tmp_settingname,
		'type'     => 'checkbox',
	) );


	$tmp_settingname = $tmp_sectionname . '_fog';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => false,
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Hide fog on main page', 'mycity' ),
		'section'  => 'title_tagline',
		'settings' => $tmp_settingname,
		'type'     => 'checkbox',
	) );
	$tmp_settingname = $tmp_sectionname . '_geolocation';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => false,
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Disable auto request user location', 'mycity' ),
		'section'  => 'title_tagline',
		'settings' => $tmp_settingname,
		'type'     => 'checkbox',
	) );

	/*-------------------------------top header ------------------------------*/
	//add_section
	$wp_customize->add_section( 'mycity_top_header', array(
		'title'       => 'Top header',
		'description' => '',
		'priority'    => 31,
	) );
	//add setting
	$wp_customize->add_setting( 'mycity_top_header_left', array(
		'default'           => "",
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	$wp_customize->add_setting( 'mycity_top_header_right', array(
		'default'           => "",
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	//add control
	$wp_customize->add_control( 'ok_video_url1', array(
		'label'    => 'Top header left',
		'section'  => 'mycity_top_header',
		'type'     => 'textarea',
		'settings' => 'mycity_top_header_left'
	) );
	$wp_customize->add_control( 'Top_header_right', array(
		'label'    => 'Top header right',
		'section'  => 'mycity_top_header',
		'type'     => 'textarea',
		'settings' => 'mycity_top_header_right'
	) );
	/*-----------------------------Video background-----------------------------*/
	$wp_customize->add_section( 'video_background', array(
		'title'       => 'Video background',
		'description' => '',
		'priority'    => 31,
	) );
	$wp_customize->add_setting( 'my_ok_video_url', array(
		'default'           => "",
		'sanitize_callback' => 'MyCity_sanitize_ok_video'
	) );
	//        video verification
	$wp_customize->add_control( 'ok_video_url', array(
		'label'    => 'Insert id or url as YouTube',
		'section'  => 'video_background',
		'type'     => 'url',
		'settings' => 'my_ok_video_url'
	) );
	//Testimonials style
	$wp_customize->add_section( 'Testimonials_section', array(
		'title'       => 'Testimonials style',
		'description' => '',
		'priority'    => 35,
	) );
	$wp_customize->add_setting( 'my_Testimonials_short', array(
		'default'           =>
			"[show-testimonials orderby='menu_order' order='ASC' layout='grid' options='theme:speech,info-position:info-left,text-alignment:left,columns:2,charlimitextra:(...),display-image:on,image-size:ttshowcase_small,image-shape:circle,image-effect:none,image-link:on']",
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	$wp_customize->add_setting( 'my_Testimonials_form', array(
		'default'           =>
			"[show-testimonials-form subtitle='on' subtitle_url='on' image='on' rating='hover' email='on' logged='on' style='tt_style_2' ]",
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	$wp_customize->add_control( 'Shortcode_for_comments', array(
		'label'    => 'Shortcode for comments',
		'section'  => 'Testimonials_section',
		'type'     => 'textarea',
		'settings' => 'my_Testimonials_short'
	) );
	$wp_customize->add_control( 'Shortcode_for_comments_form', array(
		'label'    => 'Shortcode for comments form',
		'section'  => 'Testimonials_section',
		'type'     => 'textarea',
		'settings' => 'my_Testimonials_form'
	) );
	//Map style
	$tmp_sectionname = "map";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'       => esc_html__( 'Map style', 'mycity' ),
		'priority'    => 30,
		'description' => 'Map style JSON config (see https://snazzymaps.com, http://www.mapstylr.com/showcase/ )'
	) );
	$tmp_tabel        = 'stylemap_json';
	$tmp_settingname  = $tmp_sectionname . '_' . $tmp_tabel;
	$tmp_settingtitle = esc_html__( 'stylemap_json', 'mycity' );
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => $tmp_default,
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => $tmp_settingtitle,
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'textarea'
	) );
	$wp_customize->add_setting( 'Coordinates_map', array(
		'default'           =>
			'43.116161, 131.881485',
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( 'Coordinates_map' . '_control', array(
		'label'    => esc_html__( 'Coordinates map', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => 'Coordinates_map',
		'type'     => 'text'
	) );
	$wp_customize->add_setting( 'map_zoom_map', array(
		'default'           => 13,
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( 'map_zoom_map' . '_control', array(
		'label'    => esc_html__( 'Zoom map', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => 'map_zoom_map',
		'type'     => 'text'
	) );

	$wp_customize->add_setting( 'map_style', array(
		'default'           => 's2',
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( 'map_style' . '_control', array(
		'label'    => esc_html__( 'Select style place map', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => 'map_style',
		'type'     => 'radio',
		'choices'  => array(
			's1' => esc_html__( 'Old style', 'mycity' ),
			's2' => esc_html__( 'New style', 'mycity' ),
		)
	) );

	$wp_customize->add_setting( 'map_style_how_show_places', array(
		'default'           => 0,
		'sanitize_callback' => 'esc_attr'
	) );
	$wp_customize->add_control( 'map_style_how_show_places' . '_control', array(
		'label'    => esc_html__( 'How many shows the place the left near to a map? (0 if do not need to limit)', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => 'map_style_how_show_places',
		'type'     => 'number',
	) );

	//Member list styles
	$tmp_sectionname = "members";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'       => 'Members',
		'priority'    => 30,
		'panel'       => 'panel2',
		'description' => 'Hint: To see the changes, go to the correct page (in the right preview area -> )'
	) );
	$tmp_settingname = $tmp_sectionname . '_memberliststyle';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => '',
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => esc_html__( 'Tex preview: ', 'mycity' ),
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'radio',
		'choices'  => array(
			's1' => esc_html__( 'Simple', 'mycity' ),
			's2' => esc_html__( 'Extended', 'mycity' ),
			's3' => esc_html__( 'Table', 'mycity' ),
		)
	) );
	//colors
	global $wp_filesystem;
	//the existence check
	if ( empty( $wp_filesystem ) ) {
		require_once( ABSPATH . '/wp-admin/includes/file.php' );
		WP_Filesystem();
	}

	$mycity_upload_dir = wp_upload_dir();
	$mycity_filename   = trailingslashit( $mycity_upload_dir['basedir'] ) . 'main.css';


	if ( $wp_filesystem->exists( $mycity_filename ) ) {
		$con = $wp_filesystem->get_contents( 'mycity_css_php', $mycity_upload_dir["baseurl"] . "/main.css" );
	} else {
		$con = $wp_filesystem->get_contents( get_template_directory() . "/css/main.css" );
	}


	$con = mycity_color_hack( $con );
	preg_match_all( "/#([A-z0-9]{6,6}?)/", $con, $arr );
	$colors = $arr[1];
	foreach ( $colors as $k => $v ) {
		$colors[ $k ] = strtoupper( $v );
	}
	$colors = array_unique( $colors );
	$colors = array(
		"EF2121",
		"DD3333",
		"AD0202",
		"211530"
	);
	foreach ( $colors as $k => $v ) {
		$grb = mycity_Hex2RGB( $v );
		if ( $grb[0] == $grb[1] ) {
			continue;
		} //gray
		$tmp_sectionname = 'colors';
		$tmp_settingname = $tmp_sectionname . '_m_' . $v;
		$wp_customize->add_setting( $tmp_settingname, array(
			'default'           => "#" . $v,
			'sanitize_callback' => 'MyCity_sanitize_temp'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $tmp_settingname,
			array(
				'label'    => 'Color ' . $v . '',
				'section'  => $tmp_sectionname,
				'settings' => $tmp_settingname,
			) ) );
	}
	$tmp_sectionname = 'colors';
	$tmp_settingname = $tmp_sectionname . '_sidebar_w';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => "#fff",
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $tmp_settingname,
			array(
				'label'    => esc_html__( 'Background color sidebar', 'mycity' ),
				'section'  => $tmp_sectionname,
				'settings' => $tmp_settingname,
			) )
	);
	$tmp_settingname = $tmp_sectionname . '_sidebar_i';
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => "#F0F0F0",
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $tmp_settingname,
			array(
				'label'    => esc_html__( 'Background sidebar icons', 'mycity' ),
				'section'  => $tmp_sectionname,
				'settings' => $tmp_settingname,
			) )
	);

	//

	$wp_customize->add_section( 'themeslug_logo_section', array(
		'title'       => esc_html__( 'Logo', 'mycity' ),
		'priority'    => 30,
		'description' => 'Upload a logo to replace the default site name and description in the header',
	) );
	$wp_customize->add_setting( 'themeslug_logo', array(
		'sanitize_callback' =>
			'MyCity_sanitize_temp'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,
		'themeslug_logo', array(
			'label'    => esc_html__( 'Logo', 'mycity' ),
			'section'  => 'themeslug_logo_section',
			'settings' => 'themeslug_logo',
		) ) );

	//footer

	$tmp_sectionname = "footer";
	$wp_customize->add_section( $tmp_sectionname . '_section', array(
		'title'    => esc_html__( 'Footer', 'mycity' ),
		'priority' => 30
	) );
	$tmp_tabel        = 'footer_copyright';
	$tmp_settingname  = $tmp_sectionname . '_' . $tmp_tabel;
	$tmp_settingtitle = esc_html__( 'footer_copyright', 'mycity' );
	$wp_customize->add_setting( $tmp_settingname, array(
		'default'           => $tmp_default,
		'sanitize_callback' => 'MyCity_sanitize_temp'
	) );
	$wp_customize->add_control( $tmp_settingname . '_control', array(
		'label'    => $tmp_settingtitle,
		'section'  => $tmp_sectionname . "_section",
		'settings' => $tmp_settingname,
		'type'     => 'textarea'
	) );

	$tmp_tabel       = 'footer_img';
	$tmp_settingname = $tmp_sectionname . '_' . $tmp_tabel;
	$wp_customize->add_setting( $tmp_settingname, array(
		'sanitize_callback' =>
			'MyCity_sanitize_temp'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,
		$tmp_settingname, array(
			'label'    => esc_html__( 'Footer img', 'mycity' ),
			'section'  => $tmp_sectionname . "_section",
			'settings' => $tmp_settingname,
		) ) );

}

function MyCity_sanitize_temp( $value ) {
	return $value;
}

function MyCity_sanitize_ok_video( $value ) {
	$id = null;
	if ( preg_match( '/youtu.be\/(.*)/', $value, $math ) ) {
		$id = $math[1];
	} elseif ( preg_match( '/youtube.com.*?v=(.*)/', $value, $math ) ) {
		$id = $math[1];
	} else {
		$id = $value;
	}

	$id = str_replace( "http://", '', $id );
	$id = str_replace( "https://", '', $id );

	return $id;
}

function mycity_custom_toint() {

}

/**
 *Plug in  script to customize
 */
function mycity_custom_customize_enqueue() {
	wp_enqueue_script( 'custom-customize', get_template_directory_uri() .
	                                       '/js/custom.customize.js', array(
		'jquery',
		'customize-controls'
	), false, true );
}


add_action( 'customize_controls_enqueue_scripts',
	'mycity_custom_customize_enqueue' );
add_action( 'customize_register', 'mycity_true_customizer_init' );
?>