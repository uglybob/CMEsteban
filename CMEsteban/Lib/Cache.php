<?php

namespace CMEsteban\Lib;

use CMEsteban\CMEsteban;

class Cache
{
    public static function set($index, $data)
    {
        $name = self::getFilename($index);

        return (file_put_contents($name, $data) !== false);
    }
    public static function get($index, $includeExpired = false)
    {
        $result = false;
        $name = self::isGettable($index, $includeExpired);

        if ($name) {
            $result = file_get_contents($name);
        }

        return $result;
    }
    public static function getLink($index, $includeExpired = false)
    {
        $result = false;
        $name = self::isGettable($index, $includeExpired);

        if ($name) {
            $result = self::getFilename($index, false);
        }

        return $result;
    }
    protected static function isGettable($index, $includeExpired = false)
    {
        $name = self::getFilename($index);
        $result = false;

        if (
            is_file($name)
            && (
                $includeExpired
                || self::validTime($name)
            )
        ) {
            $result = $name;
        }

        return $result;
    }

    public static function list()
    {
        $files = glob(self::getDir() . '/*');
        $list = [];

        foreach ($files as $file) {
            $list[$file] = self::validTime($file);
        }

        return $list;
    }
    public static function clear()
    {
        $success = true;
        $files = self::list();

        foreach ($files as $file => $valid) {
            $success = unlink($file) && $success;
        }

        return $success;
    }
    public static function autoClear()
    {
        if (CMEsteban::$setup->getSettings('CacheTime') == 'auto') {
            self::clear();
        }
    }

    protected function validTime($file)
    {
        $timeLeft = 0;

        $cacheTime = CMEsteban::$setup->getSettings('CacheTime');

        if ($cacheTime == 'auto') {
            $timeLeft = 'auto';
        } else {
            $timeLeft = CMEsteban::$setup->getSettings('CacheTime') - (time() - filemtime($file));
            $timeLeft = ($timeLeft > 0) ? $timeLeft : 0;
        }

        return $timeLeft;
    }
    public function getDir($internal = true)
    {
        $root = ($internal) ? CMEsteban::$setup->getSettings('Path') : '';

        return $root . '/CMEsteban/Cache';
    }
    public function getFilename($index, $internal = true)
    {
        return self::getDir($internal) . "/$index";
    }
}
