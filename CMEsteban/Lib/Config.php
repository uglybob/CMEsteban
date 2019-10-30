<?php

namespace CMEsteban\Lib;

abstract class Config
{
    // {{{ getSettings
    public function getSettings($setting = null)
    {
        $result = null;
        $settings = $this->settings;
        $settings['Path'] = realpath($settings['Path'] . "/../..") . '/';

        if (!is_null($setting)) {
            if (isset($settings[$setting])) {
                $result = $settings[$setting];
            } else {
                throw new \CMEsteban\Exception\CMEstebanException("unknown setting: $setting");
            }
        } else {
            $result = $settings;
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
