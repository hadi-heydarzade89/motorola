<?php

namespace ElectroApp\Hooks;
class ThemeInitHook
{

    /**
     * @var array
     */
    private array $classes = [
        ShopPageOrderByHook::class,
        WoocommerceCartHook::class,
        ShopPageRatingHook::class,
    ];


    /**
     * @return void
     */
    public function __invoke(): void
    {
        $detect = new \Detection\MobileDetect;


        $this->removeHooks();


        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_style('electro-child-theme', get_stylesheet_uri(),[],'0.3.5');
        }, 200);
        add_action('electro_shop_control_bar', function () {
        }, 40);

        if (!$detect->isMobile()) {
            add_action('electro_shop_control_bar', function () {
                if (!electro_is_prdctfltr_activated()) {
                    woocommerce_result_count();
                }
            }, 40);
        }
        $this->otherHooks();
    }

    private function otherHooks(): void
    {

        foreach ($this->classes as $class) {
            $instance = new $class;
            $instance();
        }
    }

    private function removeHooks(): void
    {
        add_action('init', function () {
            remove_action('woocommerce_before_shop_loop', 'electro_wc_loop_title', 10);
            remove_action('electro_shop_control_bar', 'electro_wc_products_per_page', 30);
            remove_action('electro_shop_control_bar', 'electro_advanced_pagination', 40);
//        remove_action('woocommerce_after_shop_loop_item_title' , 'electro_template_loop_product_excerpt',  80);
//        remove_action('woocommerce_shop_loop_item_title' ,'electro_template_loop_categories',  50);
//        remove_action('woocommerce_after_shop_loop_item_title' , 'electro_template_loop_product_sku',  90);
            remove_action('woocommerce_after_shop_loop_item_title', 'electro_template_loop_rating', 70);
            remove_action('electro_loop_action_buttons', 'electro_add_to_wishlist_button');
            remove_filter('woocommerce_loop_add_to_cart_link', 'electro_wrap_add_to_cart_link', 90, 2);
            remove_action('woocommerce_shop_loop_item_title', 'electro_template_loop_categories', 50);
        });
    }
}