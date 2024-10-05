<?php

namespace ElectroApp\Hooks;

class CategoryMenu
{

    public function __invoke()
    {
        add_shortcode('category_menu', [$this, 'getCategoryMenu']);
    }

    function getCategoryMenu(array $attributes)
    {

        // Extract shortcode attributes
        $attributes = shortcode_atts(
            [
                'menu' => '', // Default menu (can use menu name, slug, or ID)
                'container' => 'div', // Default container element for the menu (div, nav, etc.)
                'container_class' => '', // Default container class
                'menu_class' => 'menu', // Default class for the <ul> element
            ],
            $attributes,
            'category_menu'
        );

        // Check if the menu attribute is set, if not return an error message
        if (empty($attributes['menu'])) {
            return 'Please specify a menu name, slug, or ID.';
        }

        // Generate the menu HTML using wp_nav_menu
        $menu = wp_nav_menu(array(
            'menu' => $attributes['menu'], // Menu ID, slug, or name
            'container' => $attributes['container'], // Container element (div, nav, etc.)
            'container_class' => esc_attr($attributes['container_class']), // Class for container element
            'menu_class' => esc_attr($attributes['menu_class']), // Class for <ul> element
            'echo' => false
        ));

        // Return the menu HTML
        return $menu;

    }


}

