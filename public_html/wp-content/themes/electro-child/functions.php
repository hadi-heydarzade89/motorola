<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('electro-child-theme', get_stylesheet_uri());
}, 100);