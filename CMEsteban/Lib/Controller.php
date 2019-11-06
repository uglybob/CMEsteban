<?php

namespace CMEsteban\Lib;

use CMEsteban\CMEsteban;
use CMEsteban\Entity\User;

class Controller
{
    // {{{ variables
    protected $request = null;
    protected $user = null;
    // }}}

    // {{{ getPageByRequest
    public function getPageByRequest($request)
    {
        $path = explode('/', $request);
        $request = $path[0];
        $page = CMEsteban::$setup->getPage($request, $path);

        if (!$page) {
            $text = Mapper::findOneBy('Text', ['page' => $request]);
            if (!is_null($text)) {
                $page = new \CMEsteban\Page\Text($path, $text);
            }

            if (!$page) {
                if (!($page = $this->hookGetPageByRequest($request, $path))) {
                    throw new \CMEsteban\Exception\NotFoundException("Page not found: $request");
                }
            }
        }

        if (
            $page
            && $page->isCacheable()
            && !CMEsteban::$setup->getSettings('DevMode')
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
    // {{{ getTexts
    public function getTexts()
    {
        return Mapper::findAll('Text');
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
