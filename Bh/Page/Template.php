<?php

namespace Bh\Page;

class Template
{
    // {{{ variables
    protected $controller;
    protected $stylesheets = [];
    // }}}

    // {{{ constructor
    public function __construct($controller)
    {
        $this->controller = $controller;
    }
    // }}}

    // {{{ getStylesheets
    public function getStylesheets()
    {
        return $this->stylesheets;
    }
    // }}}

    // {{{ head
    public function head($head)
    {
        return $head;
    }
    // }}}
    // {{{ header
    public function header($header)
    {
        return $header;
    }
    // }}}
    // {{{ content
    public function content($content)
    {
        return $content;
    }
    // }}}
    // {{{ footer
    public function footer($footer)
    {
        return $footer;
    }
    // }}}
}
