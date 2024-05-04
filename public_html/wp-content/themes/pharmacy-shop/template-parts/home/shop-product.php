<?php
/**
 * Template part for displaying product section
 *
 * @package Pharmacy Shop
 * @subpackage pharmacy_shop
 */

?>
<?php $static_image_pharmacy_shop= get_stylesheet_directory_uri() . '/assets/images/sliderimage.png'; ?>
<?php if( get_theme_mod( 'pharmacy_shop_show_hide_product_section') != '') { ?>
<section id="product" class="my-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-4">
				<?php $pharmacy_shop_about_page = array();
		        $pharmacy_shop_mod = absint( get_theme_mod( 'pharmacy_shop_about_page' ));
		        if ( 'page-none-selected' != $pharmacy_shop_mod ) {
		          $pharmacy_shop_about_page[] = $pharmacy_shop_mod;
		        }
			      if( !empty($pharmacy_shop_about_page) ) :
			        $pharmacy_shop_args = array(
			          'post_type' => 'page',
			          'post__in' => $pharmacy_shop_about_page,
			          'orderby' => 'post__in'
			        );
		        $pharmacy_shop_query = new WP_Query( $pharmacy_shop_args );
	        	if ( $pharmacy_shop_query->have_posts() ) :
	          	while ( $pharmacy_shop_query->have_posts() ) : $pharmacy_shop_query->the_post(); ?>
	          	<div class="product-main-img position-relative">
	          		<?php if(has_post_thumbnail()){ ?>
	               <img src="<?php the_post_thumbnail_url('full'); ?>"/> <?php }else {echo ('<img src="'.$static_image_pharmacy_shop.'">'); } ?>
	          		<div class="product-info">
	          			<p><?php echo wp_trim_words( get_the_content(),5 );?></p>
	   					<h4 class="mb-4"><?php the_title(); ?></h4>
			           <div class="more-btn">
	                    <a href="<?php the_permalink(); ?>"><i class="fas fa-shopping-basket"></i>  <?php esc_html_e('Shop Now','pharmacy-shop'); ?></a>
	                  </div>
	   				</div>
	          	</div>
	          <?php endwhile; ?>
	        	<?php else : ?>
	          <div class="no-postfound"></div>
	        	<?php endif;
	      		endif;
	      			wp_reset_postdata();?>
	      		<div class="clearfix"></div>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="row">
					<div class="col-lg-6 align-self-center">
						<div class="heading-det">
							<?php if( get_theme_mod( 'pharmacy_shop_product_short_heading' ) != '' ) { ?>
						  	<h6><?php echo esc_html( get_theme_mod( 'pharmacy_shop_product_short_heading','' ) ); ?></h6>
							<?php } ?>
							<?php if( get_theme_mod( 'pharmacy_shop_product_heading' ) != '' ) { ?>
							  <p><?php echo esc_html( get_theme_mod( 'pharmacy_shop_product_heading','' ) ); ?></p>
							<?php } ?>
						</div>
					</div>
					<div class="col-lg-6 align-self-center">
						 <div class="deals-timer">
			              <?php if(get_theme_mod('pharmacy_shop_blockbustor_deals_countdown_timer_date')!=''){ ?>
			            <span class="pe-3 timer-text"><?php esc_html_e( 'Ends In', 'pharmacy-shop' ); ?></span><div id="banner-clock" class="time_box" <?php if ( ! empty( get_theme_mod('pharmacy_shop_blockbustor_deals_countdown_timer_date') ) ) { ?>data-date="<?php echo esc_attr(get_theme_mod('pharmacy_shop_blockbustor_deals_countdown_timer_date')); ?>" <?php } ?>>
			                </div>
			              <?php } ?>
			            </div>
					</div>
				</div>
				<?php if(class_exists('woocommerce')){ ?> 
				<div class="product_kit">
		      <div class="owl-carousel">
	          <?php
	            $pharmacy_shop_args = array(
	              'post_type'      => 'product',
	              'posts_per_page' => 10,
	              'product_cat'    => get_theme_mod('pharmacy_shop_recent_product_category')
	            );
	            $loop = new WP_Query( $pharmacy_shop_args );
	            while ( $loop->have_posts() ) : $loop->the_post();?>
					<div class="product-box">
						<?php global $product; ?>
							<div class="product-image">
								<?php echo woocommerce_get_product_thumbnail(); ?>
								<div class="pro-buttons">
		                         	<?php if(class_exists('YITH_WCQV')){ ?>
					                	<span><?php echo do_shortcode('[yith_quick_view ]'); ?></span>
						            <?php }?>
									<?php if(class_exists('YITH_WCWL')){ ?>
					                	<span class="wishlist"><?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?></span>
						            <?php }?>
								</div>
							</div>
							<div class="product-content flash_product mt-4">
								<p class="pro-cat mb-1"><?php echo wc_get_product_category_list( $product->get_id(),); ?></p>
								<h3 class="mb-3"><a href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
								<p class="mb-0 mt-2"><?php echo $product->get_price_html(); ?></p>
								 <div class="product-rating">
				                    <?php if( $product->is_type( 'simple' ) ){ woocommerce_template_loop_rating( $loop->post, $product ); } ?>
				                 </div>
				                <div class="custom_product_meta">
		                          <?php if( $product->is_type( 'simple' ) ){ woocommerce_template_loop_add_to_cart( $loop->post, $product ); } ?>
		                        </div>
							</div>
					</div>
				<?php
				endwhile;
				wp_reset_query();
	          	?>
		      </div>
				</div>
					<?php }?>
			</div>
		</div>		
	</div>
</section>
<?php }?>
