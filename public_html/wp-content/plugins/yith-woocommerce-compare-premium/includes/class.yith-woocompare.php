<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Main class
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Compare
 * @version 1.1.4
 */

defined( 'YITH_WOOCOMPARE' ) || exit; // Exit if accessed directly.

if ( ! class_exists( 'YITH_Woocompare' ) ) {
	/**
	 * YITH Woocommerce Compare
	 *
	 * @since 1.0.0
	 */
	class YITH_Woocompare {

		/**
		 * Plugin object
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $obj = null;

		/**
		 * AJAX Helper
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $ajax = null;

		/**
		 * Constructor
		 *
		 * @return YITH_Woocompare_Admin | YITH_Woocompare_Frontend
		 * @since 1.0.0
		 */
		public function __construct() {

			add_action( 'widgets_init', array( $this, 'register_widgets' ) );

			// Load Plugin Framework.
			add_action( 'after_setup_theme', array( $this, 'plugin_fw_loader' ), 1 );
            add_action( 'before_woocommerce_init', array( $this, 'declare_wc_features_support' ) );

            // Register plugin to licence/update system.
            add_action( 'wp_loaded', array( $this, 'register_plugin_for_activation' ), 99 );
            add_action( 'wp_loaded', array( $this, 'register_plugin_for_updates' ), 99 );

			if ( $this->is_frontend() ) {

				// Requires frontend class.
				require_once 'class.yith-woocompare-frontend.php';
				require_once 'class.yith-woocompare-frontend-premium.php';

				$this->obj = new YITH_Woocompare_Frontend_Premium();

			} elseif ( $this->is_admin() ) {

				// Requires admin classes.
				require_once 'class.yith-woocompare-admin.php';
				require_once 'class.yith-woocompare-admin-premium.php';

				$this->obj = new YITH_Woocompare_Admin_Premium();
			}

			// Init plugin.
			add_action( 'init', array( $this, 'init' ), 10 );

			// Add image size.
			YITH_Woocompare_Helper::set_image_size();

			// Let's filter the woocommerce image size.
			add_filter( 'woocommerce_get_image_size_yith-woocompare-image', array( $this, 'filter_wc_image_size' ), 10, 1 );

			return $this->obj;
		}

		/**
		 * Init plugin
		 *
		 * @since 2.0.0
		 */
		public function init() {
			// Add compare page.
			$this->add_page();
		}

		/**
		 * Detect if is frontend
		 *
		 * @return bool
		 */
		public function is_frontend() {
			$is_ajax       = ( defined( 'DOING_AJAX' ) && DOING_AJAX );
			$context_check = isset( $_REQUEST['context'] ) && 'frontend' === sanitize_text_field( wp_unslash( $_REQUEST['context'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			/**
			 * APPLY_FILTERS: yith_woocompare_actions_to_check_frontend
			 *
			 * Filters the actions to check to load the required files, for better compatibility with third-party software.
			 *
			 * @param array $actions Actions to check.
			 *
			 * @return array
			 */
			$actions_to_check = apply_filters( 'yith_woocompare_actions_to_check_frontend', array( 'woof_draw_products', 'prdctfltr_respond_550', 'wbmz_get_products', 'jet_smart_filters', 'productfilter' ) );
			$action_check     = isset( $_REQUEST['action'] ) && in_array( sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ), $actions_to_check, true ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			return (bool) YITH_Woocompare_Helper::is_elementor_editor() || ( ! is_admin() || ( $is_ajax && ( $context_check || $action_check ) ) );
		}

		/**
		 * Detect if is admin
		 *
		 * @return bool
		 */
		public function is_admin() {
			$is_ajax  = ( defined( 'DOING_AJAX' ) && DOING_AJAX );
			$is_admin = ( is_admin() || $is_ajax && isset( $_REQUEST['context'] ) && 'admin' === sanitize_text_field( wp_unslash( $_REQUEST['context'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			/**
			 * APPLY_FILTERS: yith_woocompare_check_is_admin
			 *
			 * Filters whether the current request is made for an admin page.
			 *
			 * @param bool $is_admin Whether the request is made for an admin page or not.
			 *
			 * @return bool
			 */
			return apply_filters( 'yith_woocompare_check_is_admin', (bool) $is_admin );
		}

		/**
		 * Load Plugin Framework
		 *
		 * @since  1.0
		 * @access public
		 * @return void
		 */
		public function plugin_fw_loader() {

			if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
				global $plugin_fw_data;
				if ( ! empty( $plugin_fw_data ) ) {
					$plugin_fw_file = array_shift( $plugin_fw_data );
					require_once $plugin_fw_file;
				}
			}
		}

        /**
         * Declare support for WooCommerce features.
         *
         * @since 2.26.0
         */
        public function declare_wc_features_support() {
            if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
                $init = defined( 'YITH_WOOCOMPARE_INIT' ) ? YITH_WOOCOMPARE_INIT : false;
                \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', $init, true );
            }
        }

        /**
         * Register plugins for activation tab
         *
         * @since    2.0.0
         * @return void
         */
        public function register_plugin_for_activation() {
            if ( ! class_exists( 'YIT_Plugin_Licence' ) ) {
                require_once YITH_WOOCOMPARE_DIR . 'plugin-fw/lib/yit-plugin-licence.php';
            }

            YIT_Plugin_Licence()->register( YITH_WOOCOMPARE_INIT, YITH_WOOCOMPARE_SECRET_KEY, YITH_WOOCOMPARE_SLUG );
        }

        /**
         * Register plugins for update tab
         *
         * @since    2.0.0
         * @return void
         */
        public function register_plugin_for_updates() {
            if ( ! class_exists( 'YIT_Upgrade' ) ) {
                require_once YITH_WOOCOMPARE_DIR . 'plugin-fw/lib/yit-upgrade.php';
            }
            YIT_Upgrade()->register( YITH_WOOCOMPARE_SLUG, YITH_WOOCOMPARE_INIT );
        }

		/**
		 * Load and register widgets
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public function register_widgets() {
			register_widget( 'YITH_Woocompare_Widget' );
			register_widget( 'YITH_Woocompare_Widget_Counter' );
		}

		/**
		 * Add a page "Compare".
		 *
		 * @return void
		 * @since 1.0.0
		 */
		private function add_page() {
			global $wpdb;

			$option_value = get_option( 'yith-woocompare-page-id' );

			if ( $option_value > 0 && get_post( $option_value ) ) {
				return;
			}

			$page_found = $wpdb->get_var( "SELECT `ID` FROM `{$wpdb->posts}` WHERE `post_name` = 'yith-compare' LIMIT 1;" ); // phpcs:ignore
			if ( $page_found ) :
				if ( ! $option_value ) {
					update_option( 'yith-woocompare-page-id', $page_found );
				}
				return;
			endif;

			$page_data = array(
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'post_author'    => 1,
				'post_name'      => esc_sql( _x( 'yith-compare', 'page_slug', 'yith-woocommerce-compare' ) ),
				'post_title'     => __( 'Compare', 'yith-woocommerce-compare' ),
				'post_content'   => '[yith_woocompare_table]',
				'post_parent'    => 0,
				'comment_status' => 'closed',
			);
			$page_id   = wp_insert_post( $page_data );

			update_option( 'yith-woocompare-page-id', $page_id );
		}

		/**
		 * Filter WooCommerce image size attr
		 *
		 * @since 2.3.5
		 * @param array $size The default image size.
		 * @return array
		 */
		public function filter_wc_image_size( $size ) {

			$size_opt = get_option( 'yith_woocompare_image_size' );

			return array(
				'width'  => isset( $size_opt['width'] ) ? absint( $size_opt['width'] ) : 600,
				'height' => isset( $size_opt['height'] ) ? absint( $size_opt['height'] ) : 600,
				'crop'   => isset( $size_opt['crop'] ) ? 1 : 0,
			);
		}
	}
}
