<?php

namespace CMEsteban\Page\Template;

use CMEsteban\CMEsteban;
use \CMEsteban\Page\Module\HTML;

class Template
{
    // {{{ constructor
    public function __construct()
    {
        CMEsteban::setTemplate($this);
    }
    // }}}
    // {{{ variables
    protected $favicon = null;
    protected $stylesheets = [];
    protected $scripts = [];
    // }}}

    // {{{ addStylesheet
    public function addStylesheet($stylesheet)
    {
        if (!in_array($stylesheet, $this->stylesheets)) {
            $this->stylesheets[] = $stylesheet;
        }
    }
    // }}}
    // {{{ getStylesheets
    public function getStylesheets()
    {
        return $this->stylesheets;
    }
    // }}}
    // {{{ addScript
    public function addScript($script)
    {
        if (!in_array($script, $this->scripts)) {
            $this->scripts[] = $script;
        }
    }
    // }}}
    // {{{ getScripts
    public function getScripts()
    {
        return $this->scripts;
    }
    // }}}
    // {{{ getFavicon
    public function getFavicon()
    {
        return $this->favicon;
    }
    // }}}

    // {{{ render
    public function render()
    {
        $page = CMEsteban::$page;

        return $page->getContent('header') . $page->getContent('main') . $page->getContent('footer');
    }
    // }}}
}
