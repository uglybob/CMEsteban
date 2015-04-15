<?php

namespace Bh\Lib;

class Controller
{
    // {{{ variables
    protected $setup = [];
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
    public static function getClass($namespace, $class)
    {
        $resultClass = null;
        $subClass = $namespace . '\\' . $class;

        if (class_exists($bhClass = '\Bh\\' . $subClass)) {
            $resultClass = $bhClass;
        } elseif (class_exists($contentClass = '\Bh\Content\\' . $subClass)) {
            $resultClass = $contentClass;
        } else {
            throw new \Bh\Exceptions\BhException('Class "' . $class . '" doesn\'t exists.');
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
        $params = [];
        $pageClass = array_shift($path);
        $page = $this->getClass('Page', $pageClass);

        return new $page($this, $path);
    }
    // }}}
    // {{{ getMapper
    public static function getMapper($class)
    {
        return new \Bh\Mapper\Mapper($this->getPdo());
    }
    // }}}
    // {{{ getLogic
    public function getLogic()
    {
        return $this->logic;
    }
    // }}}
    // {{{ getPdo
    public function getPdo()
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
