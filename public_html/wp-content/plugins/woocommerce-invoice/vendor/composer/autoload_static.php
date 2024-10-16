<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit100b08ffa5376c77c4edf9138e0bc7c6
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '33ccceeec969bc0d99c4a43b84d83d8a' => __DIR__ . '/../..' . '/includes/class-core.php',
        'b7489548fe09fdd6e54fe3b7ddaa7821' => __DIR__ . '/../..' . '/includes/class-dokan.php',
        'f1caac9311bb1da0d012b7ca8505e0ee' => __DIR__ . '/../..' . '/includes/class-hooks.php',
        '1ff203ffcb51f4f392fdb36b97c21202' => __DIR__ . '/../..' . '/includes/class-install.php',
        '9a388fb9612c455bedbec067c742185c' => __DIR__ . '/../..' . '/includes/class-license.php',
        'e21d3fb025fbf8658348949b63d67cce' => __DIR__ . '/../..' . '/includes/class-page.php',
        'b890120371623aa2b90b6cb83af8ca02' => __DIR__ . '/../..' . '/includes/class-posttype.php',
        '7325ae06af3137448759c8b9cad2a402' => __DIR__ . '/../..' . '/includes/class-tapin.php',
        '314ea7921ac2104fd7de12a79bf075c4' => __DIR__ . '/../..' . '/includes/class-update.php',
        '19dc0808183b02c9e6fdd420cb973c7a' => __DIR__ . '/../..' . '/includes/class-version.php',
        '79667749ed3ce80089a399fc6e1fd564' => __DIR__ . '/../..' . '/includes/functions.php',
        'e4ac68adefed40bd775624ad73b791b8' => __DIR__ . '/../..' . '/includes/admin/class-admin.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twig\\' => 5,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Ctype\\' => 23,
        ),
        'P' => 
        array (
            'Picqer\\Barcode\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twig\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/twig/src',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Picqer\\Barcode\\' => 
        array (
            0 => __DIR__ . '/..' . '/picqer/php-barcode-generator/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit100b08ffa5376c77c4edf9138e0bc7c6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit100b08ffa5376c77c4edf9138e0bc7c6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit100b08ffa5376c77c4edf9138e0bc7c6::$classMap;

        }, null, ClassLoader::class);
    }
}
