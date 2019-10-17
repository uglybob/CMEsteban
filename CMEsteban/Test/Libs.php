<?php

namespace CMEsteban\Lib;

use  CMEsteban\Page\Template\Template;

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

    public static function getController()
    {
        return new Controller();
    }

    public static function getTemplate($page)
    {
        return new Template();
    }
}
