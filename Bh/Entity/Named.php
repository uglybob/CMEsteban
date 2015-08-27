<?php

namespace Bh\Entity;

class Named extends Entity
{
    protected $name;

    // {{{ constructor
    public function __construct($name)
    {
        parent::__construct();

        $this->name = $name;
    }
    // }}}
}
