<?php
/**
 * Plugin Name: افزونه حمل و نقل ووکامرس - حرفه‌ای
 * Plugin URI: https://Nabik.Net
 * Description: مکمل و توسعه‌دهنده افزونه حمل و نقل ووکامرس - نرخ ثابت حرفه‌ای، لیست‌شهرها در صفحه حساب کاربری و...
 * Version: 2.0.2
 * Author: نابیک [Nabik.Net]
 * Author URI: https://Nabik.Net
 * WC requires at least: 7.0.0
 * WC tested up to: 8.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'PWS_PRO_VERSION' ) ) {
	define( 'PWS_PRO_VERSION', '2.0.2' );
}

if ( ! defined( 'PWS_PRO_DIR' ) ) {
	define( 'PWS_PRO_DIR', __DIR__ );
}

if ( ! defined( 'PWS_PRO_FILE' ) ) {
	define( 'PWS_PRO_FILE', __FILE__ );
}

if ( ! defined( 'PWS_PRO_URL' ) ) {
	define( 'PWS_PRO_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! function_exists( 'sg_load' ) ) {

	add_action( 'admin_notices', function () {
		?>
		<div class="notice notice-error">
			<p><b>هشدار: </b>
				فعالسازی «افزونه حمل و نقل ووکامرس - حرفه‌ای» انجام نشد. لودر سورس گاردین روی هاست شما فعال نیست، لطفا
				به هاستینگ خود تیکت بزنید و درخواست کنید لودر سورس گاردین را برای شما نصب و فعالسازی
				نمایند.
			</p>
		</div>
		<?php
	} );

	return;
}

add_action( 'woocommerce_loaded', function () {

	if ( ! defined( 'PWS_VERSION' ) || version_compare( PWS_VERSION, '4.0.0', '<' ) ) {

		add_action( 'admin_notices', function () {

			$url = admin_url( 'plugin-install.php?tab=plugin-information&plugin=persian-woocommerce-shipping' );

			?>
			<div class="notice notice-error">
				<p><b>هشدار: </b>
					فعالسازی «افزونه حمل و نقل ووکامرس - حرفه‌ای» انجام نشد. <a href="<?php echo $url; ?>"
																				target="_blank">افزونه
						حمل و نقل ووکامرس نسخه رایگان</a> فعال نیست، لطفا <b>آخرین نسخه</b> آن را نصب و فعالسازی
					نمایید.
				</p>
			</div>
			<?php
		} );

		return;
	}

	include 'utils/class-license.php';
	include 'utils/class-update.php';
	include 'utils/class-install.php';
	include 'utils/class-version.php';

	include 'includes/class-pws-pro.php';
	include 'includes/class-address.php';
	include 'includes/class-methods.php';
	include 'includes/class-zone.php';
	include 'includes/class-city.php';
	include 'includes/class-rule.php';
	include 'includes/class-tapin.php';
	include 'includes/class-tools.php';
	include 'includes/class-version.php';
	include 'includes/class-order.php';

}, 30 );

add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );
