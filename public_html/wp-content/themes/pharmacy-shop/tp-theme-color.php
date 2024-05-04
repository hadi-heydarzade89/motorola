<?php

$pharmacy_shop_tp_theme_css = '';

//theme-color
$pharmacy_shop_tp_color_option = get_theme_mod('pharmacy_shop_tp_color_option');

if($pharmacy_shop_tp_color_option != false){
$pharmacy_shop_tp_theme_css .='.main-navigation .menu > ul > li.highlight, .box:before,.box:after,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.page-numbers,.prev.page-numbers,.next.page-numbers,span.meta-nav,#theme-sidebar button[type="submit"],#footer button[type="submit"],#comments input[type="submit"],.site-info,.book-tkt-btn a.register-btn,.toggle-nav i, #return-to-top,.error-404 [type="submit"],.news-detail:after,.newsletter_shortcode input[type="submit"],#slider .carousel-control-prev-icon, #slider .carousel-control-next-icon,.woocommerce ul.products li.product .onsale, .woocommerce span.onsale,wc-block-checkout__actions_row .wc-block-components-checkout-place-order-button,.wc-block-cart__submit-container a, .wc-block-grid__product-add-to-cart.wp-block-button .wp-block-button__link,.category-dropdown::-webkit-scrollbar-thumb,.category-dropdown::-webkit-scrollbar,.category-dropdown::-webkit-scrollbar-track,.wc-block-checkout__actions_row .wc-block-components-checkout-place-order-button,.box-btn a,#theme-sidebar .wp-block-search .wp-block-search__label:before,#theme-sidebar h3:before, #theme-sidebar h1.wp-block-heading:before, #theme-sidebar h2.wp-block-heading:before, #theme-sidebar h3.wp-block-heading:before,#theme-sidebar h4.wp-block-heading:before, #theme-sidebar h5.wp-block-heading:before, #theme-sidebar h6.wp-block-heading:before,.logo,span.cart-value.simplep,.product-search button,.category-btn,.more-btn a,.more-btn a:hover,.countdown-box,.flash_product:hover .custom_product_meta a {';
$pharmacy_shop_tp_theme_css .='background-color: '.esc_attr($pharmacy_shop_tp_color_option).';';
$pharmacy_shop_tp_theme_css .='}';
}

if($pharmacy_shop_tp_color_option != false){
$pharmacy_shop_tp_theme_css .='a,#theme-sidebar .textwidget a,#footer .textwidget a,.comment-body a,.entry-content a,.entry-summary a,.page-template-front-page .media-links a:hover,#theme-sidebar h3,.page-box h4 a,.readmore-btn a,.box-content a ,.woocommerce-message::before ,.logo a, .logo p ,.wp-block-search .wp-block-search__label,#theme-sidebar h2.wp-block-heading,.timebox i,#theme-sidebar li a:hover, #footer li a:hover,post_tag :hover,#theme-sidebar .tagcloud a:hover,#footer .tagcloud a:hover, #theme-sidebar .widget_tag_cloud a:hover,.box-info i,a.added_to_cart.wc-forward ,.category-dropdown li a:hover ,a:hover,#footer p.wp-block-tag-cloud a:hover,#theme-sidebar .wp-block-search .wp-block-search__label,.topbar i{';
$pharmacy_shop_tp_theme_css .='color: '.esc_attr($pharmacy_shop_tp_color_option).';';
$pharmacy_shop_tp_theme_css .='}';
}
if($pharmacy_shop_tp_color_option != false){
$pharmacy_shop_tp_theme_css .='.main-navigation .current_page_item > a,.wp-block-quote:not(.is-large):not(.is-style-large),.product-search input,#theme-sidebar .tagcloud a:hover,#footer .tagcloud a:hover, #theme-sidebar .widget_tag_cloud a:hover,.readmore-btn a,#footer p.wp-block-tag-cloud a:hover,#slider .carousel-control-prev-icon, #slider .carousel-control-next-icon {';
	$pharmacy_shop_tp_theme_css .='border-color: '.esc_attr($pharmacy_shop_tp_color_option).';';
$pharmacy_shop_tp_theme_css .='}';
}
if($pharmacy_shop_tp_color_option != false){
$pharmacy_shop_tp_theme_css .='.woocommerce-message {';
$pharmacy_shop_tp_theme_css .='border-top-color: '.esc_attr($pharmacy_shop_tp_color_option).';';
$pharmacy_shop_tp_theme_css .='}';
}

if($pharmacy_shop_tp_color_option != false){
$pharmacy_shop_tp_theme_css .='.page-box,#theme-sidebar section {';
    $pharmacy_shop_tp_theme_css .='border-left-color: '.esc_attr($pharmacy_shop_tp_color_option).';';
$pharmacy_shop_tp_theme_css .='}';
}
if($pharmacy_shop_tp_color_option != false){
$pharmacy_shop_tp_theme_css .='.page-box,#theme-sidebar section {';
    $pharmacy_shop_tp_theme_css .='border-bottom-color: '.esc_attr($pharmacy_shop_tp_color_option).';';
$pharmacy_shop_tp_theme_css .='}';
}


//preloader

$pharmacy_shop_tp_preloader_color1_option = get_theme_mod('pharmacy_shop_tp_preloader_color1_option');
$pharmacy_shop_tp_preloader_color2_option = get_theme_mod('pharmacy_shop_tp_preloader_color2_option');
$pharmacy_shop_tp_preloader_bg_color_option = get_theme_mod('pharmacy_shop_tp_preloader_bg_color_option');

if($pharmacy_shop_tp_preloader_color1_option != false){
$pharmacy_shop_tp_theme_css .='.center1{';
	$pharmacy_shop_tp_theme_css .='border-color: '.esc_attr($pharmacy_shop_tp_preloader_color1_option).' !important;';
$pharmacy_shop_tp_theme_css .='}';
}
if($pharmacy_shop_tp_preloader_color1_option != false){
$pharmacy_shop_tp_theme_css .='.center1 .ring::before{';
	$pharmacy_shop_tp_theme_css .='background: '.esc_attr($pharmacy_shop_tp_preloader_color1_option).' !important;';
$pharmacy_shop_tp_theme_css .='}';
}
if($pharmacy_shop_tp_preloader_color2_option != false){
$pharmacy_shop_tp_theme_css .='.center2{';
	$pharmacy_shop_tp_theme_css .='border-color: '.esc_attr($pharmacy_shop_tp_preloader_color2_option).' !important;';
$pharmacy_shop_tp_theme_css .='}';
}
if($pharmacy_shop_tp_preloader_color2_option != false){
$pharmacy_shop_tp_theme_css .='.center2 .ring::before{';
	$pharmacy_shop_tp_theme_css .='background: '.esc_attr($pharmacy_shop_tp_preloader_color2_option).' !important;';
$pharmacy_shop_tp_theme_css .='}';
}
if($pharmacy_shop_tp_preloader_bg_color_option != false){
$pharmacy_shop_tp_theme_css .='.loader{';
	$pharmacy_shop_tp_theme_css .='background: '.esc_attr($pharmacy_shop_tp_preloader_bg_color_option).';';
$pharmacy_shop_tp_theme_css .='}';
}

// footer-bg-color
$pharmacy_shop_tp_footer_bg_color_option = get_theme_mod('pharmacy_shop_tp_footer_bg_color_option');

if($pharmacy_shop_tp_footer_bg_color_option != false){
$pharmacy_shop_tp_theme_css .='#footer{';
	$pharmacy_shop_tp_theme_css .='background: '.esc_attr($pharmacy_shop_tp_footer_bg_color_option).' !important;';
$pharmacy_shop_tp_theme_css .='}';
}

