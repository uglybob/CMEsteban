<?php

namespace CMEsteban\Lib;

use  CMEsteban\Page\Template\Template;

class Setup extends Config
{
    public $testController = null;
    protected $settings = [
        'Path' => __DIR__,
        'DevMode' => true,
        'DbConn' => [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ]
    ];

    public function getController()
    {
        if ($this->testController) {
            return $this->testController;
        } else {
            return new Controller();
        }
    }

    public function getTemplate($page)
    {
        return new Template();
    }
}
