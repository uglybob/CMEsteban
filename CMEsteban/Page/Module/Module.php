<?php

namespace CMEsteban\Page\Module;

abstract class Module
{
    protected $rendered;

    // {{{ constructor
    public function __construct()
    {
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
