<?php

namespace CMEsteban\Lib;

use CMEsteban\Entity\User;

class Controller
{
    // {{{ variables
    protected $request = null;
    protected $user = null;
    // }}}

    // {{{ getPage
    public function getPage($id)
    {
        return (is_null($id)) ? null : Mapper::find('Page', $id);
    }
    // }}}
    // {{{ getPageByRequest
    public function getPageByRequest($request)
    {
        $page = null;
        $path = explode('/', $request);
        $request = $path[0];

        $handler = Mapper::findOneBy('Page', [
            'request' => $request,
            'deleted' => false
        ]);

        if ($handler) {
            $pageClass = 'CMEsteban\Page\\' . $handler->getPage();
            if (class_exists($pageClass)) {
                $page = new $pageClass($this, $path);
            } else {
                throw new \CMEsteban\Exception\NotFoundException("Class does not exist: $pageClass");
            }
        } else {
            if (!($page = $this->hookGetPageByRequest($request, $path))) {
                throw new \CMEsteban\Exception\NotFoundException("Page not found: $request");
            }
        }

        if (
            $page
            && $page->isCacheable()
            && !$this->getCurrentUser()
        ) {
            $index = implode('-', $path) . '.html';
            $rendered = Cache::get($index);

            if (!$rendered) {
                $rendered = $page->render();
                Cache::set($index, $rendered);
            }
        } else {
            $rendered = $page->render();
        }

        return $rendered;
    }
    // }}}
    // {{{ hookGetPageByRequest
    public function hookGetPageByRequest($request, $path)
    {
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

    // {{{ getImage
    public function getImage($id)
    {
        if (is_null($id)) {
            $image = null;
        } else {
            $image = Mapper::find('Image', $id);
        }

        return $image;
    }
    // }}}
    // {{{ getImages
    public function getImages()
    {
        $pages = [];

        if ($this->access(1)) {
            $pages = Mapper::findAll('Image');
        }

        return $pages;
    }
    // }}}

    // {{{ login
    public function login($name, $pass)
    {
        $result = false;
        $user = $this->getUserByName($name);

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
            throw new \CMEsteban\Exception\AccessException("Access denied. Minimum access level: $level.");
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
    // {{{ getUserByName
    public function getUserByName($name)
    {
        return Mapper::findOneBy('User', ['name' => $name]);
    }
    // }}}
    // {{{ getUserByEmail
    public function getUserByEmail($email)
    {
        return Mapper::findOneBy('User', ['email' => strtolower($email)]);
    }
    // }}}
    // {{{ editUser
    public function editUser(User $newUser)
    {
        $result = false;
        $newId = $newUser->getId();
        $currentUser = $this->getCurrentUser();

        if (is_null($newId)) {
            Mapper::save($newUser);
            Mapper::commit();
            $result = true;
        } elseif ($currentUser && $currentUser->getId() === $newId) {
            if (!$newUser->getPass()) {
                $newUser->copyPass($currentUser->getPass());
            }

            $currentUser = $newUser;
            Mapper::save($newUser);
            Mapper::commit();
            $result = true;
        }

        return $result;
    }
    // }}}
}
