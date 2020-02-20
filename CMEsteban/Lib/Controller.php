<?php

namespace CMEsteban\Lib;

use CMEsteban\CMEsteban;
use CMEsteban\Entity\User;

class Controller
{
    // {{{ variables
    protected $pageGetters = [];
    // }}}
    // {{{ constructor
    public function __construct()
    {
        $this->pageGetters = ['getPageDefault', 'getPageText'];
    }
    // }}}

    // {{{ getPage
    public function getPage($request)
    {
        $path = explode('/', $request);
        $request = $path[0];
        $page = null;
        $rendered = null;
        $cache = (!$this->getCurrentUser() && !CMEsteban::$setup->getSettings('DevMode'));

        if ($cache) {
            $index = implode('-', $path) . '.html';
            $rendered = Cache::get($index);
        }

        if (!$rendered) {
            while (is_null($page) && !empty($this->pageGetters)) {
                $getter = array_shift($this->pageGetters);
                $page = $this->$getter($request, $path);
            }

            if (!$page) {
                throw new \CMEsteban\Exception\NotFoundException("Page not found: $request");
            } else {
                $rendered = $page->render();

                if ($cache && $page->isCacheable()) {
                    Cache::set($index, $rendered);
                }
            }
        }

        return $rendered;
    }
    // }}}
    // {{{ getPageDefault
    public function getPageDefault($request, $path) {
        $page = null;
        $pages = CMEsteban::$setup->getSettings('pages');

        if (isset($pages[$request])) {
            $pageClass = 'CMEsteban\Page\\' . $pages[$request];

            if (class_exists($pageClass)) {
                $page = new $pageClass($path);
            } else {
                throw new \CMEsteban\Exception\NotFoundException("Page does not exist: $pageClass");
            }
        }

        return $page;
    }
    // }}}
    // {{{ getPageText
    public function getPageText($request, $path)
    {
        $page = null;
        $text = Mapper::findOneBy('Text', ['link' => $request]);

        if (!is_null($text)) {
            $page = new \CMEsteban\Page\Text($path, $text);
        }

        return $page;
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
    public function getImages($showHidden = false)
    {
        $this->access(1);

        return Mapper::findAll('Image', $showHidden);
    }
    // }}}

    // {{{ getText
    public function getText($id)
    {
        return Mapper::findOneBy(
            'Text',
            [
                'id' => $id,
            ]
        );
    }
    // }}}
    // {{{ getTextByLink
    public function getTextByLink($link)
    {
        return Mapper::findOneBy(
            'Text',
            [
                'link' => $link,
            ]
        );
    }
    // }}}
    // {{{ getTexts
    public function getTexts($showHidden = false)
    {
        $this->access(1);

        return Mapper::findAll('Text', $showHidden);
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

        try {
            if (is_null($newId)) {
                Mapper::save($newUser);
                Mapper::commit();
                $result = true;
            } elseif ($currentUser && $currentUser->getId() === $newId) {
                if (!$newUser->getPass()) {
                    $newUser->setPassHash($currentUser->getPass());
                }

                $currentUser = $newUser;
                Mapper::save($newUser);
                Mapper::commit();
                $result = true;
            }
        } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {}

        return $result;
    }
    // }}}
}
