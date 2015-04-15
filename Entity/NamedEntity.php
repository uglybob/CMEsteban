<?php

namespace Bh\Entity;

class NamedEntity extends Dao
{
    // {{{ constructor
    public function __construct()
    {
        $this->addField('name', 'Text', ['required' => true]);
    }
    // }}}
}
