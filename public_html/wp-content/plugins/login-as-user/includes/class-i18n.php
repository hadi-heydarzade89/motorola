<?php
/* ======================================================
 # Login as User for WordPress - v1.4.9 (free version)
 # -------------------------------------------------------
 # For WordPress
 # Author: Web357
 # Copyright @ 2014-2023 Web357. All rights reserved.
 # License: GNU/GPLv3, http://www.gnu.org/licenses/gpl-3.0.html
 # Website: https:/www.web357.com
 # Demo: https://demo.web357.com/wordpress/login-as-user/wp-admin/
 # Support: support@web357.com
 # Last modified: Thursday 18 April 2024, 03:29:07 AM
 ========================================================= */
/**
 * Define the internationalization functionality
 */
class LoginAsUser_i18n {

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'login-as-user',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages'
		);

	}
}