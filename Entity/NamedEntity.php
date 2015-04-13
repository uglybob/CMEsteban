<?php

namespace Bh\Entity;

class NamedEntity extends Entity
{
    // {{{ variables
    protected $name;
    // }}}

    // {{{ setName
    public function setName($name) {
        $this->name = $name;
    }
    // }}}
    // {{{ getName
    public function getName() {
        return $this->name;
    }
    // }}}
}
