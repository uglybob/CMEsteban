<?php

namespace CMEsteban\Lib;

use CMEsteban\CMEsteban;

class CacheFile extends Cache
{
    public function __construct($path, $external = null)
    {
        $this->path = $path;
        $this->external = $external;
    }

    public function write($index, $data)
    {
        $name = $this->getFilename($index);

        return (file_put_contents($name, $data) !== false);
    }
    public function read($index, $includeExpired = false)
    {
        $result = false;
        $name = $this->isGettable($index, $includeExpired);

        if ($name) {
            $result = file_get_contents($name);
        }

        return $result;
    }
    public function list()
    {
        $files = glob($this->getDir() . '/*');
        $list = [];

        foreach ($files as $file) {
            $list[$file] = $this->validTime($file);
        }

        return $list;
    }
    public function clear()
    {
        $success = true;
        $files = $this->list();

        foreach ($files as $file => $valid) {
            $success = unlink($file) && $success;
        }

        return $success;
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
    protected function isGettable($index, $includeExpired = false)
    {
        $name = $this->getFilename($index);
        $result = false;

        if (
            is_file($name)
            && (
                $includeExpired
                || $this->validTime($name)
            )
        ) {
            $result = $name;
        }

        return $result;
    }
    public function getLink($index, $includeExpired = false)
    {
        $result = false;
        $name = $this->isGettable($index, $includeExpired);

        if ($name) {
            $result = $this->external . "/$index";
        }

        return $result;
    }
}
