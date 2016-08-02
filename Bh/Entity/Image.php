<?php

namespace Bh\Entity;

class Image extends Named
{
    protected $alt;
    protected $path;

    // {{{ constructor
    public function __construct($name)
    {
        parent::__construct($name);
    }
    // }}}
}
