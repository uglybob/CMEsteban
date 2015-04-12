<?php

namespace Bh\Lib;

class Controller
{
    // {{{ variables
    protected $setup = array();
    protected $pdo = null;
    protected $request = null;
    // }}}
    // {{{ constructor
    public function __construct($request)
    {
        $this->setup = (new Setup())->setup;
        $this->logic = new \Bh\Content\Lib\Logic($this);
        $this->handleRequest($request);
    }
    // }}}

    // {{{ handleRequest
    protected function handleRequest($request)
    {
        if (is_null($request)) {
            $this->request = 'Home';
        } else {
            $this->request = $request;
        }
    }
    // }}}
    // {{{ getClass
    public function getClass($namespace, $class)
    {
        $resultClass = null;
        $subClass = $namespace . '\\' . $class;

        if (class_exists($bhClass = '\Bh\\' . $subClass)) {
            $resultClass = $bhClass;
        } elseif (class_exists($contentClass = '\Bh\Content\\' . $subClass)) {
            $resultClass = $contentClass;
        }

        return $resultClass;
    }
    // }}}

    // {{{ getPage
    public function getPage($request = null)
    {
        if (is_null($request)) {
            $request = $this->request;
        }

        $path = explode('/', $request);
        $params = array();
        $pageClass = array_shift($path);
        $page = $this->getClass('Page', $pageClass);

        return new $page($this, $path);
    }
    // }}}
    // {{{ getMapper
    public function getMapper($class)
    {
        $mapper = $this->getClass('Mapper', $class);

        return new $mapper($this->getPdo());
    }
    // }}}
    // {{{ getLogic
    public function getLogic()
    {
        return $this->logic;
    }
    // }}}
    // {{{ getPdo
    protected function getPdo()
    {
        if (!$this->pdo) {
            $this->pdo = new \PDO(
                'mysql:host=' . $this->setup['DbHost'] . ';dbname=' . $this->setup['DbName'],
                $this->setup['DbUser'],
                $this->setup['DbPass']
            );
        }

        return $this->pdo;
    }
    // }}}

    // {{{ connectToFacebook
    /* todo
    protected function connectToFacebook()
    {
        $this->facebook = new Bh\Lib\Facebook(
            $this->setup['FbClientId'],
            $this->setup['FbClientSecret']
        );
    }
    */
    // }}}
}
