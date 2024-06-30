<?php
/**
 * Developer : MahdiY
 * Web Site  : MahdiY.IR
 * E-Mail    : M@hdiY.IR
 */

defined( 'ABSPATH' ) || exit;

if ( class_exists( 'Tapin_Pishtaz_Method' ) ) {
	return;
} // Stop if the class already exists

/**
 * Class WC_Tapin_Method
 *
 * @author mahdiy
 *
 */
class Tapin_Pishtaz_Method extends PWS_Tapin_Method {

	public function __construct( $instance_id = 0 ) {

		$this->id                 = 'Tapin_Pishtaz_Method';
		$this->instance_id        = absint( $instance_id );
		$this->method_title       = 'پست پیشتاز - تاپین';
		$this->method_description = 'ارسال کالا با استفاده از پست پیشتاز - تاپین';

		parent::__construct();
	}

	public static function calculate_rates( array $args ): int {

		$weight = $args['weight'];

		$gateway = $args['gateway'] ?? 'tapin';

		if ( $gateway == 'tapin' ) {

			if ( $args['from_province'] == $args['to_province'] ) {
				$cost   = 148400;
				$per_kg = 45000;
			} else {
				$cost   = 223727;
				$per_kg = 47000;
			}

			// calculate
			if ( $weight > 1000 ) {
				$cost += $per_kg * ceil( ( $weight - 1000 ) / 1000 );
			}

			if ( in_array( $args['to_city'], [ 1, 91, 61, 51, 71, 81, 31 ] ) ) {
				$cost *= 1.1;
			}

		} else {

			switch ( true ) {
				case $weight <= 500:
					$cost = 183400;
					break;
				case $weight >= 501 && $weight <= 1000:
					$cost = 202400;
					break;
				case $weight >= 1001 && $weight <= 2000:
					$cost = 247400;
					break;
				case $weight >= 2001 && $weight <= 2500:
					$cost = 297400;
					break;
				default:
					$cost = 300120;
			}

			// calculate
			if ( $weight > 3000 ) {
				$cost += 50000 * ceil( ( $weight - 3000 ) / 1000 );
			}

		}

		if ( $args['content_type'] != 1 || $weight >= 2500 ) {
			$cost *= 1.25;
		}

		// INSURANCE
		if ( $args['price'] >= 20000000 ) {
			$cost += $args['price'] * 0.002;
		} else {
			$cost += 20000;
		}

		// COD
		if ( $args['is_cod'] ) {
			$cost += $args['price'] * 0.01;
		}

		// TAX
		$cost += $cost * 0.1;

		return intval( $cost );
	}
}
