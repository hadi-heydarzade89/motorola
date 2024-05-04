<?php
/**
 * Template Name: Custom Home Page
 *
 * @package Pharmacy Shop
 * @subpackage pharmacy_shop
 */

get_header(); ?>

<main id="tp_content" role="main">
	<div class="container">
		<div class="row mt-3">
			<div class="col-lg-3 col-md-3 px-md-1">
				<?php get_template_part( 'template-parts/home/slider-category' ); ?>
				<?php do_action( 'pharmacy_shop_after_slider-category' ); ?>
			</div>
			<div class="col-lg-5 col-md-5 px-md-1">
				<?php do_action( 'pharmacy_shop_before_slider' ); ?>

				<?php get_template_part( 'template-parts/home/slider' ); ?>
				<?php do_action( 'pharmacy_shop_after_slider' ); ?>
			</div>
			<div class="col-lg-4 col-md-4 px-md-1">
				<?php get_template_part( 'template-parts/home/slider-banner' ); ?>
				<?php do_action( 'pharmacy_shop_after_slider-banner' ); ?>
			</div>	
		</div>
	</div>
		<?php get_template_part( 'template-parts/home/shop-product' ); ?>
		<?php do_action( 'pharmacy_shop_after_shop-product' ); ?>	
		<?php get_template_part( 'template-parts/home/home-content' ); ?>
		<?php do_action( 'pharmacy_shop_after_home_content' ); ?>
</main>

<?php get_footer();
