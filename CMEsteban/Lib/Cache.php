<?php

namespace CMEsteban\Lib;

abstract class Cache extends Component
{
    public function autoClear()
    {
        if ($this->getSetup()->getSettings('CacheTime') == 'auto') {
            $this->clear();
        }
    }

    public function getFilename($index)
    {
        return $this->getDir() . "/$index";
    }
    protected function isGettable($index, $includeExpired = false)
    {
        $name = $this->getFilename($index);
        $result = false;

        if (
            $this->is_file($name)
            && (
                $includeExpired
                || $this->validTime($name)
            )
        ) {
            $result = $name;
        }

        return $result;
    }

    public function read($index, $includeExpired = false)
    {
        $result = false;
        $name = $this->isGettable($index, $includeExpired);

        if ($name) {
            $result = $this->readData($name);
        }

        return $result;
    }
    public function list()
    {
        $files = $this->getEntries();
        $list = [];

        foreach ($files as $file) {
            $list[$file] = $this->validTime($file);
        }

        return $list;
    }

    protected function validTime($file)
    {
        $timeLeft = 0;

        $cacheTime = $this->getSetup()->getSettings('CacheTime');

        if ($cacheTime == 'auto') {
            $timeLeft = 'auto';
        } else {
            $timeLeft = $cacheTime - (time() - $this->filemtime($file));
            $timeLeft = ($timeLeft > 0) ? $timeLeft : 0;
        }

        return $timeLeft;
    }
    public function clear()
    {
        $success = true;
        $files = $this->list();

        foreach ($files as $file => $valid) {
            $success = $this->unlink($file) && $success;
        }

        return $success;
    }
}
