<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Pharmacy Shop
 * @subpackage pharmacy_shop
 */

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function pharmacy_shop_categorized_blog() {
	$pharmacy_shop_category_count = get_transient( 'pharmacy_shop_categories' );

	if ( false === $pharmacy_shop_category_count ) {
		// Create an array of all the categories that are attached to posts.
		$categories = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$pharmacy_shop_category_count = count( $categories );

		set_transient( 'pharmacy_shop_categories', $pharmacy_shop_category_count );
	}

	// Allow viewing case of 0 or 1 categories in post preview.
	if ( is_preview() ) {
		return true;
	}

	return $pharmacy_shop_category_count > 1;
}

if ( ! function_exists( 'pharmacy_shop_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @since pharmacy_shop
 */
function pharmacy_shop_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

/**
 * Flush out the transients used in pharmacy_shop_categorized_blog.
 */
function pharmacy_shop_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'pharmacy_shop_categories' );
}
add_action( 'edit_category', 'pharmacy_shop_category_transient_flusher' );
add_action( 'save_post',     'pharmacy_shop_category_transient_flusher' );