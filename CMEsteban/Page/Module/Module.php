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

    protected function render()
    {
        return '';
    }

    public function __toString()
    {
        return $this->rendered;
    }
    protected function addStylesheet($stylesheet, $pathCme = false)
    {
        $this->getTemplate()->addStylesheet($stylesheet, $pathCme);
    }
    protected function addScript($script, $pathCme = false)
    {
        $this->getTemplate()->addScript($script, $pathCme);
    }
}
