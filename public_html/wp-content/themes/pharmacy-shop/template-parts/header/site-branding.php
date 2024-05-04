<?php
/*
* Display Logo and nav
*/
?>

<div class="headerbox">
  <div class="container">
          <div class="row">
            <div class="col-lg-2 col-md-1"></div>
            <div class="col-lg-5 col-md-3 align-self-center">
              <?php get_template_part( 'template-parts/navigation/site', 'nav' ); ?>
            </div>
            <div class="col-lg-3 col-md-4 align-self-center">
              <div class="product-search">
                  <?php if(get_theme_mod('pharmacy_shop_search_icon',true) != ''){ ?>
                    <div class="search_inner my-3 my-md-0">
                      <?php if(class_exists('woocommerce')){ ?>
                        <?php get_product_search_form(); ?>
                      <?php }?>
                    </div>
                  <?php }?>
              </div>
            </div>
            <div class="col-lg-2 col-md-4 align-self-center">
              <div class="header-details">
                <?php if(get_theme_mod('pharmacy_shop_cart_icon',true) != ''){ ?>
                  <p class="mb-0">
                    <?php if(class_exists('woocommerce')){ ?>
                    <span class="cartbox"><a href="<?php if(function_exists('wc_get_cart_url')){ echo esc_url(wc_get_cart_url()); } ?>"><i class="fas fa-shopping-basket px-lg-2"></i><span class="cart-value simplep"> <?php echo esc_html(wp_kses_data( WC()->cart->get_cart_contents_count()));?></span></a>   
                    </span>
                    <?php } ?>
                  </p>
                <?php } ?>
                 <?php if(get_theme_mod('pharmacy_shop_note_link' ) != ''){?>
                    <a href="<?php echo esc_url( get_theme_mod('pharmacy_shop_note_link','') ); ?>"><i class="fas fa-sticky-note"></i></a>
                  <?php } ?>
                <?php if(class_exists('YITH_WCWL')){ ?>
                  <p class="mb-0"><i class="far fa-heart px-lg-2"></i><a href="<?php echo esc_url(home_url('/index.php/wishlist')); ?>"></a></p>
                <?php } ?>
                  <?php if(get_theme_mod('pharmacy_shop_user_icon',true) != ''){ ?>
                    <p class="mb-0">
                      <?php if(class_exists('woocommerce')){ ?>
                        <?php if (is_user_logged_in()) : ?>
                          <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>"><i class="fas fa-sign-out-alt px-lg-2"></i></a>
                        <?php else : ?>
                          <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>"><i class="far fa-user px-lg-2"></i></a>
                        <?php endif;?>
                      <?php } ?>
                    </p>
                  <?php }?>
              </div>
            </div>
          </div>
  </div>
</div>