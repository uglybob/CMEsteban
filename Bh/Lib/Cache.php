<?php

namespace Bh\Lib;

class Cache
{
    // {{{ get
    public static function get($index)
    {
        $name = self::getFilename($index);
        $result = false;

        if (self::validTime($name)) {
            $result = file_get_contents($name);
        }

        return $result;
    }
    // }}}
    // {{{ set
    public static function set($index, $data)
    {
        $name = self::getFilename($index);
        file_put_contents($name, $data);
    }
    // }}}

    // {{{ list
    public static function list()
    {
        $path = Setup::getSettings('Path') . 'Bh/Cache';
        $files = glob($path . '/*.html');
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

    // {{{ validTime
    protected function validTime($file)
    {
        $timeLeft = 0;

        if (is_file($file)) {
            $timeLeft = Setup::getSettings('CacheTime') - (time() - filemtime($file));
            $timeLeft = ($timeLeft > 0) ? $timeLeft : 0;
        }

        return $timeLeft;
    }
    // }}}
    // {{{ getFilename
    protected function getFilename($index)
    {
        return Setup::getSettings('Path') . "Bh/Cache/$index.html";
    }
    // }}}
}