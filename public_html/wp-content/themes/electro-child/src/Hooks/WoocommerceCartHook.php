<?php

namespace ElectroApp\Hooks;

class WoocommerceCartHook
{
    /**
     * @return void
     */
    public function __invoke(): void
    {
        remove_action('woocommerce_cart_is_empty', 'wc_empty_cart_message');

        add_action('woocommerce_cart_is_empty', [$this, 'newEmptyCard'], 8);
    }

    /**
     * Modify empty card
     * @return void
     */
    public function newEmptyCard(): void
    {

        $notice = wc_print_notice(
            wp_kses_post(
            /**
             * Filter empty cart message text.
             *
             * @param string $message Default empty cart message.
             * @return string
             * @since 3.1.0
             */
                apply_filters('wc_empty_cart_message', __('Your cart is currently empty.', 'woocommerce'))
            ),
            'notice',
            [],
            true
        );

        // This adds the cart-empty classname to the notice to preserve backwards compatibility (for styling purposes etc).
        $notice = str_replace('class="woocommerce-info"', '', $notice);

        // Return the notice within a consistent wrapper element. This is targetted by some scripts such as cart.js.
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        ?>
        <div class='wc-empty-cart-message row justify-content-center'>
            <div class='shopping-cart-section'>
                <img loading="lazy" src='<?= getElectroThemeImageUrl('empty-cart.svg') ?>'/>
            </div>
        </div>
        <div class="row">
            <div class="cart-empty-section">
                <?= $notice ?>
            </div>
        </div>
        <?php
    }

}