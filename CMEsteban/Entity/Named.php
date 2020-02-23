<?php

namespace CMEsteban\Entity;

/**
 * @MappedSuperclass
 **/
abstract class Named extends Entity
{
    /**
     * @Column(type="string", unique=true)
     **/
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
        return [\CMEsteban\Page\Module\Text::shortenString($this->getName(), 30)];
    }
    // }}}
}
