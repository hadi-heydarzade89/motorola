<?php
/**
 * Pharmacy Shop Theme Page
 *
 * @package Pharmacy Shop
 */

function pharmacy_shop_admin_scripts() {
	wp_dequeue_script('pharmacy-shop-custom-scripts');
}
add_action( 'admin_enqueue_scripts', 'pharmacy_shop_admin_scripts' );

if ( ! defined( 'PHARMACY_SHOP_FREE_THEME_URL' ) ) {
	define( 'PHARMACY_SHOP_FREE_THEME_URL', 'https://www.themespride.com/themes/free-pharmacy-store-wordpress-theme/' );
}
if ( ! defined( 'PHARMACY_SHOP_PRO_THEME_URL' ) ) {
	define( 'PHARMACY_SHOP_PRO_THEME_URL', 'https://www.themespride.com/themes/pharmacy-wordpress-theme/' );
}
if ( ! defined( 'PHARMACY_SHOP_DEMO_THEME_URL' ) ) {
	define( 'PHARMACY_SHOP_DEMO_THEME_URL', 'https://www.themespride.com/pharmacy-shop/' );
}
if ( ! defined( 'PHARMACY_SHOP_DOCS_THEME_URL' ) ) {
    define( 'PHARMACY_SHOP_DOCS_THEME_URL', 'https://www.themespride.com/demo/docs/pharmacy-shop/' );
}
if ( ! defined( 'PHARMACY_SHOP_RATE_THEME_URL' ) ) {
    define( 'PHARMACY_SHOP_RATE_THEME_URL', 'https://wordpress.org/support/theme/pharmacy-shop/reviews/#new-post' );
}
if ( ! defined( 'PHARMACY_SHOP_SUPPORT_THEME_URL' ) ) {
    define( 'PHARMACY_SHOP_SUPPORT_THEME_URL', 'https://wordpress.org/support/theme/pharmacy-shop/' );
}
if ( ! defined( 'PHARMACY_SHOP_CHANGELOG_THEME_URL' ) ) {
    define( 'PHARMACY_SHOP_CHANGELOG_THEME_URL', get_template_directory() . '/readme.txt' );
}
if ( ! defined( 'WEIGHT_LOSS_CENTER_THEME_BUNDLE' ) ) {
    define( 'WEIGHT_LOSS_CENTER_THEME_BUNDLE', 'https://www.themespride.com/themes/wordpress-theme-bundle/' );
}

/**
 * Add theme page
 */
function pharmacy_shop_menu() {
	add_theme_page( esc_html__( 'About Theme', 'pharmacy-shop' ), esc_html__( 'About Theme', 'pharmacy-shop' ), 'edit_theme_options', 'pharmacy-shop-about', 'pharmacy_shop_about_display' );
}
add_action( 'admin_menu', 'pharmacy_shop_menu' );

/**
 * Display About page
 */
function pharmacy_shop_about_display() {
	$pharmacy_shop_theme = wp_get_theme();
	?>
	<div class="wrap about-wrap full-width-layout">
		<h1><?php echo esc_html( $pharmacy_shop_theme ); ?></h1>
		<div class="about-theme">
			<div class="theme-description">
				<p class="about-text">
					<?php
					// Remove last sentence of description.
					$pharmacy_shop_description = explode( '. ', $pharmacy_shop_theme->get( 'Description' ) );

					array_pop( $pharmacy_shop_description );

					$pharmacy_shop_description = implode( '. ', $pharmacy_shop_description );

					echo esc_html( $pharmacy_shop_description . '.' );
				?></p>
				<p class="actions">
					<a target="_blank" href="<?php echo esc_url( PHARMACY_SHOP_FREE_THEME_URL ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'pharmacy-shop' ); ?></a>

					<a target="_blank" href="<?php echo esc_url( PHARMACY_SHOP_DEMO_THEME_URL ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'View Demo', 'pharmacy-shop' ); ?></a>

					<a target="_blank" href="<?php echo esc_url( PHARMACY_SHOP_DOCS_THEME_URL ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Instructions', 'pharmacy-shop' ); ?></a>

					<a target="_blank" href="<?php echo esc_url( PHARMACY_SHOP_RATE_THEME_URL ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Rate this theme', 'pharmacy-shop' ); ?></a>

					<a target="_blank" href="<?php echo esc_url( PHARMACY_SHOP_PRO_THEME_URL ); ?>" class="green button button-secondary" target="_blank"><?php esc_html_e( 'Upgrade to pro', 'pharmacy-shop' ); ?></a>
				</p>
			</div>

			<div class="theme-screenshot">
				<img src="<?php echo esc_url( $pharmacy_shop_theme->get_screenshot() ); ?>" />
			</div>

		</div>

		<nav class="nav-tab-wrapper wp-clearfix" aria-label="<?php esc_attr_e( 'Secondary menu', 'pharmacy-shop' ); ?>">
			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'pharmacy-shop-about' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['page'] ) && 'pharmacy-shop-about' === $_GET['page'] && ! isset( $_GET['tab'] ) ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'About', 'pharmacy-shop' ); ?></a>

			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'pharmacy-shop-about', 'tab' => 'free_vs_pro' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['tab'] ) && 'free_vs_pro' === $_GET['tab'] ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'Compare free Vs Pro', 'pharmacy-shop' ); ?></a>

			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'pharmacy-shop-about', 'tab' => 'changelog' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['tab'] ) && 'changelog' === $_GET['tab'] ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'Changelog', 'pharmacy-shop' ); ?></a>

			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'pharmacy-shop-about', 'tab' => 'get_bundle' ), 'themes.php' ) ) ); ?>" class="blink wp-bundle nav-tab<?php echo ( isset( $_GET['tab'] ) && 'get_bundle' === $_GET['tab'] ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'Get WordPress Theme Bundle', 'pharmacy-shop' ); ?></a>
		</nav>

		<?php
			pharmacy_shop_main_screen();

			pharmacy_shop_changelog_screen();

			pharmacy_shop_free_vs_pro();

			pharmacy_shop_get_bundle();
		?>

		<div class="return-to-dashboard">
			<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
				<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
					<?php is_multisite() ? esc_html_e( 'Return to Updates', 'pharmacy-shop' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'pharmacy-shop' ); ?>
				</a> |
			<?php endif; ?>
			<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'pharmacy-shop' ) : esc_html_e( 'Go to Dashboard', 'pharmacy-shop' ); ?></a>
		</div>
	</div>
	<?php
}

/**
 * Output the main about screen.
 */
function pharmacy_shop_main_screen() {
	if ( isset( $_GET['page'] ) && 'pharmacy-shop-about' === $_GET['page'] && ! isset( $_GET['tab'] ) ) {
	?>
		<div class="feature-section two-col">
			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Theme Customizer', 'pharmacy-shop' ); ?></h2>
				<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'pharmacy-shop' ) ?></p>
				<p><a target="_blank" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Customize', 'pharmacy-shop' ); ?></a></p>
			</div>

			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Got theme support question?', 'pharmacy-shop' ); ?></h2>
				<p><?php esc_html_e( 'Get genuine support from genuine people. Whether it\'s customization or compatibility, our seasoned developers deliver tailored solutions to your queries.', 'pharmacy-shop' ) ?></p>
				<p><a target="_blank" href="<?php echo esc_url( PHARMACY_SHOP_SUPPORT_THEME_URL ); ?>" class="button button-primary"><?php esc_html_e( 'Support Forum', 'pharmacy-shop' ); ?></a></p>
			</div>

			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Upgrade To Premium With Straight 20% OFF.', 'pharmacy-shop' ); ?></h2>
				<p><?php esc_html_e( 'Get our amazing WordPress theme with exclusive 20% off use the coupon', 'pharmacy-shop' ) ?>"<input type="text" value="GETPro20" id="myInput">".</p>
				<button class="button button-primary"><?php esc_html_e( 'GETPro20', 'pharmacy-shop' ); ?></button>
			</div>
		</div>
	<?php
	}
}

/**
 * Output the changelog screen.
 */
function pharmacy_shop_changelog_screen() {
	if ( isset( $_GET['tab'] ) && 'changelog' === $_GET['tab'] ) {
		global $wp_filesystem;
	?>
		<div class="wrap about-wrap">

			<p class="about-description"><?php esc_html_e( 'View changelog below:', 'pharmacy-shop' ); ?></p>

			<?php
				$changelog_file = apply_filters( 'pharmacy_shop_changelog_file', PHARMACY_SHOP_CHANGELOG_THEME_URL );
				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = pharmacy_shop_parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
			?>
		</div>
	<?php
	}
}

/**
 * Parse changelog from readme file.
 * @param  string $content
 * @return string
 */
function pharmacy_shop_parse_changelog( $content ) {
	// Explode content with ==  to juse separate main content to array of headings.
	$content = explode ( '== ', $content );

	$changelog_isolated = '';

	// Get element with 'Changelog ==' as starting string, i.e isolate changelog.
	foreach ( $content as $key => $value ) {
		if (strpos( $value, 'Changelog ==') === 0) {
	    	$changelog_isolated = str_replace( 'Changelog ==', '', $value );
	    }
	}

	// Now Explode $changelog_isolated to manupulate it to add html elements.
	$changelog_array = explode( '= ', $changelog_isolated );

	// Unset first element as it is empty.
	unset( $changelog_array[0] );

	$changelog = '<pre class="changelog">';

	foreach ( $changelog_array as $value) {
		// Replace all enter (\n) elements with </span><span> , opening and closing span will be added in next process.
		$value = preg_replace( '/\n+/', '</span><span>', $value );

		// Add openinf and closing div and span, only first span element will have heading class.
		$value = '<div class="block"><span class="heading">= ' . $value . '</span></div>';

		// Remove empty <span></span> element which newr formed at the end.
		$changelog .= str_replace( '<span></span>', '', $value );
	}

	$changelog .= '</pre>';

	return wp_kses_post( $changelog );
}

/**
 * Import Demo data for theme using catch themes demo import plugin
 */
function pharmacy_shop_free_vs_pro() {
	if ( isset( $_GET['tab'] ) && 'free_vs_pro' === $_GET['tab'] ) {
	?>
		<div class="wrap about-wrap">

			<p class="about-description"><?php esc_html_e( 'View Free vs Pro Table below:', 'pharmacy-shop' ); ?></p>
			<div class="vs-theme-table">
				<table>
					<thead>
						<tr><th scope="col"></th>
							<th class="head" scope="col"><?php esc_html_e( 'Free Theme', 'pharmacy-shop' ); ?></th>
							<th class="head" scope="col"><?php esc_html_e( 'Pro Theme', 'pharmacy-shop' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><span><?php esc_html_e( 'Theme Demo Set Up', 'pharmacy-shop' ); ?></span></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Additional Templates, Color options and Fonts', 'pharmacy-shop' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Included Demo Content', 'pharmacy-shop' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Section Ordering', 'pharmacy-shop' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Multiple Sections', 'pharmacy-shop' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Additional Plugins', 'pharmacy-shop' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Premium Technical Support', 'pharmacy-shop' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Access to Support Forums', 'pharmacy-shop' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Free updates', 'pharmacy-shop' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Unlimited Domains', 'pharmacy-shop' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Responsive Design', 'pharmacy-shop' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Live Customizer', 'pharmacy-shop' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td class="feature feature--empty"></td>
							<td class="feature feature--empty"></td>
							<td headers="comp-2" class="td-btn-2"><a class="sidebar-button single-btn" href="<?php echo esc_url(PHARMACY_SHOP_PRO_THEME_URL);?>" target="_blank"><?php esc_html_e( 'Go For Premium', 'pharmacy-shop' ); ?></a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	<?php
	}
}

function pharmacy_shop_get_bundle() {
	if ( isset( $_GET['tab'] ) && 'get_bundle' === $_GET['tab'] ) {
	?>
		<div class="wrap about-wrap">

			<p class="about-description"><?php esc_html_e( 'Get WordPress Theme Bundle', 'pharmacy-shop' ); ?></p>
			<div class="col card">
				<h2 class="title"><?php esc_html_e( ' WordPress Theme Bundle of 65+ Themes At 15% Discount. ', 'pharmacy-shop' ); ?></h2>
				<p><?php esc_html_e( 'Spring Offer Is To Get WP Bundle of 65+ Themes At 15% Discount use the coupon', 'pharmacy-shop' ) ?>"<input type="text" value=" TPRIDE15 "  id="myInput">".</p>
				<p><a target="_blank" href="<?php echo esc_url( WEIGHT_LOSS_CENTER_THEME_BUNDLE ); ?>" class="button button-primary"><?php esc_html_e( 'Theme Bundle', 'pharmacy-shop' ); ?></a></p>
			</div>
		</div>
	<?php
	}
}
