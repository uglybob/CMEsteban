<?php

namespace CMEsteban\Entity;

class User extends Named
{
    protected $email;
    protected $pass;
    protected $level;

    // {{{ constructor
    public function __construct($name)
    {
        parent::__construct($name);

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
        $this->setPassHash($this->hash($pass));
    }
    // }}}
    // {{{ setPassHash
    public function setPassHash($hash)
    {
        $this->pass = $hash;
    }
    // }}}

    // {{{ hash
    protected function hash($pass)
    {
        $settings = \CMEsteban\Lib\Setup::getSettings();
        $salt = $settings['Salt'];
        return sha1($salt . $this->name . $pass);
    }
    // }}}
    // {{{ authenticate
    public function authenticate($pass)
    {
        return $this->hash($pass) == $this->pass;
    }
    // }}}
}
