<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit066a7ea1dc7edc310bd321fc293db7a2
{
    public static $prefixLengthsPsr4 = array (
        'x' => 
        array (
            'xCORE\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'xCORE\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Gamajo_Template_Loader' => __DIR__ . '/..' . '/gamajo/template-loader/class-gamajo-template-loader.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit066a7ea1dc7edc310bd321fc293db7a2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit066a7ea1dc7edc310bd321fc293db7a2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit066a7ea1dc7edc310bd321fc293db7a2::$classMap;

        }, null, ClassLoader::class);
    }
}
