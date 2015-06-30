<?php

namespace Bh\Lib;

class Controller
{
    // {{{ variables
    protected $request = null;
    protected $mapper = null;
    // }}}
    // {{{ constructor
    public function __construct()
    {
        $this->mapper = new Mapper($this);
        $this->logic = new Logic($this);
    }
    // }}}

    // {{{ getPage
    public function getPage($request)
    {
        $page = 'Bh\Page\Home';
        $path = explode('/', $request);

        $handler = $this->mapper->getEntityManager()->getRepository('Bh\Entity\Page')->findOneBy(['request' => $path[0]]);

        if ($handler) {
            $class = 'Bh\Page\\' . $handler->getPage();
            if (class_exists($class)) {
                $page = $class;
            }
        }

        return new $page($this, $path);
    }
    // }}}
    // {{{ getLogic
    public function getLogic()
    {
        return $this->logic;
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
}
