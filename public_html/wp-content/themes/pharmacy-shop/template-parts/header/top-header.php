<?php
/*
* Display Topbar
*/
?>

<div class="topbar">
	<div class="container">
          <div class="row">
            <div class="col-lg-2 col-md-4 position-relative">
              <?php $pharmacy_shop_logo_settings = get_theme_mod( 'pharmacy_shop_logo_settings','Different Line');
		          if($pharmacy_shop_logo_settings == 'Different Line'){ ?>
		            <div class="logo mb-md-0 text-center">
		              <?php if( has_custom_logo() ) pharmacy_shop_the_custom_logo(); ?>
		              <?php if(get_theme_mod('pharmacy_shop_site_title',true) == 1){ ?>
		                <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		              <?php }?>
		              <?php $pharmacy_shop_description = get_bloginfo( 'description', 'display' );
		              if ( $pharmacy_shop_description || is_customize_preview() ) : ?>
		                <?php if(get_theme_mod('pharmacy_shop_site_tagline',false)){ ?>
		                  <p class="site-description mb-0"><?php echo esc_html($pharmacy_shop_description); ?></p>
		                <?php }?>
		              <?php endif; ?>
		            </div>
		          <?php }else if($pharmacy_shop_logo_settings == 'Same Line'){ ?>
		            <div class="logo logo-same-line mb-md-0 text-center text-lg-start">
		              <div class="row">
		                <div class="col-lg-5 col-md-5 align-self-md-center">
		                  <?php if( has_custom_logo() ) pharmacy_shop_the_custom_logo(); ?>
		                </div>
		                <div class="col-lg-7 col-md-7 align-self-md-center">
		                  <?php if(get_theme_mod('pharmacy_shop_site_title',true) == 1){ ?>
		                    <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		                    <?php }?>
		                    <?php $pharmacy_shop_description = get_bloginfo( 'description', 'display' );
		                    if ( $pharmacy_shop_description || is_customize_preview() ) : ?>
		                    <?php if(get_theme_mod('pharmacy_shop_site_tagline',false)){ ?>
		                      <p class="site-description mb-0"><?php echo esc_html($pharmacy_shop_description); ?></p>
		                    <?php }?>
		                  <?php endif; ?>
		                </div>
		              </div>
		            </div>
		          <?php }?>
            </div>
            <div class=" topbar-text col-lg-6 col-md-4 align-self-center">
              <div class="top-header py-2">
                <?php if( get_theme_mod( 'pharmacy_shop_topbar_text' ) != '') { ?>
                  <p class="mb-0"><?php echo esc_html( get_theme_mod('pharmacy_shop_topbar_text','')); ?></p>
                <?php } ?>
              </div>
            </div>
            <div class="contact-dtl col-lg-4 col-md-4 align-self-center text-lg-end">
              <?php if( get_theme_mod( 'pharmacy_shop_phone' ) != '') { ?>
                <span class="mb-0"><i class="fas fa-phone px-2 py-2"></i><?php echo esc_html( get_theme_mod('pharmacy_shop_phone','')); ?></span>
              <?php } ?>
              <?php if( get_theme_mod( 'pharmacy_shop_mail' ) != '') { ?>
                <span class="mb-0"><i class="fas fa-envelope px-2 py-2"></i><?php echo esc_html( get_theme_mod('pharmacy_shop_mail','')); ?></span>
              <?php } ?>
            </div>
          </div>
	</div>
</div>