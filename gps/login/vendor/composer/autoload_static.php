<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7fa0952c3bacb8bf61b51a4f224cc2e0
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7fa0952c3bacb8bf61b51a4f224cc2e0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7fa0952c3bacb8bf61b51a4f224cc2e0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
