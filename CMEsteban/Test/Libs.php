<?php

namespace CMEsteban\Lib;

class Setup
{
    public static function getSettings()
    {
        return [
            'DevMode' => true,
            'DbConn' => [
                'driver' => 'pdo_sqlite',
                'memory' => true,
            ]
        ];
    }
}
