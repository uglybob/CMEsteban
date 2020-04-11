<?php

namespace CMEsteban\Page\Template;

use CMEsteban\Lib\Component;
use CMEsteban\CMEsteban;
use \CMEsteban\Page\Module\HTML;

class Template extends Component
{
    public function __construct()
    {
        CMEsteban::setTemplate($this);
    }
    protected $favicon = null;
    protected $stylesheets = [];
    protected $scripts = [];

    public function addStylesheet($stylesheet, $pathCme = false)
    {
        $stylesheet = $this->addPrefix($stylesheet, $pathCme);

        if (!in_array($stylesheet, $this->stylesheets)) {
            $this->stylesheets[] = $stylesheet;
        }
    }
    public function getStylesheets()
    {
        return $this->stylesheets;
    }
    public function addScript($script, $pathCme = false)
    {
        $script = $this->addPrefix($script, $pathCme);

        if (!in_array($script, $this->scripts)) {
            $this->scripts[] = $script;
        }
    }
    public function getScripts()
    {
        return $this->scripts;
    }
    protected function addPrefix($path, $pathCme = false)
    {
        $prefix = ($pathCme) ? $this->getSetup()->getSettings('PathCme') : '';

        return $prefix . $path;
    }
    public function getFavicon()
    {
        return $this->favicon;
    }

    public function render()
    {
        $page = $this->getPage();

        return $page->getContent('header') . $page->getContent('main') . $page->getContent('footer');
    }
}
