<?php
/**
 * Pharmacy Shop: Customizer
 *
 * @package Pharmacy Shop
 * @subpackage pharmacy_shop
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function pharmacy_shop_customize_register( $wp_customize ) {

	require get_parent_theme_file_path('/inc/controls/icon-changer.php');

	require get_parent_theme_file_path('/inc/controls/range-slider-control.php');

	// Register the custom control type.
	$wp_customize->register_control_type( 'Pharmacy_Shop_Toggle_Control' );

	//Register the sortable control type.
	$wp_customize->register_control_type( 'Pharmacy_Shop_Control_Sortable' );	

	//add home page setting pannel
	$wp_customize->add_panel( 'pharmacy_shop_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Custom Home page', 'pharmacy-shop' ),
	    'description' => __( 'Description of what this panel does.', 'pharmacy-shop' ),
	) );

	//TP Genral Option
	$wp_customize->add_section('pharmacy_shop_tp_general_settings',array(
        'title' => __('TP General Option', 'pharmacy-shop'),
        'priority' => 1,
        'panel' => 'pharmacy_shop_panel_id'
    ) );
 	$wp_customize->add_setting('pharmacy_shop_tp_body_layout_settings',array(
		'default' => 'Full',
		'sanitize_callback' => 'pharmacy_shop_sanitize_choices'
	));
 	$wp_customize->add_control('pharmacy_shop_tp_body_layout_settings',array(
		'type' => 'radio',
		'label'     => __('Body Layout Setting', 'pharmacy-shop'),
		'description'   => __('This option work for complete body, if you want to set the complete website in container.', 'pharmacy-shop'),
		'section' => 'pharmacy_shop_tp_general_settings',
		'choices' => array(
		'Full' => __('Full','pharmacy-shop'),
		'Container' => __('Container','pharmacy-shop'),
		'Container Fluid' => __('Container Fluid','pharmacy-shop')
		),
	) );

    // Add Settings and Controls for Post Layout
	$wp_customize->add_setting('pharmacy_shop_sidebar_post_layout',array(
     'default' => 'right',
     'sanitize_callback' => 'pharmacy_shop_sanitize_choices'
	));
	$wp_customize->add_control('pharmacy_shop_sidebar_post_layout',array(
     'type' => 'radio',
     'label'     => __('Post Sidebar Position', 'pharmacy-shop'),
     'description'   => __('This option work for blog page, blog single page, archive page and search page.', 'pharmacy-shop'),
     'section' => 'pharmacy_shop_tp_general_settings',
     'choices' => array(
         'full' => __('Full','pharmacy-shop'),
         'left' => __('Left','pharmacy-shop'),
         'right' => __('Right','pharmacy-shop'),
         'three-column' => __('Three Columns','pharmacy-shop'),
         'four-column' => __('Four Columns','pharmacy-shop'),
         'grid' => __('Grid Layout','pharmacy-shop')
     ),
	) );

	// Add Settings and Controls for single post sidebar Layout
	$wp_customize->add_setting('pharmacy_shop_sidebar_single_post_layout',array(
        'default' => 'right',
        'sanitize_callback' => 'pharmacy_shop_sanitize_choices'
	));
	$wp_customize->add_control('pharmacy_shop_sidebar_single_post_layout',array(
        'type' => 'radio',
        'label'     => __('Single Post Sidebar Position', 'pharmacy-shop'),
        'description'   => __('This option work for single blog page', 'pharmacy-shop'),
        'section' => 'pharmacy_shop_tp_general_settings',
        'choices' => array(
            'full' => __('Full','pharmacy-shop'),
            'left' => __('Left','pharmacy-shop'),
            'right' => __('Right','pharmacy-shop'),
        ),
	) );

	// Add Settings and Controls for Page Layout
	$wp_customize->add_setting('pharmacy_shop_sidebar_page_layout',array(
     'default' => 'right',
     'sanitize_callback' => 'pharmacy_shop_sanitize_choices'
	));
	$wp_customize->add_control('pharmacy_shop_sidebar_page_layout',array(
     'type' => 'radio',
     'label'     => __('Page Sidebar Position', 'pharmacy-shop'),
     'description'   => __('This option work for pages.', 'pharmacy-shop'),
     'section' => 'pharmacy_shop_tp_general_settings',
     'choices' => array(
         'full' => __('Full','pharmacy-shop'),
         'left' => __('Left','pharmacy-shop'),
         'right' => __('Right','pharmacy-shop')
     ),
	) );

	//tp typography option
	$pharmacy_shop_font_array = array(
		''                       => 'No Fonts',
		'Abril Fatface'          => 'Abril Fatface',
		'Acme'                   => 'Acme',
		'Anton'                  => 'Anton',
		'Architects Daughter'    => 'Architects Daughter',
		'Arimo'                  => 'Arimo',
		'Arsenal'                => 'Arsenal',
		'Arvo'                   => 'Arvo',
		'Alegreya'               => 'Alegreya',
		'Alfa Slab One'          => 'Alfa Slab One',
		'Averia Serif Libre'     => 'Averia Serif Libre',
		'Bangers'                => 'Bangers',
		'Boogaloo'               => 'Boogaloo',
		'Bad Script'             => 'Bad Script',
		'Bitter'                 => 'Bitter',
		'Bree Serif'             => 'Bree Serif',
		'BenchNine'              => 'BenchNine',
		'Cabin'                  => 'Cabin',
		'Cardo'                  => 'Cardo',
		'Courgette'              => 'Courgette',
		'Cherry Swash'           => 'Cherry Swash',
		'Cormorant Garamond'     => 'Cormorant Garamond',
		'Crimson Text'           => 'Crimson Text',
		'Cuprum'                 => 'Cuprum',
		'Cookie'                 => 'Cookie',
		'Chewy'                  => 'Chewy',
		'Days One'               => 'Days One',
		'Dosis'                  => 'Dosis',
		'Droid Sans'             => 'Droid Sans',
		'Economica'              => 'Economica',
		'Fredoka One'            => 'Fredoka One',
		'Fjalla One'             => 'Fjalla One',
		'Francois One'           => 'Francois One',
		'Frank Ruhl Libre'       => 'Frank Ruhl Libre',
		'Gloria Hallelujah'      => 'Gloria Hallelujah',
		'Great Vibes'            => 'Great Vibes',
		'Handlee'                => 'Handlee',
		'Hammersmith One'        => 'Hammersmith One',
		'Inconsolata'            => 'Inconsolata',
		'Indie Flower'           => 'Indie Flower',
		'IM Fell English SC'     => 'IM Fell English SC',
		'Julius Sans One'        => 'Julius Sans One',
		'Josefin Slab'           => 'Josefin Slab',
		'Josefin Sans'           => 'Josefin Sans',
		'Kanit'                  => 'Kanit',
		'Lobster'                => 'Lobster',
		'Lato'                   => 'Lato',
		'Lora'                   => 'Lora',
		'Libre Baskerville'      => 'Libre Baskerville',
		'Lobster Two'            => 'Lobster Two',
		'Merriweather'           => 'Merriweather',
		'Monda'                  => 'Monda',
		'Montserrat'             => 'Montserrat',
		'Muli'                   => 'Muli',
		'Marck Script'           => 'Marck Script',
		'Noto Serif'             => 'Noto Serif',
		'Open Sans'              => 'Open Sans',
		'Overpass'               => 'Overpass',
		'Overpass Mono'          => 'Overpass Mono',
		'Oxygen'                 => 'Oxygen',
		'Orbitron'               => 'Orbitron',
		'Patua One'              => 'Patua One',
		'Pacifico'               => 'Pacifico',
		'Padauk'                 => 'Padauk',
		'Playball'               => 'Playball',
		'Playfair Display'       => 'Playfair Display',
		'PT Sans'                => 'PT Sans',
		'Philosopher'            => 'Philosopher',
		'Permanent Marker'       => 'Permanent Marker',
		'Poiret One'             => 'Poiret One',
		'Quicksand'              => 'Quicksand',
		'Quattrocento Sans'      => 'Quattrocento Sans',
		'Raleway'                => 'Raleway',
		'Rubik'                  => 'Rubik',
		'Rokkitt'                => 'Rokkitt',
		'Russo One'              => 'Russo One',
		'Righteous'              => 'Righteous',
		'Slabo'                  => 'Slabo',
		'Source Sans Pro'        => 'Source Sans Pro',
		'Shadows Into Light Two' => 'Shadows Into Light Two',
		'Shadows Into Light'     => 'Shadows Into Light',
		'Sacramento'             => 'Sacramento',
		'Shrikhand'              => 'Shrikhand',
		'Tangerine'              => 'Tangerine',
		'Ubuntu'                 => 'Ubuntu',
		'VT323'                  => 'VT323',
		'Varela Round'           => 'Varela Round',
		'Vampiro One'            => 'Vampiro One',
		'Vollkorn'               => 'Vollkorn',
		'Volkhov'                => 'Volkhov',
		'Yanone Kaffeesatz'      => 'Yanone Kaffeesatz'
	);

	$wp_customize->add_section('pharmacy_shop_typography_option',array(
		'title'         => __('TP Typography Option', 'pharmacy-shop'),
		'priority' => 1,
		'panel' => 'pharmacy_shop_panel_id'
   	));

   	$wp_customize->add_setting('pharmacy_shop_heading_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'pharmacy_shop_sanitize_choices',
	));
	$wp_customize->add_control(	'pharmacy_shop_heading_font_family', array(
		'section' => 'pharmacy_shop_typography_option',
		'label'   => __('heading Fonts', 'pharmacy-shop'),
		'type'    => 'select',
		'choices' => $pharmacy_shop_font_array,
	));

	$wp_customize->add_setting('pharmacy_shop_body_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'pharmacy_shop_sanitize_choices',
	));
	$wp_customize->add_control(	'pharmacy_shop_body_font_family', array(
		'section' => 'pharmacy_shop_typography_option',
		'label'   => __('Body Fonts', 'pharmacy-shop'),
		'type'    => 'select',
		'choices' => $pharmacy_shop_font_array,
	));

	//TP Preloader Option
	$wp_customize->add_section('pharmacy_shop_prelaoder_option',array(
		'title'         => __('TP Preloader Option', 'pharmacy-shop'),
		'priority' => 1,
		'panel' => 'pharmacy_shop_panel_id'
	) );
	$wp_customize->add_setting( 'pharmacy_shop_preloader_show_hide', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_preloader_show_hide', array(
		'label'       => esc_html__( 'Show / Hide Preloader Option', 'pharmacy-shop' ),
		'section'     => 'pharmacy_shop_prelaoder_option',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_preloader_show_hide',
	) ) );
	$wp_customize->add_setting( 'pharmacy_shop_tp_preloader_color1_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pharmacy_shop_tp_preloader_color1_option', array(
			'label'     => __('Preloader First Ring Color', 'pharmacy-shop'),
	    'description' => __('It will change the complete theme preloader ring 1 color in one click.', 'pharmacy-shop'),
	    'section' => 'pharmacy_shop_prelaoder_option',
	    'settings' => 'pharmacy_shop_tp_preloader_color1_option',
  	)));
  	$wp_customize->add_setting( 'pharmacy_shop_tp_preloader_color2_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pharmacy_shop_tp_preloader_color2_option', array(
			'label'     => __('Preloader Second Ring Color', 'pharmacy-shop'),
	    'description' => __('It will change the complete theme preloader ring 2 color in one click.', 'pharmacy-shop'),
	    'section' => 'pharmacy_shop_prelaoder_option',
	    'settings' => 'pharmacy_shop_tp_preloader_color2_option',
  	)));
  	$wp_customize->add_setting( 'pharmacy_shop_tp_preloader_bg_color_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pharmacy_shop_tp_preloader_bg_color_option', array(
			'label'     => __('Preloader Background Color', 'pharmacy-shop'),
	    'description' => __('It will change the complete theme preloader bg color in one click.', 'pharmacy-shop'),
	    'section' => 'pharmacy_shop_prelaoder_option',
	    'settings' => 'pharmacy_shop_tp_preloader_bg_color_option',
  	)));

  	//TP Color Option
	$wp_customize->add_section('pharmacy_shop_color_option',array(
     'title'         => __('TP Color Option', 'pharmacy-shop'),
     'panel' => 'pharmacy_shop_panel_id',
     'priority' => 1,
    ) );
	$wp_customize->add_setting( 'pharmacy_shop_tp_color_option', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pharmacy_shop_tp_color_option', array(
			'label'     => __('Theme Color', 'pharmacy-shop'),
	    'description' => __('It will change the complete theme color in one click.', 'pharmacy-shop'),
	    'section' => 'pharmacy_shop_color_option',
	    'settings' => 'pharmacy_shop_tp_color_option',
  	)));

	//TP Blog Option
	$wp_customize->add_section('pharmacy_shop_blog_option',array(
		'title' => __('TP Blog Option', 'pharmacy-shop'),
		'priority' => 1,
		'panel' => 'pharmacy_shop_panel_id'
	) );
	$wp_customize->add_setting('blog_meta_order', array(
        'default' => array('date', 'author', 'comment','category'),
        'sanitize_callback' => 'pharmacy_shop_sanitize_sortable',
    ));
    $wp_customize->add_control(new Pharmacy_Shop_Control_Sortable($wp_customize, 'blog_meta_order', array(
    	'label' => esc_html__('Meta Order', 'pharmacy-shop'),
        'description' => __('Drag & Drop post items to re-arrange the order and also hide and show items as per the need by clicking on the eye icon.', 'pharmacy-shop') ,
        'section' => 'pharmacy_shop_blog_option',
        'choices' => array(
            'date' => __('date', 'pharmacy-shop') ,
            'author' => __('author', 'pharmacy-shop') ,
            'comment' => __('comment', 'pharmacy-shop') ,
            'category' => __('category', 'pharmacy-shop') ,
        ) ,
    )));
    $wp_customize->add_setting( 'pharmacy_shop_excerpt_count', array(
		'default'              => 35,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'pharmacy_shop_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'pharmacy_shop_excerpt_count', array(
		'label'       => esc_html__( 'Edit Excerpt Limit','pharmacy-shop' ),
		'section'     => 'pharmacy_shop_blog_option',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );
	$wp_customize->add_setting('pharmacy_shop_read_more_text',array(
		'default'=> __('Read More','pharmacy-shop'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pharmacy_shop_read_more_text',array(
		'label'	=> __('Edit Button Text','pharmacy-shop'),
		'section'=> 'pharmacy_shop_blog_option',
		'type'=> 'text'
	));
	$wp_customize->add_setting( 'pharmacy_shop_remove_read_button', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_remove_read_button', array(
		'label'       => esc_html__( 'Show / Hide Read More Button', 'pharmacy-shop' ),
		'section'     => 'pharmacy_shop_blog_option',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_remove_read_button',
	) ) );
    $wp_customize->selective_refresh->add_partial( 'pharmacy_shop_remove_read_button', array(
		'selector' => '.readmore-btn',
		'render_callback' => 'pharmacy_shop_customize_partial_pharmacy_shop_remove_read_button',
	 ));

	 $wp_customize->add_setting( 'pharmacy_shop_remove_tags', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_remove_tags', array(
		'label'       => esc_html__( 'Show / Hide Tags Option', 'pharmacy-shop' ),
		'section'     => 'pharmacy_shop_blog_option',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_remove_tags',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pharmacy_shop_remove_tags', array(
		'selector' => '.box-content a[rel="tag"]',
		'render_callback' => 'pharmacy_shop_customize_partial_pharmacy_shop_remove_tags',
	));
	$wp_customize->add_setting( 'pharmacy_shop_remove_category', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_remove_category', array(
		'label'       => esc_html__( 'Show / Hide Category Option', 'pharmacy-shop' ),
		'section'     => 'pharmacy_shop_blog_option',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_remove_category',
	) ) );
    $wp_customize->selective_refresh->add_partial( 'pharmacy_shop_remove_category', array(
		'selector' => '.box-content a[rel="category"]',
		'render_callback' => 'pharmacy_shop_customize_partial_pharmacy_shop_remove_category',
	));
    
	$wp_customize->add_setting( 'pharmacy_shop_remove_comment', array(
	 'default'           => true,
	 'transport'         => 'refresh',
	 'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
 	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_remove_comment', array(
	 'label'       => esc_html__( 'Show / Hide Comment Form', 'pharmacy-shop' ),
	 'section'     => 'pharmacy_shop_blog_option',
	 'type'        => 'toggle',
	 'settings'    => 'pharmacy_shop_remove_comment',
	) ) );
	$wp_customize->add_setting( 'pharmacy_shop_remove_related_post', array(
	 'default'           => true,
	 'transport'         => 'refresh',
	 'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
 	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_remove_related_post', array(
	 'label'       => esc_html__( 'Show / Hide Related Post', 'pharmacy-shop' ),
	 'section'     => 'pharmacy_shop_blog_option',
	 'type'        => 'toggle',
	 'settings'    => 'pharmacy_shop_remove_related_post',
	) ) );
	$wp_customize->add_setting('pharmacy_shop_related_post_heading',array(
		'default'=> __('Related Posts','pharmacy-shop'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pharmacy_shop_related_post_heading',array(
		'label'	=> __('Related Posts Title','pharmacy-shop'),
		'section'=> 'pharmacy_shop_blog_option',
		'type'=> 'text'
	));
	$wp_customize->add_setting( 'pharmacy_shop_related_post_per_page', array(
		'default'              => 3,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'pharmacy_shop_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'pharmacy_shop_related_post_per_page', array(
		'label'       => esc_html__( 'Related Post Per Page','pharmacy-shop' ),
		'section'     => 'pharmacy_shop_blog_option',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 3,
			'max'              => 9,
		),
	) );
	$wp_customize->add_setting( 'pharmacy_shop_related_post_per_columns', array(
		'default'              => 3,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'pharmacy_shop_sanitize_number_range',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'pharmacy_shop_related_post_per_columns', array(
		'label'       => esc_html__( 'Related Post Per Row','pharmacy-shop' ),
		'section'     => 'pharmacy_shop_blog_option',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 4,
		),
	) );
	$wp_customize->add_setting('pharmacy_shop_post_layout',array(
        'default' => 'image-content',
        'sanitize_callback' => 'pharmacy_shop_sanitize_choices'
	));
	$wp_customize->add_control('pharmacy_shop_post_layout',array(
        'type' => 'radio',
        'label'     => __('Post Layout', 'pharmacy-shop'),
        'description' => __( 'Control Works only for full,left and right sidebar position in archieve posts', 'pharmacy-shop' ),
        'section' => 'pharmacy_shop_blog_option',
        'choices' => array(
            'image-content' => __('Media-Content','pharmacy-shop'),
            'content-image' => __('Content-Media','pharmacy-shop'),
        ),
	) );

 	 //MENU TYPOGRAPHY
	$wp_customize->add_section( 'pharmacy_shop_menu_typography', array(
    	'title'      => __( 'Menu Typography', 'pharmacy-shop' ),
    	'priority' => 2,
		'panel' => 'pharmacy_shop_panel_id'
	) );
	$wp_customize->add_setting('pharmacy_shop_menu_font_family', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'pharmacy_shop_sanitize_choices',
	));
	$wp_customize->add_control(	'pharmacy_shop_menu_font_family', array(
		'section' => 'pharmacy_shop_menu_typography',
		'label'   => __('Menu Fonts', 'pharmacy-shop'),
		'type'    => 'select',
		'choices' => $pharmacy_shop_font_array,
	));
	$wp_customize->add_setting('pharmacy_shop_menu_font_weight',array(
        'default' => '400',
        'sanitize_callback' => 'pharmacy_shop_sanitize_choices'
	));
	$wp_customize->add_control('pharmacy_shop_menu_font_weight',array(
     'type' => 'radio',
     'label'     => __('Font Weight', 'pharmacy-shop'),
     'section' => 'pharmacy_shop_menu_typography',
     'type' => 'select',
     'choices' => array(
         '100' => __('100','pharmacy-shop'),
         '200' => __('200','pharmacy-shop'),
         '300' => __('300','pharmacy-shop'),
         '400' => __('400','pharmacy-shop'),
         '500' => __('500','pharmacy-shop'),
         '600' => __('600','pharmacy-shop'),
         '700' => __('700','pharmacy-shop'),
         '800' => __('800','pharmacy-shop'),
         '900' => __('900','pharmacy-shop')
     ),
	) );

	$wp_customize->add_setting('pharmacy_shop_menu_text_tranform',array(
		'default' => 'Capitalize',
		'sanitize_callback' => 'pharmacy_shop_sanitize_choices'
 	));
 	$wp_customize->add_control('pharmacy_shop_menu_text_tranform',array(
		'type' => 'select',
		'label' => __('Menu Text Transform','pharmacy-shop'),
		'section' => 'pharmacy_shop_menu_typography',
		'choices' => array(
		   'Uppercase' => __('Uppercase','pharmacy-shop'),
		   'Lowercase' => __('Lowercase','pharmacy-shop'),
		   'Capitalize' => __('Capitalize','pharmacy-shop'),
		),
	) );
	$wp_customize->add_setting('pharmacy_shop_menu_font_size', array(
	  'default' => 15,
      'sanitize_callback' => 'pharmacy_shop_sanitize_number_range',
	));
	$wp_customize->add_control(new Pharmacy_Shop_Range_Slider($wp_customize, 'pharmacy_shop_menu_font_size', array(
       'section' => 'pharmacy_shop_menu_typography',
      'label' => esc_html__('Font Size', 'pharmacy-shop'),
      'input_attrs' => array(
        'min' => 0,
        'max' => 20,
        'step' => 1
    )
	)));

	// Top Bar
	$wp_customize->add_section( 'pharmacy_shop_topbar', array(
    	'title'      => __( 'Header Details', 'pharmacy-shop' ),
    	'priority' => 2,
    	'description' => __( 'Add your contact details', 'pharmacy-shop' ),
		'panel' => 'pharmacy_shop_panel_id'
	) );
	$wp_customize->add_setting('pharmacy_shop_topbar_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pharmacy_shop_topbar_text',array(
		'label'	=> __('Topbar Text','pharmacy-shop'),
		'section'=> 'pharmacy_shop_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pharmacy_shop_phone',array(
		'default'=> '',
		'sanitize_callback'	=> 'pharmacy_shop_sanitize_phone_number'
	));
	$wp_customize->add_control('pharmacy_shop_phone',array(
		'label'	=> __('Add Phone No','pharmacy-shop'),
		'section'=> 'pharmacy_shop_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pharmacy_shop_mail',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_email'
	));
	$wp_customize->add_control('pharmacy_shop_mail',array(
		'label'	=> __('Add Mail Address','pharmacy-shop'),
		'section'=> 'pharmacy_shop_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'pharmacy_shop_search_icon', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_search_icon', array(
		'label'       => esc_html__( 'Show / Hide Search Option', 'pharmacy-shop' ),
		'section'     => 'pharmacy_shop_topbar',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_search_icon',
	) ) );
	$wp_customize->add_setting( '`', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_user_icon', array(
		'label'       => esc_html__( 'Show / Hide User Option', 'pharmacy-shop' ),
		'section'     => 'pharmacy_shop_topbar',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_user_icon',
	) ) );

	$wp_customize->add_setting( 'pharmacy_shop_cart_icon', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_cart_icon', array(
		'label'       => esc_html__( 'Show / Hide Cart Option', 'pharmacy-shop' ),
		'section'     => 'pharmacy_shop_topbar',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_cart_icon',
	) ) );

	$wp_customize->add_setting('pharmacy_shop_note_link',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('pharmacy_shop_note_link',array(
		'label'	=> __('My Notes URLs','pharmacy-shop'),
		'section'	=> 'pharmacy_shop_topbar',
		'type'		=> 'url'
	));

	//home page category
	$wp_customize->add_section( 'pharmacy_shop_home_category_section' , array(
    	'title'      => __( 'Category Section', 'pharmacy-shop' ),
    	'description' => __('Activate Woocommerce Plugin >> Create Product Categories','pharmacy-shop'),
    	'priority' => 5,
		'panel' => 'pharmacy_shop_panel_id'
	) );

	$wp_customize->add_setting('pharmacy_shop_category_text',array(
		'default' => 'Select Category',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'pharmacy_shop_category_text', array(
	   'settings' => 'pharmacy_shop_category_text',
	   'section'   => 'pharmacy_shop_home_category_section',
	   'label' => __('Add Category Text', 'pharmacy-shop'),
	   'type'      => 'text'
	));

	$wp_customize->add_setting('pharmacy_shop_product_category_number',array(
		'default' => '',
		'sanitize_callback' => 'pharmacy_shop_sanitize_number_absint',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'pharmacy_shop_product_category_number', array(
	   'settings' => 'pharmacy_shop_product_category_number',
	   'section'   => 'pharmacy_shop_home_category_section',
	   'label' => __('Add Category Limit', 'pharmacy-shop'),
	   'type'      => 'number'
	));

	//home page slider
	$wp_customize->add_section( 'pharmacy_shop_slider_section' , array(
    	'title'      => __( 'Slider Section', 'pharmacy-shop' ),
    	'priority' => 5,
		'panel' => 'pharmacy_shop_panel_id'
	) );

	$wp_customize->add_setting( 'pharmacy_shop_slider_arrows', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_slider_arrows', array(
		'label'       => esc_html__( 'Show / Hide slider', 'pharmacy-shop' ),
		'section'     => 'pharmacy_shop_slider_section',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_slider_arrows',
	) ) );

	$wp_customize->add_setting('pharmacy_shop_slider_short_heading',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pharmacy_shop_slider_short_heading',array(
		'label'	=> __('Add short Heading','pharmacy-shop'),
		'section'=> 'pharmacy_shop_slider_section',
		'type'=> 'text'
	));

	for ( $count = 1; $count <= 4; $count++ ) {

		$wp_customize->add_setting( 'pharmacy_shop_slider_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'pharmacy_shop_sanitize_dropdown_pages'
		) );

		$wp_customize->add_control( 'pharmacy_shop_slider_page' . $count, array(
			'label'    => __( 'Select Slide Image Page', 'pharmacy-shop' ),
			'description' => __('Image Size ( 1835 x 700 ) px','pharmacy-shop'),
			'section'  => 'pharmacy_shop_slider_section',
			'type'     => 'dropdown-pages'
		) );
	}
	$wp_customize->add_setting( 'pharmacy_shop_slider_button', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_slider_button', array(
		'label'       => esc_html__( 'Show / Hide Slider Button', 'pharmacy-shop' ),
		'section'     => 'pharmacy_shop_slider_section',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_slider_button',
	) ) );

	$pharmacy_shop_args = array('numberposts' => -1);
	$post_list = get_posts($pharmacy_shop_args);
	$i = 0;
	$pst[]='Select';
	foreach($post_list as $post){
		$pst[$post->post_title] = $post->post_title;
	}

	$wp_customize->add_setting('pharmacy_shop_static_blog_2',array(
		'sanitize_callback' => 'pharmacy_shop_sanitize_choices',
	));
	$wp_customize->add_control('pharmacy_shop_static_blog_2',array(
		'type'    => 'select',
		'choices' => $pst,
		'label' => __('Select post','pharmacy-shop'),
		'section' => 'pharmacy_shop_slider_section',
	));

	$wp_customize->add_setting('pharmacy_shop_slider_content_layout',array(
        'default' => 'LEFT-ALIGN',
        'sanitize_callback' => 'pharmacy_shop_sanitize_choices'
	));
	$wp_customize->add_control('pharmacy_shop_slider_content_layout',array(
        'type' => 'radio',
        'label'     => __('Slider Content Layout', 'pharmacy-shop'),
        'section' => 'pharmacy_shop_slider_section',
        'choices' => array(
        	'LEFT-ALIGN' => __('LEFT-ALIGN','pharmacy-shop'),
            'CENTER-ALIGN' => __('CENTER-ALIGN','pharmacy-shop'),
            'RIGHT-ALIGN' => __('RIGHT-ALIGN','pharmacy-shop'),
        ),
	) );

	// Product Section
	$wp_customize->add_section( 'pharmacy_shop_product_section' , array(
    	'title'      => __( 'Product Section', 'pharmacy-shop' ),
    	'priority' => 6,
		'panel' => 'pharmacy_shop_panel_id'
	) );
	$wp_customize->add_setting( 'pharmacy_shop_show_hide_product_section', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_show_hide_product_section', array(
		'label'       => esc_html__( 'Show / Hide Product Section', 'pharmacy-shop' ),
		'section'     => 'pharmacy_shop_product_section',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_show_hide_product_section',
	) ) );

	$wp_customize->add_setting('pharmacy_shop_product_short_heading',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pharmacy_shop_product_short_heading',array(
		'label'	=> __('Add short Heading','pharmacy-shop'),
		'section'=> 'pharmacy_shop_product_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('pharmacy_shop_product_heading',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pharmacy_shop_product_heading',array(
		'label'	=> __('Add Heading','pharmacy-shop'),
		'section'=> 'pharmacy_shop_product_section',
		'type'=> 'text'
	));

	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_show_hide_about_section', array(
		'label'       => esc_html__( 'Show / Hide Product Section', 'pharmacy-shop' ),
		'section'     => 'pharmacy_shop_product_section',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_show_hide_about_section',
	) ) );
	$wp_customize->add_setting( 'pharmacy_shop_about_page', array(
		'default'           => '',
		'sanitize_callback' => 'pharmacy_shop_sanitize_dropdown_pages'
	) );
	$wp_customize->add_control( 'pharmacy_shop_about_page', array(
		'label'    => __( 'Select Product Page', 'pharmacy-shop' ),
		'section'  => 'pharmacy_shop_product_section',
		'type'     => 'dropdown-pages'
	) );

	$pharmacy_shop_args = array(
	 'type'                     => 'product',
	 'child_of'                 => 0,
	 'parent'                   => '',
	 'orderby'                  => 'term_group',
	 'order'                    => 'ASC',
	 'hide_empty'               => false,
	 'hierarchical'             => 1,
	 'number'                   => '',
	 'taxonomy'                 => 'product_cat',
	 'pad_counts'               => false
	);
	$categories = get_categories( $pharmacy_shop_args );
	$pharmacy_shop_cats = array();
	$i = 0;
	foreach($categories as $category){
		if($i==0){
				$default = $category->slug;
				$i++;
		}
		$pharmacy_shop_cats[$category->slug] = $category->name;
	}
	$wp_customize->add_setting('pharmacy_shop_recent_product_category',array(
		'sanitize_callback' => 'pharmacy_shop_sanitize_select',
	));
	$wp_customize->add_control('pharmacy_shop_recent_product_category',array(
		'type'    => 'select',
		'choices' => $pharmacy_shop_cats,
		'label' => __('Select Product Category','pharmacy-shop'),
		'section' => 'pharmacy_shop_product_section',
	));

  $wp_customize->add_setting('pharmacy_shop_blockbustor_deals_countdown_timer_date',array(
    'default' => '',
    'sanitize_callback' => 'sanitize_text_field'
  ));
  $wp_customize->add_control('pharmacy_shop_blockbustor_deals_countdown_timer_date',array(
    'label' => __('Add countdown date','pharmacy-shop'),
    'description' => __('Date format MM/DD/YYYY ex. 01/01/2025 05:06:59','pharmacy-shop'), 
    'section' => 'pharmacy_shop_product_section',
    'setting' => 'pharmacy_shop_blockbustor_deals_countdown_timer_date',
    'type'    => 'text'
  ));

	//footer
	$wp_customize->add_section('pharmacy_shop_footer_section',array(
		'title'	=> __('Footer Text','pharmacy-shop'),
		'description'	=> __('Add copyright text.','pharmacy-shop'),
		'panel' => 'pharmacy_shop_panel_id',
		'priority' => 7,
	));
	$wp_customize->add_setting('pharmacy_shop_footer_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pharmacy_shop_footer_text',array(
		'label'	=> __('Copyright Text','pharmacy-shop'),
		'section'	=> 'pharmacy_shop_footer_section',
		'type'		=> 'text'
	));
	// footer columns
	$wp_customize->add_setting('pharmacy_shop_footer_columns',array(
		'default'	=> 4,
		'sanitize_callback'	=> 'pharmacy_shop_sanitize_number_absint'
	));
	$wp_customize->add_control('pharmacy_shop_footer_columns',array(
		'label'	=> __('Footer Widget Columns','pharmacy-shop'),
		'section'	=> 'pharmacy_shop_footer_section',
		'setting'	=> 'pharmacy_shop_footer_columns',
		'type'	=> 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 4,
		),
	));
	$wp_customize->add_setting( 'pharmacy_shop_tp_footer_bg_color_option', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pharmacy_shop_tp_footer_bg_color_option', array(
			'label'     => __('Footer Widget Background Color', 'pharmacy-shop'),
			'description' => __('It will change the complete footer widget backgorund color.', 'pharmacy-shop'),
			'section' => 'pharmacy_shop_footer_section',
			'settings' => 'pharmacy_shop_tp_footer_bg_color_option',
	)));
	$wp_customize->add_setting('pharmacy_shop_footer_widget_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'pharmacy_shop_footer_widget_image',array(
        'label' => __('Footer Widget Background Image','pharmacy-shop'),
         'section' => 'pharmacy_shop_footer_section'
	)));
	$wp_customize->add_setting( 'pharmacy_shop_return_to_header', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_return_to_header', array(
		'label'       => esc_html__( 'Show / Hide Return to header', 'pharmacy-shop' ),
		'section'     => 'pharmacy_shop_footer_section',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_return_to_header',
	) ) );
    $wp_customize->add_setting('pharmacy_shop_scroll_top_icon',array(
	  'default'	=> 'fas fa-arrow-up',
	  'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Pharmacy_Shop_Icon_Changer(
	        $wp_customize,'pharmacy_shop_scroll_top_icon',array(
		'label'	=> __('Scroll to top Icon','pharmacy-shop'),
		'transport' => 'refresh',
		'section'	=> 'pharmacy_shop_footer_section',
			'type'		=> 'icon'
	)));

    // Add Settings and Controls for Scroll top
	$wp_customize->add_setting('pharmacy_shop_scroll_top_position',array(
        'default' => 'Right',
        'sanitize_callback' => 'pharmacy_shop_sanitize_choices'
	));
	$wp_customize->add_control('pharmacy_shop_scroll_top_position',array(
        'type' => 'radio',
        'label'     => __('Scroll to top Position', 'pharmacy-shop'),
        'description'   => __('This option work for scroll to top', 'pharmacy-shop'),
       'section' => 'pharmacy_shop_footer_section',
       'choices' => array(
            'Right' => __('Right','pharmacy-shop'),
            'Left' => __('Left','pharmacy-shop'),
            'Center' => __('Center','pharmacy-shop')
     ),
	) );
	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'pharmacy_shop_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'pharmacy_shop_customize_partial_blogdescription',
	) );

	//Mobile Respnsive
	$wp_customize->add_section('pharmacy_shop_mobile_media_option',array(
		'title'         => __('Mobile Responsive media', 'pharmacy-shop'),
		'description' => __('Control will not function if the toggle in the main settings is off.', 'pharmacy-shop'),
		'priority' => 8,
		'panel' => 'pharmacy_shop_panel_id'
	) );
	$wp_customize->add_setting( 'pharmacy_shop_return_to_header_mob', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_return_to_header_mob', array(
		'label'       => esc_html__( 'Show / Hide Return to header', 'pharmacy-shop' ),
		'section'     => 'pharmacy_shop_mobile_media_option',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_return_to_header_mob',
	) ) );
	$wp_customize->add_setting( 'pharmacy_shop_slider_buttom_mob', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_slider_buttom_mob', array(
		'label'       => esc_html__( 'Show / Hide Slider Button', 'pharmacy-shop' ),
		'section'     => 'pharmacy_shop_mobile_media_option',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_slider_buttom_mob',
	) ) );
	$wp_customize->add_setting( 'pharmacy_shop_related_post_mob', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_related_post_mob', array(
		'label'       => esc_html__( 'Show / Hide Related Post', 'pharmacy-shop' ),
		'section'     => 'pharmacy_shop_mobile_media_option',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_related_post_mob',
	) ) );

	//Site Identity
	$wp_customize->add_setting( 'pharmacy_shop_site_title', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_site_title', array(
		'label'       => esc_html__( 'Show / Hide Site Title', 'pharmacy-shop' ),
		'section'     => 'title_tagline',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_site_title',
	) ) );
	$wp_customize->add_setting('pharmacy_shop_site_title_font_size',array(
		'default'	=> 25,
		'sanitize_callback'	=> 'pharmacy_shop_sanitize_number_absint'
	));
	$wp_customize->add_control('pharmacy_shop_site_title_font_size',array(
		'label'	=> __('Site Title Font Size in PX','pharmacy-shop'),
		'section'	=> 'title_tagline',
		'setting'	=> 'pharmacy_shop_site_title_font_size',
		'type'	=> 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 80,
		),
	));
	$wp_customize->add_setting( 'pharmacy_shop_site_tagline', array(
	    'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_site_tagline', array(
		'label'       => esc_html__( 'Show / Hide Site Tagline', 'pharmacy-shop' ),
		'section'     => 'title_tagline',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_site_tagline',
	) ) );

	// logo site tagline size
	$wp_customize->add_setting('pharmacy_shop_site_tagline_font_size',array(
		'default'	=> 15,
		'sanitize_callback'	=> 'pharmacy_shop_sanitize_number_absint'
	));
	$wp_customize->add_control('pharmacy_shop_site_tagline_font_size',array(
		'label'	=> __('Site Tagline Font Size in PX','pharmacy-shop'),
		'section'	=> 'title_tagline',
	    'setting'	=> 'pharmacy_shop_site_tagline_font_size',
		'type'	=> 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	));

	$wp_customize->add_setting('pharmacy_shop_logo_settings',array(
		'default' => 'Different Line',
		'sanitize_callback' => 'pharmacy_shop_sanitize_choices'
	));
    $wp_customize->add_control('pharmacy_shop_logo_settings',array(
        'type' => 'radio',
        'label'     => __('Logo Layout Settings', 'pharmacy-shop'),
        'description'   => __('Here you have two options 1. Logo and Site tite in differnt line. 2. Logo and Site title in same line.', 'pharmacy-shop'),
        'section' => 'title_tagline',
        'choices' => array(
            'Different Line' => __('Different Line','pharmacy-shop'),
            'Same Line' => __('Same Line','pharmacy-shop')
        ),
	) );

	//Woo Coomerce
	$wp_customize->add_setting('pharmacy_shop_per_columns',array(
		'default'=> 3,
		'sanitize_callback'	=> 'pharmacy_shop_sanitize_number_absint'
	));
	$wp_customize->add_control('pharmacy_shop_per_columns',array(
		'label'	=> __('Product Per Row','pharmacy-shop'),
		'section'=> 'woocommerce_product_catalog',
		'type'=> 'number'
	));
	$wp_customize->add_setting('pharmacy_shop_product_per_page',array(
		'default'=> 9,
		'sanitize_callback'	=> 'pharmacy_shop_sanitize_number_absint'
	));
	$wp_customize->add_control('pharmacy_shop_product_per_page',array(
		'label'	=> __('Product Per Page','pharmacy-shop'),
		'section'=> 'woocommerce_product_catalog',
		'type'=> 'number'
	));
   	$wp_customize->add_setting( 'pharmacy_shop_product_sidebar', array(
		 'default'           => true,
		 'transport'         => 'refresh',
		 'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_product_sidebar', array(
		'label'       => esc_html__( 'Show / Hide Shop Page Sidebar', 'pharmacy-shop' ),
		'section'     => 'woocommerce_product_catalog',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_product_sidebar',
	) ) );
	$wp_customize->add_setting('pharmacy_shop_sale_tag_position',array(
        'default' => 'right',
        'sanitize_callback' => 'pharmacy_shop_sanitize_choices'
	));
	$wp_customize->add_control('pharmacy_shop_sale_tag_position',array(
        'type' => 'radio',
        'label'     => __('Sale Badge Position', 'pharmacy-shop'),
        'description'   => __('This option work for Archieve Products', 'pharmacy-shop'),
        'section' => 'woocommerce_product_catalog',
        'choices' => array(
            'left' => __('Left','pharmacy-shop'),
            'right' => __('Right','pharmacy-shop'),
        ),
	) );
	$wp_customize->add_setting( 'pharmacy_shop_single_product_sidebar', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_single_product_sidebar', array(
		'label'       => esc_html__( 'Show / Hide Product Page Sidebar', 'pharmacy-shop' ),
		'section'     => 'woocommerce_product_catalog',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_single_product_sidebar',
	) ) );
	$wp_customize->add_setting( 'pharmacy_shop_related_product', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'pharmacy_shop_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Pharmacy_Shop_Toggle_Control( $wp_customize, 'pharmacy_shop_related_product', array(
		'label'       => esc_html__( 'Show / Hide related product', 'pharmacy-shop' ),
		'section'     => 'woocommerce_product_catalog',
		'type'        => 'toggle',
		'settings'    => 'pharmacy_shop_related_product',
	) ) );

		// 404 PAGE
	$wp_customize->add_section('pharmacy_shop_404_page_section',array(
		'title'         => __('404 Page', 'pharmacy-shop'),
		'description'   => 'Here you can customize 404 Page content.',
	) );
	$wp_customize->add_setting('pharmacy_shop_not_found_title',array(
		'default'=> __('Oops! That page cant be found.','pharmacy-shop'),
		'sanitize_callback'	=> 'sanitize_text_field',
	));
	$wp_customize->add_control('pharmacy_shop_not_found_title',array(
		'label'	=> __('Edit Title','pharmacy-shop'),
		'section'=> 'pharmacy_shop_404_page_section',
		'type'=> 'text',
	));
	$wp_customize->add_setting('pharmacy_shop_not_found_text',array(
		'default'=> __('It looks like nothing was found at this location. Maybe try a search?','pharmacy-shop'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('pharmacy_shop_not_found_text',array(
		'label'	=> __('Edit Text','pharmacy-shop'),
		'section'=> 'pharmacy_shop_404_page_section',
		'type'=> 'text'
	));

}
add_action( 'customize_register', 'pharmacy_shop_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Pharmacy Shop 1.0
 * @see pharmacy_shop_customize_register()
 *
 * @return void
 */
function pharmacy_shop_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Pharmacy Shop 1.0
 * @see pharmacy_shop_customize_register()
 *
 * @return void
 */
function pharmacy_shop_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

if ( ! defined( 'PHARMACY_SHOP_PRO_THEME_NAME' ) ) {
	define( 'PHARMACY_SHOP_PRO_THEME_NAME', esc_html__( 'Pharmacy Shop Pro', 'pharmacy-shop' ));
}
if ( ! defined( 'PHARMACY_SHOP_PRO_THEME_URL' ) ) {
	define( 'PHARMACY_SHOP_PRO_THEME_URL', esc_url('https://www.themespride.com/themes/pharmacy-wordpress-theme/'));
}
if ( ! defined( 'PHARMACY_SHOP_DOCS_URL' ) ) {
	define( 'PHARMACY_SHOP_DOCS_URL', esc_url('https://www.themespride.com/demo/docs/pharmacy-shop/'));
}

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Pharmacy_Shop_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Pharmacy_Shop_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Pharmacy_Shop_Customize_Section_Pro(
				$manager,
				'pharmacy_shop_section_pro',
				array(
					'priority'   => 9,
					'title'    => PHARMACY_SHOP_PRO_THEME_NAME,
					'pro_text' => esc_html__( 'Upgrade Pro', 'pharmacy-shop' ),
					'pro_url'  => esc_url( PHARMACY_SHOP_PRO_THEME_URL, 'pharmacy-shop' ),
				)
			)
		);
		// Register sections.
		$manager->add_section(
			new Pharmacy_Shop_Customize_Section_Pro(
				$manager,
				'pharmacy_shop_documentation',
				array(
					'priority'   => 500,
					'title'    => esc_html__( 'Theme Documentation', 'pharmacy-shop' ),
					'pro_text' => esc_html__( 'Click Here', 'pharmacy-shop' ),
					'pro_url'  => esc_url( PHARMACY_SHOP_DOCS_URL, 'pharmacy-shop'),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'pharmacy-shop-customize-controls', trailingslashit( esc_url( get_template_directory_uri() ) ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'pharmacy-shop-customize-controls', trailingslashit( esc_url( get_template_directory_uri() ) ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Pharmacy_Shop_Customize::get_instance();
