<?php

namespace CMEsteban\Page\Template;

abstract class Template
{
    // {{{ variables
    protected $favicon = null;
    protected $stylesheets = [];
    protected $scripts = [];
    protected $content = [];
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

    // {{{ addContent
    public function addContent($name, $content)
    {
        $this->content[$name] = $content;
    }
    // }}}

    // {{{ render
    public function render()
    {
        $rendered  = (isset($this->content['header'])) ? $this->content['header'] : '';
        $rendered .= (isset($this->content['main'])) ? $this->content['main'] : '';
        $rendered .= (isset($this->content['footer'])) ? $this->content['footer'] : '';

        return $rendered;
    }
    // }}}
}
