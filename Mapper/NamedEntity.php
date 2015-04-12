<?php

namespace Bh\Mapper;

class NamedEntity extends Mapper
{
    // {{{ constructor
    public function __construct($pdo)
    {
        $this->addField(new Field('name', 'Text', 'Name', array('required' => true)));

        parent::__construct($pdo);
    }
    // }}}
}
