<?php
/**
 * Plugin Name: پیامک حرفه ای ووکامرس
 * Plugin URI: https://woosupport.ir
 * Description: افزونه کامل و حرفه ای برای اطلاع رسانی پیامکی سفارشات و رویداد های محصولات ووکامرس. تمامی حقوق این افزونه متعلق به <a href="http://woosupport.ir" target="_blank">تیم ووکامرس پارسی</a> می باشد و هر گونه کپی برداری، فروش آن غیر مجاز می باشد.
 * Version: 6.1.0
 * Author: ووکامرس فارسی
 * Author URI: https://woosupport.ir
 * WC requires at least: 6.0.0
 * WC tested up to: 8.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	header( 'Location: https://woosupport.ir/' );
	exit;
}

if ( ! defined( 'PWOOSMS_VERSION' ) ) {
	define( 'PWOOSMS_VERSION', '6.1.0' );
}

if ( ! defined( 'PWOOSMS_URL' ) ) {
	define( 'PWOOSMS_URL', plugins_url( '', __FILE__ ) );
}

if ( ! defined( 'PWOOSMS_INCLUDE_DIR' ) ) {
	define( 'PWOOSMS_INCLUDE_DIR', dirname( __FILE__ ) . '/includes' );
}

register_activation_hook( __FILE__, 'WoocommerceIR_SMS_Register' );
register_deactivation_hook( __FILE__, 'WoocommerceIR_SMS_Register' );

function WoocommerceIR_SMS_Register() {
	delete_option( 'pwoosms_table_archive' );
	delete_option( 'pwoosms_table_contacts' );
	delete_option( 'pwoosms_hide_about_page' );
	delete_option( 'pwoosms_redirect_about_page' );
}

require_once 'includes/class-gateways.php';
require_once 'includes/class-settings-api.php';
require_once 'includes/class-settings.php';
require_once 'includes/class-helper.php';
require_once 'includes/class-bulk.php';
require_once 'includes/class-about.php';
require_once 'includes/class-ads.php';
require_once 'includes/class-notice.php';

require_once 'includes/class-metabox.php';
require_once 'includes/class-subscription.php';
require_once 'includes/class-product-tab.php';
require_once 'includes/class-product-events.php';
require_once 'includes/class-orders.php';
require_once 'includes/class-archive.php';
require_once 'includes/class-contacts.php';
require_once 'includes/class-functions.php';

require_once 'includes/class-deprecateds.php';

add_action( 'admin_enqueue_scripts', 'load_woo_sms_admin_style' );

function load_woo_sms_admin_style() {
	wp_enqueue_style( 'persian_woo_admin_style', plugin_dir_url( __FILE__ ) . 'assets/css/admin-style.css' );
}

add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );
