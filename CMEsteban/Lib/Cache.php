<?php

namespace CMEsteban\Lib;

use CMEsteban\CMEsteban;

class Cache
{
    // {{{ set
    public static function set($index, $data)
    {
        $name = self::getFilename($index);

        return (file_put_contents($name, $data) !== false);
    }
    // }}}
    // {{{ get
    public static function get($index, $includeExpired = false)
    {
        $result = false;
        $name = self::isGettable($index, $includeExpired);

        if ($name) {
            $result = file_get_contents($name);
        }

        return $result;
    }
    // }}}
    // {{{ getReference
    public static function getReference($index, $includeExpired = false)
    {
        $result = false;
        $name = self::isGettable($index, $includeExpired);

        if ($name) {
            $result = self::getDir(false) . "/$index";
        }

        return $result;
    }
    // }}}
    // {{{ isGettable
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
    // }}}

    // {{{ list
    public static function list()
    {
        $files = glob(self::getDir() . '/*');
        $list = [];

        foreach ($files as $file) {
            $list[$file] = self::validTime($file);
        }

        return $list;
    }
    // }}}
    // {{{ clear
    public static function clear()
    {
        $success = true;
        $files = self::list();

        foreach ($files as $file => $valid) {
            $success = unlink($file) && $success;
        }

        return $success;
    }
    // }}}
    // {{{ autoClear
    public static function autoClear()
    {
        if (CMEsteban::$setup->getSettings('CacheTime') == 'auto') {
            self::clear();
        }
    }
    // }}}

    // {{{ validTime
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
    // }}}
    // {{{ getDir
    public function getDir($internal = true)
    {
        $root = ($internal) ? CMEsteban::$setup->getSettings('Path') : '';

        return $root . '/CMEsteban/Cache';
    }
    // }}}
    // {{{ getFilename
    public function getFilename($index)
    {
        return self::getDir() . "/$index";
    }
    // }}}
}
