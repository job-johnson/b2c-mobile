<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite4be0c9997be10baeb2f21d33354a767
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        'd9125441b133fd6db28fee7fecef6d6a' => __DIR__ . '/..' . '/icecave/isolator/src/register-autoloader.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\Console\\' => 26,
        ),
        'J' => 
        array (
            'JsonSchema\\' => 11,
        ),
        'I' => 
        array (
            'Icecave\\Isolator\\' => 17,
        ),
        'E' => 
        array (
            'Eloquent\\Enumeration\\' => 21,
            'Eloquent\\Composer\\Configuration\\' => 32,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\Console\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/console',
        ),
        'JsonSchema\\' => 
        array (
            0 => __DIR__ . '/..' . '/justinrainbow/json-schema/src/JsonSchema',
        ),
        'Icecave\\Isolator\\' => 
        array (
            0 => __DIR__ . '/..' . '/icecave/isolator/src',
        ),
        'Eloquent\\Enumeration\\' => 
        array (
            0 => __DIR__ . '/..' . '/eloquent/enumeration/src',
        ),
        'Eloquent\\Composer\\Configuration\\' => 
        array (
            0 => __DIR__ . '/..' . '/eloquent/composer-config-reader/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'M' => 
        array (
            'MagentoHackathon\\Composer' => 
            array (
                0 => __DIR__ . '/..' . '/magento-hackathon/magento-composer-installer/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite4be0c9997be10baeb2f21d33354a767::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite4be0c9997be10baeb2f21d33354a767::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite4be0c9997be10baeb2f21d33354a767::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
