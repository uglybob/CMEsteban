<?php

namespace Bh\Lib;

class Controller
{
    // {{{ variables
    protected $request = null;
    protected $mapper = null;
    protected $user = null;
    // }}}
    // {{{ constructor
    public function __construct()
    {
        $this->mapper = new Mapper($this);
    }
    // }}}

    // {{{ getPage
    public function getPage($request)
    {
        $page = 'Bh\Page\Home';
        $path = explode('/', $request);

        $handler = $this->mapper->findOneBy('Page', ['request' => $path[0]]);

        if ($handler) {
            $class = 'Bh\Page\\' . $handler->getPage();
            if (class_exists($class)) {
                $page = $class;
            }
        }

        return new $page($this, $path);
    }
    // }}}
    // {{{ getMapper
    public function getMapper()
    {
        return $this->mapper;
    }
    // }}}
    // {{{ getSettings
    public function getSettings()
    {
        return \Bh\Lib\Setup::getSettings();
    }
    // }}}

    // {{{ login
    public function login($email, $pass)
    {
        $result = false;
        $user = $this->mapper->getEntityManager()->getRepository('Bh\Entity\User')->findOneBy(['email' => $email]);

        if ($user->authenticate($pass)) {
            $_SESSION['userId'] = $user->getId();
            $result = true;
        }

        return $result;
    }
    // }}}
    // {{{ logoff
    public function logoff()
    {
        unset($_SESSION['userId']);
    }
    // }}}
    // {{{ getCurrentUser
    public function getCurrentUser()
    {
        $user = null;

        if (isset($_SESSION['userId'])) {
            $user = $this->getUser($_SESSION['userId']);
        }

        return $user;
    }
    // }}}
    // {{{ getUser
    public function getUser($id)
    {
        if (is_null($id)) {
            $user = null;
        } else { 
            $user = $this->mapper->find('User', $id);
        }

        return $user;
    }
    // }}}
    // {{{ getUsers
    public function getUsers()
    {
        return $this->mapper->findAll('User');
    }
    // }}}

    // {{{ save
    public function save($object)
    {
        $this->mapper->save($object);
    }
    // }}}
    // {{{ commit
    public function commit()
    {
        $this->mapper->commit();
    }
    // }}}
}
