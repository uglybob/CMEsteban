<?php

namespace CMEsteban\Entity;

use CMEsteban\Page\Page;

/**
 * @MappedSuperclass
 **/
abstract class PrivateNamed extends PrivateEntity
{
    /**
     * @Column(type="string", unique=true)
     **/
    protected $name;

    // {{{ constructor
    public function __construct(User $user, $name)
    {
        parent::__construct($user);

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
