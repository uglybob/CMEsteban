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

        $this->level = 1;
    }
    // }}}

    // {{{ setEmail
    public function setEmail($email)
    {
        $this->email = strtolower($email);
    }
    // }}}

    // {{{ getPass
    protected function getPass()
    {
    }
    // }}}
    // {{{ setPass
    public function setPass($pass)
    {
        $this->pass = $this->hash($pass);
    }
    // }}}
    // {{{ copyPass
    public function copyPass($pass)
    {
        $this->pass = $pass;
    }
    // }}}

    // {{{ hash
    protected function hash($pass)
    {
        $settings = \Bh\Lib\Setup::getSettings();
        $salt = $settings['Salt'];
        return sha1($salt . $this->email . $pass);
    }
    // }}}
    // {{{ authenticate
    public function authenticate($pass)
    {
        return $this->hash($pass) == $this->pass;
    }
    // }}}

    // {{{ toString
    public function __toString()
    {
        return $this->email;
    }
    // }}}
}
