<?php

namespace CMEsteban\Page\Module;

abstract class Module
{
    protected $rendered;

    public function __construct()
    {
        $this->rendered = '';
    }

    public function __toString()
    {
        return $this->rendered;
    }
}
