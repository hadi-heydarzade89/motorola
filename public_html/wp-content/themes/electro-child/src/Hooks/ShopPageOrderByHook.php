<?php declare(strict_types=1);

namespace ElectroApp\Hooks;

class ShopPageOrderByHook
{
    /**
     * @return void
     */
    public function __invoke(): void
    {
        add_filter('woocommerce_catalog_orderby', [$this, 'newOrderByItems']);

    }

    /**
     * @return array
     */
    public function newOrderByItems(): array
    {
        return [
            'date' => __('Sort by latest', 'electro'),
            'menu_order' => __('Sorting', 'electro'),
            'popularity' => __('Sort by popularity', 'electro'),
            'rating' => __('Sort by average rating', 'electro'),
            'price' => __('Sort by price: low to high', 'electro'),
            'price-desc' => __('Sort by price: high to low', 'electro'),
        ];
    }

    private function rateView(): void
    {

        global $product;

        if (get_option('woocommerce_enable_review_rating') === 'no') {
            return;
        }

        if (defined('WC_VERSION') && version_compare(WC_VERSION, '2.7', '<')) {
            $rating_html = $product->get_rating_html();
        } else {
            $rating_html = wc_get_rating_html($product->get_average_rating());
        }

        if ($rating_html) :
        else :
            $rating_html = '<div class="star-rating" title="' . sprintf(__('Rated %s out of 5', 'electro'), 0) . '">';
            $rating_html .= '<span style="width:' . ((0 / 5) * 100) . '%"><strong class="rating">' . 0 . '</strong> ' . __('out of 5', 'electro') . '</span>';
            $rating_html .= '</div>';
        endif;
        $review_count = $product->get_review_count();
        ?>
        <div class="product-rating">
            <?php echo wp_kses_post($rating_html); ?> (<?php echo esc_html($review_count); ?>)
        </div>
        <?php

    }
}