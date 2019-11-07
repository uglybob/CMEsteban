<?php

namespace CMEsteban\Lib;

abstract class Config
{
    // {{{ constructor
    public function __construct()
    {
        $this->settings['Path'] = realpath($this->settings['Path'] . "/../..");
        $this->settings['PathCme'] = str_replace($this->settings['Path'], '', realpath(__DIR__ . "/../.."));
    }
    // }}}

    // {{{ getSettings
    public function getSettings($setting = null)
    {
        $result = null;

        if (!is_null($setting)) {
            if (isset($this->settings[$setting])) {
                $result = $this->settings[$setting];
            } else {
                throw new \CMEsteban\Exception\CMEstebanException("unknown setting: $setting");
            }
        } else {
            $result = $this->settings;
        }

        return $result;
    }
    // }}}
    // {{{ getPage
    public function getPage($request, $path) {
        $page = null;

        if (isset($this->pages[$request])) {
            $pageClass = 'CMEsteban\Page\\' . $this->pages[$request];

            if (class_exists($pageClass)) {
                $page = new $pageClass($path);
            } else {
                throw new \CMEsteban\Exception\NotFoundException("Class does not exist: $pageClass");
            }
        }

        return $page;
    }
    // }}}
    // {{{ getTemplate
    public function getTemplate($page) {
        return new \CMEsteban\Page\Template\CME();
    }
    // }}}
    // {{{ getController
    public function getController() {
        return new \CMEsteban\Lib\Controller();
    }
    // }}}
}
