<?php
/**
 * Template part for displaying slider banner
 *
 * @package Pharmacy Shop
 * @subpackage pharmacy_shop
 */

?>
<?php $static_image_pharmacy_shop= get_stylesheet_directory_uri() . '/assets/images/sliderimage.png'; ?>
<div class="slide-banner">
    <div class="banner-1 position-relative">
        <?php
          $pharmacy_shop_postdata = get_theme_mod('pharmacy_shop_static_blog_2');
            if($pharmacy_shop_postdata){
            $pharmacy_shop_args = array( 'name' => esc_html( $pharmacy_shop_postdata ,'pharmacy-shop'));
          $pharmacy_shop_query = new WP_Query( $pharmacy_shop_args );
          if ( $pharmacy_shop_query->have_posts() ) :
            while ( $pharmacy_shop_query->have_posts() ) : $pharmacy_shop_query->the_post(); ?>
                <?php if(has_post_thumbnail()){ ?>
               <img src="<?php the_post_thumbnail_url('full'); ?>"/> <?php }else {echo ('<img src="'.$static_image_pharmacy_shop.'">'); } ?>
                  <div class="blog-info-1">
                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                      <p><?php echo wp_trim_words( get_the_content(),10 );?></p>  
                      <div class="more-btn">
                        <a href="<?php the_permalink(); ?>"><i class="fas fa-shopping-basket"></i>  <?php esc_html_e('Shop Now','pharmacy-shop'); ?></a>
                      </div>
                  </div>
            <?php endwhile;
            wp_reset_postdata();?>
            <?php else : ?>
              <div class="no-postfound"></div>
            <?php
        endif; }?>  
    </div>
</div>