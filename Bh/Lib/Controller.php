<?php

namespace Bh\Lib;

class Controller
{
    // {{{ variables
    protected $request = null;
    protected $mapper = null;
    protected $namespaces = [];
    // }}}
    // {{{ constructor
    public function __construct()
    {
        $this->$namespaces[] = 'Bh';

        $this->mapper = new \Bh\Lib\Mapper();
        $this->logic = new \Bh\Content\Lib\Logic($this);
    }
    // }}}

    // {{{ registerNamespace
    public function registerNamespace($namespace)
    {
        $this->namespaces[] = $namespace;
    }
    // }}}
    // {{{ getClass
    public function getClass($subNamespace, $class)
    {
        $resultClass = null;
        $subClass = $subNamespace . '\\' . $class;

        foreach($this->namespaces as $namspace) {
            if (class_exists($candidateClass = '\\' . $namespace . '\\' . $subClass)) {
                $resultClass = $candidateClass;
                break;
            }
        }

        if (is_null($resultClass)) {
            throw new \Bh\Exceptions\BhException('Class "' . $class . '" doesn\'t exists.');
        }

        return $resultClass;
    }
    // }}}

    // {{{ getPage
    public function getPage($request)
    {
        $page = '\Bh\Content\Page\Home';
        $path = explode('/', $request);

        $handler = $this->mapper->getEntityManager()->getRepository('Bh\Entity\Page')->findOneBy(['request' => $path[0]]);
        if ($handler) {
            try {
                $page = $this->getClass('Page', $handler->getPage());
            } catch (\Bh\Exceptions\BhException $e) {}
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
}
