<?php
/**
 * Displays footer widgets if assigned
 *
 * @package Pharmacy Shop
 * @subpackage pharmacy_shop
 */
?>
<?php

// Determine the number of columns dynamically for the footer (you can replace this with your logic).
$pharmacy_shop_no_of_footer_col = get_theme_mod('pharmacy_shop_footer_columns', 4); // Change this value as needed.

// Calculate the Bootstrap class for large screens (col-lg-X) for footer.
$pharmacy_shop_col_lg_footer_class = 'col-lg-' . (12 / $pharmacy_shop_no_of_footer_col);

// Calculate the Bootstrap class for medium screens (col-md-X) for footer.
$pharmacy_shop_col_md_footer_class = 'col-md-' . (12 / $pharmacy_shop_no_of_footer_col);
?>
<div class="container">
    <aside class="widget-area row py-2 pt-3" role="complementary" aria-label="<?php esc_attr_e( 'Footer', 'pharmacy-shop' ); ?>">
        <div class="<?php echo esc_attr($pharmacy_shop_col_lg_footer_class); ?> <?php echo esc_attr($pharmacy_shop_col_md_footer_class); ?>">
            <?php dynamic_sidebar('footer-1'); ?>
        </div>
        <?php
        // Footer boxes 2 and onwards.
        for ($i = 2; $i <= $pharmacy_shop_no_of_footer_col; $i++) :
            if ($i <= $pharmacy_shop_no_of_footer_col) :
                ?>
               <div class="col-12 <?php echo esc_attr($pharmacy_shop_col_lg_footer_class); ?> <?php echo esc_attr($pharmacy_shop_col_md_footer_class); ?>">
                    <?php dynamic_sidebar('footer-' . $i); ?>
                </div><!-- .footer-one-box -->
                <?php
            endif;
        endfor;
        ?>
    </aside>
</div>