<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4f3fb19137ae574debb7de7180aaa329
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SzwSuny\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SzwSuny\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4f3fb19137ae574debb7de7180aaa329::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4f3fb19137ae574debb7de7180aaa329::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
