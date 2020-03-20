<?php

namespace CMEsteban\Page\Template;

use CMEsteban\CMEsteban;
use \CMEsteban\Page\Module\HTML;

class Template
{
    public function __construct()
    {
        CMEsteban::setTemplate($this);
    }
    protected $favicon = null;
    protected $stylesheets = [];
    protected $scripts = [];

    public function addStylesheet($stylesheet)
    {
        if (!in_array($stylesheet, $this->stylesheets)) {
            $this->stylesheets[] = $stylesheet;
        }
    }
    public function getStylesheets()
    {
        return $this->stylesheets;
    }
    public function addScript($script)
    {
        if (!in_array($script, $this->scripts)) {
            $this->scripts[] = $script;
        }
    }
    public function getScripts()
    {
        return $this->scripts;
    }
    public function getFavicon()
    {
        return $this->favicon;
    }

    public function render()
    {
        $page = CMEsteban::$page;

        return $page->getContent('header') . $page->getContent('main') . $page->getContent('footer');
    }
}
