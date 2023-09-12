<?php

require_once __DIR__ . '/vendor/autoload.php';

use ElectroApp\Hooks\ThemeInitHook;

if (!\function_exists('getElectroThemeImageUrl')) {
    function getElectroThemeImageUrl(string $imageName): string
    {
        if (get_theme_file_path('assets/images/' . $imageName)) {
            return get_stylesheet_directory_uri() . '/assets/images/' . $imageName;
        } else {
            return '';
        }

    }
}
$instance = new ThemeInitHook();
$instance();
