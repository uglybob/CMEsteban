<?php

namespace Bh\Lib;

class Controller
{
    protected $setup = array();
    protected $pdo = null;
    protected $request = null;

    // {{{ constructor
    public function __construct($request)
    {
        $this->setup = (new Setup())->setup;
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

    // {{{ getPage
    public function getPage($request = null)
    {
        if (is_null($request)) {
            $request = $this->request;
        }

        $path = explode('/', $request);
        $params = array();
        $pageClass = array_shift($path);

        if (class_exists($bhPage = '\Bh\Page\\' . $pageClass)) {
            $page = $bhPage;
        } elseif (class_exists($contentPage = '\Bh\Content\Page\\' . $pageClass)) {
            $page = $contentPage;
        }

        return new $page($this, $path);
    }
    // }}}
    // {{{ getMapper
    public function getMapper($class)
    {
        $classMapper = '\Bh\Entity\\' . $class . 'Mapper';

        if (!class_exists($classMapper)) {
            throw new \Bh\Exceptions\InvalidClassException('Class ' . $class . ' doesn\'t have a mapper');
        }

        return new $classMapper($this->getPdo());
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
