<?php

namespace Bh\Lib;

class Setup
{
    protected static $settings = [
        'FbClientId'        => '301342600012086',
        'FbClientSecret'    => '6e67e23801abfd658d52b347c08eb8f1',
        'DbHost'            => 'localhost',
        'DbName'            => 'bh3_db',
        'DbUser'            => 'bh3_user',
        'DbPass'            => 'siD87ddSD821',
    ];

    public static function getSettings()
    {
        return self::$settings;
    }
}
