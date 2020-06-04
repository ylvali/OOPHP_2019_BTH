<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit71ae6ccf84097464928f76e940c42bb0
{
    public static $prefixLengthsPsr4 = array (
        'Y' => 
        array (
            'Ylva\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ylva\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit71ae6ccf84097464928f76e940c42bb0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit71ae6ccf84097464928f76e940c42bb0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
