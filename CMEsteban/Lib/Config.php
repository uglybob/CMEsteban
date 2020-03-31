<?php

namespace CMEsteban\Lib;

abstract class Config
{
    public function __construct()
    {
        $this->settings['Path'] = realpath($this->settings['Path'] . "/../..");
        $this->settings['PathCme'] = str_replace($this->settings['Path'], '', realpath(__DIR__ . "/../.."));

        $this->settings['url_host'] = true;
        $this->settings['url_max_length'] = 60;
    }

    public function getSettings($setting = null, $optional = false)
    {
        $result = null;

        if (is_null($setting)) {
            $result = $this->settings;
        } else {
            if (isset($this->settings[$setting])) {
                $result = $this->settings[$setting];
            } else if ($optional === true) {
            } else {
                throw new \CMEsteban\Exception\CMEstebanException("Unknown setting: $setting");
            }
        }

        return $result;
    }
}
