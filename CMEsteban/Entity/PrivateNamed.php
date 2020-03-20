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

    public function __construct(User $user, $name)
    {
        parent::__construct($user);

        $this->name = $name;
    }
    public function __toString()
    {
        return $this->name;
    }

    public static function getHeadings()
    {
        return ['Name'];
    }
    public function getRow()
    {
        return [$this->getName()];
    }
}
