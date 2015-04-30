<?php

namespace Bh\Lib;

class Controller
{
    // {{{ variables
    protected $request = null;
    // }}}
    // {{{ constructor
    public function __construct()
    {
        $this->logic = new \Bh\Content\Lib\Logic($this);
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
    public function getPage($request)
    {
        $page = '\Bh\Content\Page\Home';
        $path = explode('/', $request);

        $handlers = \Bh\Mapper\Mapper::getAllWhere('Page', ['request' => $path[0]]);
        if (isset($handlers[0])) {
            try {
                $page = $this->getClass('Page', $handlers[0]->page);
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
