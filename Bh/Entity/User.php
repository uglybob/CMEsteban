<?php

namespace Bh\Entity;

class User extends Entity
{
    protected $email;
    protected $pass;
    protected $level;

    // {{{ constructor
    public function __construct()
    {
        parent::__construct();

        $this->level = 0;
    }
    // }}}

    // {{{ getPass
    protected function getPass()
    {
    }
    // }}}

    // {{{ authenticate
    public function authenticate($pass)
    {
        return sha1($pass) == $this->pass;
    }
    // }}}
}
