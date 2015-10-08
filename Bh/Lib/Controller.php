<?php

namespace Bh\Lib;

use Bh\Entity\User;

class Controller
{
    // {{{ variables
    protected $request = null;
    protected $user = null;
    // }}}

    // {{{ getPage
    public function getPage($id)
    {
        if (is_null($id)) {
            $page = null;
        } else {
            $page = Mapper::find('Page', $id);
        }

        return $page;
    }
    // }}}
    // {{{ getPageByRequest
    public function getPageByRequest($request)
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
    // {{{ getPages
    public function getPages()
    {
        $pages = [];

        if ($this->access(5)) {
            $pages = Mapper::findAll('Page');
        }

        return $pages;
    }
    // }}}
    // {{{ editPage
    public function editPage($page)
    {
        if ($this->access(5)) {
            if (is_null($page->getId())) {
                Mapper::save($page);
            }

            Mapper::commit();
        }
    }
    // }}}

    // {{{ login
    public function login($email, $pass)
    {
        $result = false;
        $user = Mapper::findOneBy('User', ['email' => strtolower($email)]);

        if ($user && $user->authenticate($pass)) {
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
    // {{{ access
    public function access($level)
    {
        $result = false;
        $user = $this->getCurrentUser();

        if (
            ($level === 0)
            || ($user && $user->getLevel() >= $level))
        {
            $result = true;
        } else {
            throw new \Bh\Exception\AccessException("Access denied. Minimum access level: $level.");
        }

        return $result;
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
    // {{{ getUserByEmail
    public function getUserByEmail($email)
    {
        $user = Mapper::findOneBy(
            'User',
            [
                'email' => $email,
            ]
        );

        return $user;
    }
    // }}}
    // {{{ editUser
    public function editUser(User $user)
    {
        if (!$this->getUserByEmail($user->getEmail())) {
            $id = $user->getId();
            $currentUser = $this->getCurrentUser();

            if (is_null($id)) {
                $newUser = new User();
                $newUser->copyPass($user->getPass());
                Mapper::save($newUser);
            } elseif (
                $currentUser && $id === $currentUser()->getId()
            ) {
                $newUser = $currentUser();
                if ($user->getPass()) {
                    $newUser->copyPass($user->getPass);
                }
            }

            $newUser->setEmail($user->getEmail());

            Mapper::commit();
        }
    }
    // }}}
}
