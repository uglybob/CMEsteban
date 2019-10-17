<?php

namespace CMEsteban\Lib;

abstract class Config
{
    // {{{ getSettings
    public static function getSettings($setting = null)
    {
        $result = null;
        $settings = Setup::$settings;
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
    public static function getTemplate($page) {
        return new \CMEsteban\Page\Template\CME();
    }
    // }}}
    // {{{ getController
    public static function getController() {
        return new \CMEsteban\Lib\Controller();
    }
    // }}}
}
