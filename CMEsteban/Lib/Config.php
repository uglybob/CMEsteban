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
