<?php
/**
 * Custom header implementation
 *
 * @link https://codex.wordpress.org/Custom_Headers
 *
 * @package Pharmacy Shop
 * @subpackage pharmacy_shop
 */

function pharmacy_shop_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'pharmacy_shop_custom_header_args', array(
		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1600,
		'height'                 => 400,
		'flex-width'    		 => true,
		'flex-height'    		 => true,
		'wp-head-callback'       => 'pharmacy_shop_header_style',
		'default-image'          => get_parent_theme_file_uri( '/assets/images/header_img.png' ),
	) ) );

	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/assets/images/header_img.png',
			'thumbnail_url' => '%s/assets/images/header_img.png',
			'description'   => __( 'Default Header Image', 'pharmacy-shop' ),
		),
	) );
}
add_action( 'after_setup_theme', 'pharmacy_shop_custom_header_setup' );

if ( ! function_exists( 'pharmacy_shop_header_style' ) ) :
add_action( 'wp_enqueue_scripts', 'pharmacy_shop_header_style' );
function pharmacy_shop_header_style() {
	if ( get_header_image() ) :
	$pharmacy_shop_custom_css = "
        .header-img{
			background-image:url('".esc_url(get_header_image())."') !important;
			background-position: center top !important;
			height: 200px;
			background-size: cover !important;
			display: block;
		}
		.single-page-img{
			background-image:url('".esc_url(get_header_image())."') !important;
			background-position: center top !important;
			background-size: cover !important;
		}";
	   	wp_add_inline_style( 'pharmacy-shop-style', $pharmacy_shop_custom_css );
	endif;
}
endif;