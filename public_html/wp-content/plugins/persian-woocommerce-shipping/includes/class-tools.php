<?php
/**
 * Developer : MahdiY
 * Web Site  : MahdiY.IR
 * E-Mail    : M@hdiY.IR
 */

defined( 'ABSPATH' ) || exit;

class PWS_Tools {

	public function __construct() {

		if ( PWS()->get_option( 'tapin.show_credit' ) == 1 ) {
			add_action( 'admin_bar_menu', [ $this, 'admin_bar_menu' ], 999 );
		}

		if ( PWS()->get_option( 'tools.hide_when_free' ) == 1 ) {
			add_filter( 'woocommerce_package_rates', [ $this, 'hide_when_free' ], 100 );
		}

		if ( PWS()->get_option( 'tools.hide_when_courier' ) == 1 ) {
			add_filter( 'woocommerce_package_rates', [ $this, 'hide_when_courier' ], 100 );
		}

		add_filter( 'woocommerce_new_order_note_data', [ $this, 'new_order_note_data' ], 100, 2 );
		add_filter( 'pws_states', [ $this, 'fix_arabic_characters' ], 1000 );
		add_filter( 'pws_cities', [ $this, 'fix_arabic_characters' ], 1000 );
	}

	public function admin_bar_menu( $wp_admin_bar ) {

		if ( ! PWS_Tapin::is_enable() || ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		$message = null;

		$credit = get_transient( 'pws_tapin_credit' );

		if ( $credit === false ) {

			PWS_Tapin::set_gateway( PWS()->get_option( 'tapin.gateway' ) );

			$credit = PWS_Tapin::request( 'v2/public/transaction/credit/', [
				'shop_id' => PWS()->get_option( 'tapin.shop_id' ),
			] );

			if ( is_wp_error( $credit ) ) {
				$message = $credit->get_error_message();
				$credit  = 'خطا';
			} else if ( $credit->returns->status == 200 ) {
				$credit = wc_price( PWS()->convert_currency( $credit->entries->credit ?? 0 ) );
				set_transient( 'pws_tapin_credit', $credit, MINUTE_IN_SECONDS * 2 );
			} else {
				$message = $credit->returns->message;
				$credit  = 'خطا';
			}
		}

		$args = [
			'id'    => 'tapin_charge',
			'title' => "اعتبار تاپین: " . $credit,
			'meta'  => [ 'class' => 'tapin' ],
			'href'  => admin_url( 'admin.php?page=pws-tapin' ),
		];

		$wp_admin_bar->add_node( $args );

		if ( ! is_null( $message ) ) {
			$args = [
				'id'     => 'tapin_charge_error',
				'title'  => $message,
				'meta'   => [ 'class' => 'tapin' ],
				'parent' => 'tapin_charge',
				'href'   => admin_url( 'admin.php?page=pws-tapin' ),
			];

			$wp_admin_bar->add_node( $args );
		}
	}

	public function hide_when_free( array $rates ): array {
		$free = []; // snippets.ir

		foreach ( $rates as $rate_id => $rate ) {
			if ( 0 == $rate->cost ) {
				$free[ $rate_id ] = $rate;
			}
		}

		return ! empty( $free ) ? $free : $rates;
	}

	public function hide_when_courier( array $rates ): array {
		$courier = []; // snippets.ir

		foreach ( $rates as $rate_id => $rate ) {
			if ( 'WC_Courier_Method' === $rate->method_id ) {
				$courier[ $rate_id ] = $rate;
			}
		}

		return ! empty( $courier ) ? $courier : $rates;
	}

	public function new_order_note_data( $data, $args ) {

		$barcode = trim( $data['comment_content'] );

		if ( is_numeric( $barcode ) && strlen( $barcode ) >= 20 ) {
			$data['comment_content'] = "بارکد پستی مرسوله شما: {$barcode}
                        می توانید مرسوله خود را از طریق لینک https://radgir.net رهگیری نمایید.";

			update_post_meta( $args['order_id'], 'post_barcode', $barcode );
			$order = new WC_Order( $args['order_id'] );

			do_action( 'pws_save_order_post_barcode', $order, $barcode );
		}

		return $data;
	}

	public function fix_arabic_characters( array $list ): array {

		foreach ( $list as &$item ) {
			$item = str_replace( [ 'ك', 'ي', ], [ 'ک', 'ی' ], $item );
		}

		return $list;
	}
}

new PWS_Tools();
