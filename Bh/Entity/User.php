<?php

namespace Bh\Entity;

class User extends Entity
{
    protected $email;
    protected $pass;
    protected $level;

    protected function getPass()
    {
    }

    public function authenticate($pass)
    {
        return sha1($pass) == $this->pass;
    }
}
