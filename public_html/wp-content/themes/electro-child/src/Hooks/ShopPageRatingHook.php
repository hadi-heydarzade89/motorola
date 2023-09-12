<?php declare(strict_types=1);

namespace ElectroApp\Hooks;

class ShopPageRatingHook
{
    public function __invoke()
    {
        add_action('woocommerce_after_shop_loop_item_title', function () {
            global $product;

            if (get_option('woocommerce_enable_review_rating') === 'no') {
                return;
            }
            $avgReview = (float)$product->get_average_rating();

            if ((floatval($avgReview) - intval($avgReview)) == 0) {
                $average = number_format($avgReview);

            } else {
                $average = number_format($avgReview, 1);
            }
            if (defined('WC_VERSION') && version_compare(WC_VERSION, '2.7', '<')) {
                $rating_html = $product->get_rating_html();

            } else {
                $rating_html = '<div class="star-rating" role="img" aria-label="' . $average . '"><span></span></div>';
                ?>

                <?php
            }


            ?>
            <div class="product-rating">
                <?= wp_kses_post($rating_html); ?>
                <div class="electro-reviews-count"><?= $average; ?></div>
            </div>
            <?php
        });
    }
}