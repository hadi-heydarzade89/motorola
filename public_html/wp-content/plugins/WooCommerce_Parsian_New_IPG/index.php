<?php
/*
Plugin Name: درگاه پرداخت پارسیان جدید افزونه ووکامرس
Version: 5.5
Description: درگاه پرداخت پارسیان جدید برای افزونه ووکامرس - این افزونه به صورت تجاری توسط ووکامرس فارسی به فروش می رسد و هرگونه کپی برداری و اشتراک گذاری آن غیر مجاز می باشد.
Plugin URI: http://woocommerce.ir/
Author: ووکامرس فارسی
Author URI: http://woocommerce.ir/
*/

add_action( 'plugins_loaded', function () {

	if ( ! class_exists( 'Persian_Woocommerce_Gateways' ) ) {
		return add_action( 'admin_notices', function () { ?>
			<div class="notice notice-error">
				<p>برای استفاده از درگاه پرداخت پارسیان جدید ووکامرس باید ووکامرس پارسی 3.3.6 به بالا را نصب نمایید.</p>
			</div>
			<?php
		} );
	}

	include_once('class-gateway.php');
}, 999 );