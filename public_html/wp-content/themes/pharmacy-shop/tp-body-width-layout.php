<?php

	$pharmacy_shop_tp_theme_css = "";

$pharmacy_shop_theme_lay = get_theme_mod( 'pharmacy_shop_tp_body_layout_settings','Full');
if($pharmacy_shop_theme_lay == 'Container'){
$pharmacy_shop_tp_theme_css .='body{';
	$pharmacy_shop_tp_theme_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
$pharmacy_shop_tp_theme_css .='}';
$pharmacy_shop_tp_theme_css .='@media screen and (max-width:575px){';
		$pharmacy_shop_tp_theme_css .='body{';
			$pharmacy_shop_tp_theme_css .='max-width: 100%; padding-right:0px; padding-left: 0px';
		$pharmacy_shop_tp_theme_css .='} }';
$pharmacy_shop_tp_theme_css .='.page-template-front-page .menubar{';
	$pharmacy_shop_tp_theme_css .='position: static;';
$pharmacy_shop_tp_theme_css .='}';
$pharmacy_shop_tp_theme_css .='.scrolled{';
	$pharmacy_shop_tp_theme_css .='width: auto; left:0; right:0;';
$pharmacy_shop_tp_theme_css .='}';
}else if($pharmacy_shop_theme_lay == 'Container Fluid'){
$pharmacy_shop_tp_theme_css .='body{';
	$pharmacy_shop_tp_theme_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
$pharmacy_shop_tp_theme_css .='}';
$pharmacy_shop_tp_theme_css .='@media screen and (max-width:575px){';
		$pharmacy_shop_tp_theme_css .='body{';
			$pharmacy_shop_tp_theme_css .='max-width: 100%; padding-right:0px; padding-left:0px';
		$pharmacy_shop_tp_theme_css .='} }';
$pharmacy_shop_tp_theme_css .='.page-template-front-page .menubar{';
	$pharmacy_shop_tp_theme_css .='width: 99%';
$pharmacy_shop_tp_theme_css .='}';		
$pharmacy_shop_tp_theme_css .='.scrolled{';
	$pharmacy_shop_tp_theme_css .='width: auto; left:0; right:0;';
$pharmacy_shop_tp_theme_css .='}';
}else if($pharmacy_shop_theme_lay == 'Full'){
$pharmacy_shop_tp_theme_css .='body{';
	$pharmacy_shop_tp_theme_css .='max-width: 100%;';
$pharmacy_shop_tp_theme_css .='}';
}

$pharmacy_shop_scroll_position = get_theme_mod( 'pharmacy_shop_scroll_top_position','Right');
if($pharmacy_shop_scroll_position == 'Right'){
$pharmacy_shop_tp_theme_css .='#return-to-top{';
    $pharmacy_shop_tp_theme_css .='right: 20px;';
$pharmacy_shop_tp_theme_css .='}';
}else if($pharmacy_shop_scroll_position == 'Left'){
$pharmacy_shop_tp_theme_css .='#return-to-top{';
    $pharmacy_shop_tp_theme_css .='left: 20px;';
$pharmacy_shop_tp_theme_css .='}';
}else if($pharmacy_shop_scroll_position == 'Center'){
$pharmacy_shop_tp_theme_css .='#return-to-top{';
    $pharmacy_shop_tp_theme_css .='right: 50%;left: 50%;';
$pharmacy_shop_tp_theme_css .='}';
}

    
//Social icon Font size
$pharmacy_shop_social_icon_fontsize = get_theme_mod('pharmacy_shop_social_icon_fontsize');
	$pharmacy_shop_tp_theme_css .='.media-links a i{';
$pharmacy_shop_tp_theme_css .='font-size: '.esc_attr($pharmacy_shop_social_icon_fontsize).'px;';
$pharmacy_shop_tp_theme_css .='}';

// site title font size option
$pharmacy_shop_site_title_font_size = get_theme_mod('pharmacy_shop_site_title_font_size', 25);{
$pharmacy_shop_tp_theme_css .='.logo h1 a, .logo p a{';
	$pharmacy_shop_tp_theme_css .='font-size: '.esc_attr($pharmacy_shop_site_title_font_size).'px;';
$pharmacy_shop_tp_theme_css .='}';
}

//site tagline font size option
$pharmacy_shop_site_tagline_font_size = get_theme_mod('pharmacy_shop_site_tagline_font_size', 15);{
$pharmacy_shop_tp_theme_css .='.logo p{';
	$pharmacy_shop_tp_theme_css .='font-size: '.esc_attr($pharmacy_shop_site_tagline_font_size).'px;';
$pharmacy_shop_tp_theme_css .='}';
}

// related product
$pharmacy_shop_related_product = get_theme_mod('pharmacy_shop_related_product',true);
if($pharmacy_shop_related_product == false){
$pharmacy_shop_tp_theme_css .='.related.products{';
    $pharmacy_shop_tp_theme_css .='display: none;';
$pharmacy_shop_tp_theme_css .='}';
}

// related post
$pharmacy_shop_related_post_mob = get_theme_mod('pharmacy_shop_related_post_mob', true);
$pharmacy_shop_related_post = get_theme_mod('pharmacy_shop_remove_related_post', true);
$pharmacy_shop_tp_theme_css .= '.related-post-block {';
if ($pharmacy_shop_related_post == false) {
    $pharmacy_shop_tp_theme_css .= 'display: none;';
}
$pharmacy_shop_tp_theme_css .= '}';
$pharmacy_shop_tp_theme_css .= '@media screen and (max-width: 575px) {';
if ($pharmacy_shop_related_post == false || $pharmacy_shop_related_post_mob == false) {
    $pharmacy_shop_tp_theme_css .= '.related-post-block { display: none; }';
}
$pharmacy_shop_tp_theme_css .= '}';

// slider btn
$pharmacy_shop_slider_buttom_mob = get_theme_mod('pharmacy_shop_slider_buttom_mob', true);
$pharmacy_shop_slider_button = get_theme_mod('pharmacy_shop_slider_button', true);
$pharmacy_shop_tp_theme_css .= '#slider .more-btn {';
if ($pharmacy_shop_slider_button == false) {
    $pharmacy_shop_tp_theme_css .= 'display: none;';
}
$pharmacy_shop_tp_theme_css .= '}';
$pharmacy_shop_tp_theme_css .= '@media screen and (max-width: 575px) {';
if ($pharmacy_shop_slider_button == false || $pharmacy_shop_slider_buttom_mob == false) {
    $pharmacy_shop_tp_theme_css .= '#slider .more-btn { display: none; }';
}
$pharmacy_shop_tp_theme_css .= '}';

//return to header mobile               
$pharmacy_shop_return_to_header_mob = get_theme_mod('pharmacy_shop_return_to_header_mob', true);
$pharmacy_shop_return_to_header = get_theme_mod('pharmacy_shop_return_to_header', true);
$pharmacy_shop_tp_theme_css .= '.return-to-header{';
if ($pharmacy_shop_return_to_header == false) {
    $pharmacy_shop_tp_theme_css .= 'display: none;';
}
$pharmacy_shop_tp_theme_css .= '}';
$pharmacy_shop_tp_theme_css .= '@media screen and (max-width: 575px) {';
if ($pharmacy_shop_return_to_header == false || $pharmacy_shop_return_to_header_mob == false) {
    $pharmacy_shop_tp_theme_css .= '.return-to-header{ display: none; }';
}
$pharmacy_shop_tp_theme_css .= '}';


//footer image
$pharmacy_shop_footer_widget_image = get_theme_mod('pharmacy_shop_footer_widget_image');
if($pharmacy_shop_footer_widget_image != false){
$pharmacy_shop_tp_theme_css .='#footer{';
	$pharmacy_shop_tp_theme_css .='background: url('.esc_attr($pharmacy_shop_footer_widget_image).');';
$pharmacy_shop_tp_theme_css .='}';
}
//menu font size
$pharmacy_shop_menu_font_size = get_theme_mod('pharmacy_shop_menu_font_size', 15);{
$pharmacy_shop_tp_theme_css .='.main-navigation a, .main-navigation li.page_item_has_children:after,.main-navigation li.menu-item-has-children:after{';
	$pharmacy_shop_tp_theme_css .='font-size: '.esc_attr($pharmacy_shop_menu_font_size).'px;';
$pharmacy_shop_tp_theme_css .='}';
}

// menu text tranform
$pharmacy_shop_menu_text_tranform = get_theme_mod( 'pharmacy_shop_menu_text_tranform','Capitalize');
if($pharmacy_shop_menu_text_tranform == 'Uppercase'){
$pharmacy_shop_tp_theme_css .='.main-navigation a {';
	$pharmacy_shop_tp_theme_css .='text-transform: uppercase;';
$pharmacy_shop_tp_theme_css .='}';
}else if($pharmacy_shop_menu_text_tranform == 'Lowercase'){
$pharmacy_shop_tp_theme_css .='.main-navigation a {';
	$pharmacy_shop_tp_theme_css .='text-transform: lowercase;';
$pharmacy_shop_tp_theme_css .='}';
}
else if($pharmacy_shop_menu_text_tranform == 'Capitalize'){
$pharmacy_shop_tp_theme_css .='.main-navigation a {';
	$pharmacy_shop_tp_theme_css .='text-transform: capitalize;';
$pharmacy_shop_tp_theme_css .='}';
}

//======================= slider Content layout ===================== //

$pharmacy_shop_slider_content_layout = get_theme_mod('pharmacy_shop_slider_content_layout', 'LEFT-ALIGN'); 
$pharmacy_shop_tp_theme_css .= '#slider .carousel-caption{';
switch ($pharmacy_shop_slider_content_layout) {
    case 'LEFT-ALIGN':
        $pharmacy_shop_tp_theme_css .= 'text-align:left; right: 30%; left: 15%';
        break;
    case 'CENTER-ALIGN':
        $pharmacy_shop_tp_theme_css .= 'text-align:center; left: 15%; right: 15%';
        break;
    case 'RIGHT-ALIGN':
        $pharmacy_shop_tp_theme_css .= 'text-align:right; left: 30%; right: 15%';
        break;
    default:
        $pharmacy_shop_tp_theme_css .= 'text-align:left; right: 30%; left: 15%';
        break;
}
$pharmacy_shop_tp_theme_css .= '}';

//sale position
$pharmacy_shop_scroll_position = get_theme_mod( 'pharmacy_shop_sale_tag_position','right');
if($pharmacy_shop_scroll_position == 'right'){
$pharmacy_shop_tp_theme_css .='.woocommerce ul.products li.product .onsale{';
    $pharmacy_shop_tp_theme_css .='right: 25px !important;';
$pharmacy_shop_tp_theme_css .='}';
}else if($pharmacy_shop_scroll_position == 'left'){
$pharmacy_shop_tp_theme_css .='.woocommerce ul.products li.product .onsale{';
    $pharmacy_shop_tp_theme_css .='left: 25px !important; right: auto !important;';
$pharmacy_shop_tp_theme_css .='}';
}

//Font Weight
$pharmacy_shop_menu_font_weight = get_theme_mod( 'pharmacy_shop_menu_font_weight','400');
if($pharmacy_shop_menu_font_weight == '100'){
$pharmacy_shop_tp_theme_css .='.main-navigation a{';
    $pharmacy_shop_tp_theme_css .='font-weight: 100;';
$pharmacy_shop_tp_theme_css .='}';
}else if($pharmacy_shop_menu_font_weight == '200'){
$pharmacy_shop_tp_theme_css .='.main-navigation a{';
    $pharmacy_shop_tp_theme_css .='font-weight: 200;';
$pharmacy_shop_tp_theme_css .='}';
}else if($pharmacy_shop_menu_font_weight == '300'){
$pharmacy_shop_tp_theme_css .='.main-navigation a{';
    $pharmacy_shop_tp_theme_css .='font-weight: 300;';
$pharmacy_shop_tp_theme_css .='}';
}else if($pharmacy_shop_menu_font_weight == '400'){
$pharmacy_shop_tp_theme_css .='.main-navigation a{';
    $pharmacy_shop_tp_theme_css .='font-weight: 400;';
$pharmacy_shop_tp_theme_css .='}';
}else if($pharmacy_shop_menu_font_weight == '500'){
$pharmacy_shop_tp_theme_css .='.main-navigation a{';
    $pharmacy_shop_tp_theme_css .='font-weight: 500;';
$pharmacy_shop_tp_theme_css .='}';
}else if($pharmacy_shop_menu_font_weight == '600'){
$pharmacy_shop_tp_theme_css .='.main-navigation a{';
    $pharmacy_shop_tp_theme_css .='font-weight: 600;';
$pharmacy_shop_tp_theme_css .='}';
}else if($pharmacy_shop_menu_font_weight == '700'){
$pharmacy_shop_tp_theme_css .='.main-navigation a{';
    $pharmacy_shop_tp_theme_css .='font-weight: 700;';
$pharmacy_shop_tp_theme_css .='}';
}else if($pharmacy_shop_menu_font_weight == '800'){
$pharmacy_shop_tp_theme_css .='.main-navigation a{';
    $pharmacy_shop_tp_theme_css .='font-weight: 800;';
$pharmacy_shop_tp_theme_css .='}';
}else if($pharmacy_shop_menu_font_weight == '900'){
$pharmacy_shop_tp_theme_css .='.main-navigation a{';
    $pharmacy_shop_tp_theme_css .='font-weight: 900;';
$pharmacy_shop_tp_theme_css .='}';
}