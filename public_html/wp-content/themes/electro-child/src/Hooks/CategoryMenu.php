<?php

declare(strict_types=1);

namespace ElectroApp\Hooks;

class CategoryMenu
{

    /**
     * @return void
     */
    public function __invoke(): void
    {
        add_shortcode('category_menu', [$this, 'getCategoryMenu']);
        add_action('after_setup_theme', [$this, 'lowerMenuSetup']);
        add_action('wp_footer', [$this, 'renderLowerMenu']);
    }

    /**
     * @return void
     */
    public function lowerMenuSetup(): void
    {
        register_nav_menus(
            [
                'lower-short-menu' => __('Lower Short Menu', 'astra'),
            ]
        );
    }

    /**
     * @param array $attributes
     * @return string
     */
    public function getCategoryMenu(array $attributes): string
    {
        $attributes = shortcode_atts(
            [
                'menu' => '',
                'container' => 'div',
                'container_class' => '',
                'menu_class' => 'menu',
            ],
            $attributes,
            'category_menu'
        );


        if (empty($attributes['menu'])) {
            return 'Please specify a menu name, slug, or ID.';
        }

        return wp_nav_menu([
            'menu' => $attributes['menu'],
            'container' => $attributes['container'],
            'container_class' => esc_attr($attributes['container_class']),
            'menu_class' => esc_attr($attributes['menu_class']),
            'echo' => false
        ]);

    }


    /**
     * @return void
     */
    public function renderLowerMenu(): void
    {
        if (has_nav_menu('lower-short-menu') && wp_is_mobile()) {
            wp_nav_menu(
                [
                    'theme_location' => 'lower-short-menu',
                    'container' => 'nav',
                    'container_class' => 'lower-short-menu-container',
                    'menu_class' => 'lower-short-menu',
                    'echo' => true,
                ]
            );
        }
    }
}

