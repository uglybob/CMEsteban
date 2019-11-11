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
