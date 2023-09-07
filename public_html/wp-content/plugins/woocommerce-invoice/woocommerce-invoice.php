<?php
/**
 * Plugin Name: فاکتور ووکامرس
 * Plugin URI: https://woocommerce.ir
 * Description: صدور و چاپ فاکتور برای سفارشات ثبت شده در ووکامرس ، امکان صدور فاکتور ویژه پرینترهای نوری و پرینترهای لیزری. کدنویسی و توسعه توسط <a href="https://woocommerce.ir" target="_blank">ووکامرس فارسی</a>
 * Version: 5.4.1
 * Author: ووکامرس فارسی
 * Author URI: https://woocommerce.ir
 * WC requires at least: 5.0.0
 * WC tested up to: 7.2.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'WOOI_VERSION' ) ) {
	define( 'WOOI_VERSION', '5.4.0' );
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

if ( ! defined( 'WOOI_PHP_VERSION' ) ) {
	define( 'WOOI_PHP_VERSION', '7.2.5' );
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

if ( version_compare( WOOI_PHP_VERSION, PHP_VERSION, '>' ) ) {

	add_action( 'admin_notices', function () {
		?>
		<div class="notice notice-error">
			<p><b>هشدار: </b>
				فعالسازی «فاکتور ووکامرس» انجام نشد. شما نیازمند php <?php echo WOOI_PHP_VERSION; ?> به بالا هستید (نسخه
				php
				فعلی: <?php echo PHP_VERSION; ?>). لطفا به
				هاستینگ خود تیکت بزنید و درخواست کنید نسخه php شما را ارتقا دهند.
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

$GLOBALS['WOOI'] = WOOI();
