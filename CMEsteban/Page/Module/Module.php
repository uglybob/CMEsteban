<?php

namespace CMEsteban\Page\Module;

use CMEsteban\Lib\Component;

abstract class Module extends Component
{
    protected $rendered;

    public function __construct()
    {
        $this->addScripts();
        $this->addStylesheets();

        $this->rendered = $this->render();
    }

    protected function addScripts()
    {
    }
    protected function addStylesheets()
    {
    }

    protected function render()
    {
        return '';
    }

    public function __toString()
    {
        return $this->rendered;
    }
    protected function addScript($script, $pathCme = false)
    {
        $this->getTemplate()->addScript($script, $pathCme);
    }
    protected function addStylesheet($stylesheet, $pathCme = false)
    {
        $this->getTemplate()->addStylesheet($stylesheet, $pathCme);
    }
}
