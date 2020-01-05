<?php

namespace CMEsteban\Entity;

/**
 * @MappedSuperclass
 **/
abstract class PrivateEntity extends Entity
{
    /**
     * @ManyToOne(targetEntity="CMEsteban\Entity\User")
     **/
    protected $user;

    // {{{ constructor
    public function __construct($user)
    {
        parent::__construct();

        $this->user = $user;
    }
    // }}}
    // {{{ setUser
    private function setUser() {}
    // }}}
}
