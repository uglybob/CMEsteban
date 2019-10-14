<?php

namespace CMEsteban\Page\Module;

abstract class Module
{
    protected $page;
    protected $rendered;

    // {{{ constructor
    public function __construct($page)
    {
        $this->page = $page;
        $this->rendered = '';
    }
    // }}}

    // {{{ toString
    public function __toString()
    {
        return $this->rendered;
    }
    // }}}
}
