<?php

namespace CMEsteban\Lib;

class Setup
{
    public static function getSettings()
    {
        return [
            'Salt' => 'testSalt',
            'DevMode' => true,
            'DbHost' => 'localhost',
            'DbName' => $GLOBALS['DB_NAME'],
            'DbUser' => $GLOBALS['DB_USER'],
            'DbPass' => $GLOBALS['DB_PASS'],
        ];
    }
}
