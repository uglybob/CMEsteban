<?php

namespace Bh\Lib;

class Setup
{
    public static function getSettings()
    {
        return [
            'DevMode' => true,
            'MapperPath' => __DIR__ . '/../Mapper/',
            'DbHost' => 'localhost',
            'DbName' => $GLOBALS['DB_NAME'],
            'DbUser' => $GLOBALS['DB_USER'],
            'DbPass' => $GLOBALS['DB_PASS'],
        ];
    }
}
