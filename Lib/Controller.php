<?php

namespace Bh\Lib;

class Controller
{
    // {{{ variables
    protected $request = null;
    // }}}
    // {{{ constructor
    public function __construct($request)
    {
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
    // {{{ getLogic
    public function getLogic()
    {
        return $this->logic;
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
