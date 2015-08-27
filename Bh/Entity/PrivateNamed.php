<?php

namespace Bh\Entity;

class PrivateNamed extends PrivateEntity
{
    protected $name;

    // {{{ constructor
    public function __construct($user, $name)
    {
        parent::__construct($user);

        $this->name = $name;
    }
    // }}}
}
