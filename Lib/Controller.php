<?php

namespace BH\Lib;

class Controller
{
    protected $setup    = array();
    protected $pdo      = null;
    protected $facebook = null;

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
        if ($request === null) {
            $this->request = 'Home';
        } else {
            $this->request = $request;
        }
    }
    // }}}

    // {{{ getPage
    public function getPage($request = null)
    {
        if ($request === null) {
            $request = $this->request;
        }

        $path   = explode('/', $request);
        $params = array();
        $page   = '';

        while (!empty($path) && !class_exists($page)) {
            $page = '\BH\Page\\' . implode('', $path);
            array_unshift($params, array_pop($path));
        }

        array_shift($params);

        return new $page($this, $params);
    }
    // }}}
    // {{{ getMapper
    public function getMapper($class)
    {
        $classMapper = '\BH\Entity\\' . $class . 'Mapper';

        if (!class_exists($classMapper)) {
            throw new \BH\Exceptions\InvalidClassException('Class ' . $class . ' doesn\'t have a mapper');
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
    protected function connectToFacebook()
    {
        $this->facebook = new BH\Lib\Facebook(
            $this->setup['FbClientId'],
            $this->setup['FbClientSecret']
        );
    }
    // }}}
}
