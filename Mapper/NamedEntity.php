<?php

namespace Bh\Mapper;

class NamedEntity extends Mapper
{
    // {{{ constructor
    public function __construct($controller)
    {
        $this->addField('name', 'Text', array('required' => true));

        parent::__construct($controller);
    }
    // }}}
}
