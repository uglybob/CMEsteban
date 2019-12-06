<?php

namespace CMEsteban\Entity;

abstract class Named extends Entity
{
    protected $name;

    // {{{ constructor
    public function __construct($name)
    {
        parent::__construct();

        $this->name = $name;
    }
    // }}}
    // {{{ toString
    public function __toString()
    {
        return $this->name;
    }
    // }}}

    // {{{ getHeadings
    public static function getHeadings()
    {
        return ['Name'];
    }
    // }}}
    // {{{ getRow
    public function getRow()
    {
        return [$this->getName()];
    }
    // }}}
}
