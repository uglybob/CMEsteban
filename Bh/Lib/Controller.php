<?php

namespace Bh\Lib;

class Controller
{
    // {{{ variables
    protected $request = null;
    protected $user = null;
    // }}}

    // {{{ getPage
    public function getPage($request)
    {
        $page = 'Bh\Page\Home';
        $path = explode('/', $request);

        $handler = Mapper::findOneBy('Page', ['request' => $path[0]]);

        if ($handler) {
            $class = 'Bh\Page\\' . $handler->getPage();
            if (class_exists($class)) {
                $page = $class;
            }
        }

        return new $page($this, $path);
    }
    // }}}

    // {{{ login
    public function login($email, $pass)
    {
        $result = false;
        $user = Mapper::findOneBy('User', ['email' => $email]);

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
            $user = Mapper::find('User', $id);
        }

        return $user;
    }
    // }}}
    // {{{ editUser
    public function editUser(User $user)
    {
        $id = $user->getId();
        $currentUser = $this->getCurrentUser();

        if (is_null($id)) {
            $newUser = new User();
            $newUser->setPass($user->getPass());
            $this->save($newUser);
        } elseif (
            $currentUser
            && $id === $currentUser()->getId()
        ) {
            $newUser = $currentUser();
            if ($user->getPass()) {
                $newUser->setPass($user->getPass);
            }
        }

        $this->commit();
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
