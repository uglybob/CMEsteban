<?php

namespace CMEsteban\Lib;

use  CMEsteban\Page\Template\Template;

class Setup extends Config
{
    public $testController = null;

    protected $settings = [
        'Path' => __DIR__,
        'DevMode' => true,
        'CacheTime' => 1800,
        'DbConn' => [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ],
        'pages' => [
            'home' => 'Home',
        ],
    ];

    public function instantiateController()
    {
        if ($this->testController) {
            return $this->testController;
        } else {
            return new Controller();
        }
    }

    public function instantiateTemplate($page)
    {
        return new Template();
    }
}
