<?php

namespace CMEsteban\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Table(name="users")
 * @Entity
 **/
class User extends Named
{
    /**
     * @Column(type="string", unique=true)
     **/
    protected $email;
    /**
     * @Column(type="string")
     **/
    protected $pass;
    /**
     * @Column(type="integer")
     **/
    protected $level;

    public function __construct($name)
    {
        parent::__construct($name);

        $this->level = 1;
    }

    public function setEmail($email)
    {
        $this->email = strtolower($email);
    }

    protected function getPass()
    {
        return $this->pass;
    }
    public function setPass($pass)
    {
        $this->setPassHash($this->hash($pass));
    }
    public function setPassHash($hash)
    {
        $this->pass = $hash;
    }

    protected function hash($pass)
    {
        return password_hash($pass, PASSWORD_DEFAULT);
    }
    public function authenticate($pass)
    {
        return password_verify($pass, $this->getPass());
    }
}
