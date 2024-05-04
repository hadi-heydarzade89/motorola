 <?php if(class_exists('woocommerce')){ ?>
  <div class="category-btn"><i class="fa fa-bars" aria-hidden="true"></i><?php echo esc_html(get_theme_mod('pharmacy_shop_category_text','Top Best Category','pharmacy-shop')); ?></div>
  <div class="category-dropdown">
    <?php
      $args = array(
        'number'     => get_theme_mod('pharmacy_shop_product_category_number'),
        'orderby'    => 'title',
        'order'      => 'ASC',
        'hide_empty' => 0,
        'parent'  => 0
      );
      $product_categories = get_terms( 'product_cat', $args );
      $count = count($product_categories);
      if ( $count > 0 ){
        foreach ( $product_categories as $product_category ) {
          $pharmacy_shop_cat_id   = $product_category->term_id;
          $cat_link = get_category_link( $pharmacy_shop_cat_id );
          if ($product_category->category_parent == 0) { ?>
        <li class="drp_dwn_menu"><a href="<?php echo esc_url(get_term_link( $product_category ) ); ?>">
        <?php
      	}
        echo esc_html( $product_category->name ); ?></a></li>
        <?php
        }
      }
	?>
	</div>
<?php }?>