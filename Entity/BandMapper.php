<?php

namespace BH\Entity;

class BandMapper extends Mapper
{
    // {{{ constructor
    public function __construct($pdo)
    {
        parent::__construct($pdo);

        $this->class    = 'BH\Entity\Band';
        $this->table    = 'Band';
        $this->columns  = array(
            'picture',
            'name',
            'description',
        );
    }
    // }}}
}
