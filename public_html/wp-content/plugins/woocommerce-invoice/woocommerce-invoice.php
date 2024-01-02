<?php
/**
 * Plugin Name: فاکتور ووکامرس
 * Plugin URI: https://woocommerce.ir
 * Description: صدور و چاپ فاکتور برای سفارشات ثبت شده در ووکامرس ، امکان صدور فاکتور ویژه پرینترهای نوری و پرینترهای لیزری. کدنویسی و توسعه توسط <a href="https://woocommerce.ir" target="_blank">ووکامرس فارسی</a>
 * Version: 6.0.2
 * Author: ووکامرس فارسی
 * Author URI: https://woocommerce.ir
 * WC requires at least: 7.0.0
 * WC tested up to: 8.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'WOOI_VERSION' ) ) {
	define( 'WOOI_VERSION', '6.0.2' );
}

if ( ! defined( 'WOOI_PLUGIN_DIR' ) ) {
	define( 'WOOI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'WOOI_PLUGIN_URL' ) ) {
	define( 'WOOI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'WOOI_PLUGIN_FILE' ) ) {
	define( 'WOOI_PLUGIN_FILE', __FILE__ );
}

if ( ! function_exists( 'sg_load' ) ) {

	add_action( 'admin_notices', function () {
		?>
		<div class="notice notice-error">
			<p><b>هشدار: </b>
				فعالسازی «فاکتور ووکامرس» انجام نشد. لودر سورس گاردین روی هاست شما فعال نیست، لطفا
				به هاستینگ خود تیکت بزنید و درخواست کنید لودر سورس گاردین را برای شما نصب و فعالسازی
				نمایند.
			</p>
		</div>
		<?php
	} );

	return;
}

register_activation_hook( WOOI_PLUGIN_FILE, function () {
	file_put_contents( WOOI_PLUGIN_DIR . '/.activated', '' );
} );

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}

if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	return false;
}

include 'vendor/autoload.php';

function WOOI(): Woocommerce_Invoice {
	return Woocommerce_Invoice::instance();
}

WOOI();

add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );
