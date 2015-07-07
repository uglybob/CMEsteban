<?php

namespace Bh\Lib;

class Setup
{
    public static function getSettings()
    {
        return [
            'MapperPath'    => __DIR__ . '/../Mapper/',
            'DbHost'        => 'localhost',
            'DbName'        => 'bh_test',
            'DbUser'        => 'bh_test',
            'DbPass'        => 'bh_test_pass',
        ];
    }
}

class Logic
{
}
