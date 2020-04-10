<?php

namespace CMEsteban\Page\Module;

use CMEsteban\Lib\Component;

abstract class Module extends Component
{
    protected $rendered;

    public function __construct()
    {
        $this->rendered = $this->render();
    }

    public function rendere()
    {
        return '';
    }

    public function __toString()
    {
        return $this->rendered;
    }
}
