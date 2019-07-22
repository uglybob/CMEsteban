<?php

namespace CMEsteban\Lib;

class Setup
{
    public static function getSettings()
    {
        return [
            'Salt' => 'testSalt',
            'DevMode' => true,
            'DbConn' => [
                'driver' => 'pdo_sqlite',
                'path' => __DIR__ . '/test.sqlite',
            ]
        ];
    }
}
