<?php
/**
 * Template part for displaying slider section
 *
 * @package Pharmacy Shop
 * @subpackage pharmacy_shop
 */

?>
<?php $static_image_pharmacy_shop= get_stylesheet_directory_uri() . '/assets/images/sliderimage.png'; ?>
<?php if( get_theme_mod( 'pharmacy_shop_slider_arrows') != '') { ?>
  <section id="slider">
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <?php $pharmacy_shop_slide_pages = array();
      for ( $count = 1; $count <= 4; $count++ ) {
        $mod = intval( get_theme_mod( 'pharmacy_shop_slider_page' . $count ));
        if ( 'page-none-selected' != $mod ) {
          $pharmacy_shop_slide_pages[] = $mod;
        }
      }
      if( !empty($pharmacy_shop_slide_pages) ) :
        $pharmacy_shop_args = array(
          'post_type' => 'page',
          'post__in' => $pharmacy_shop_slide_pages,
          'orderby' => 'post__in'
        );
        $pharmacy_shop_query = new WP_Query( $pharmacy_shop_args );
        if ( $pharmacy_shop_query->have_posts() ) :
          $i = 1;
    ?>
    <div class="carousel-inner" role="listbox">
      <?php  while ( $pharmacy_shop_query->have_posts() ) : $pharmacy_shop_query->the_post(); ?>
        <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
          <?php if(has_post_thumbnail()){ ?>
               <img src="<?php the_post_thumbnail_url('full'); ?>"/> <?php }else {echo ('<img src="'.$static_image_pharmacy_shop.'">'); } ?>
          <div class="carousel-caption">
            <div class="inner_carousel">
              <?php if( get_theme_mod( 'pharmacy_shop_slider_short_heading' ) != '' ) { ?>
                <h6 class="xtra-head"><?php echo esc_html( get_theme_mod( 'pharmacy_shop_slider_short_heading','' ) ); ?></h6>
              <?php } ?>
              <a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
              <p><?php echo esc_html( wp_trim_words( get_the_content(), 20 ) );?></p>
              <div class="more-btn">
                <a href="<?php the_permalink(); ?>"><i class="fas fa-shopping-basket"></i>  <?php esc_html_e('Shop Now','pharmacy-shop'); ?></a>
              </div>
            </div>
          </div>
        </div>
      <?php $i++; endwhile;
      wp_reset_postdata();?>
    </div>
    <?php else : ?>
        <div class="no-postfound"></div>
      <?php endif;
    endif;?>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
    </a>
  </div>
  <div class="clearfix"></div>
</section>

<?php } ?>
