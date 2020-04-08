<?php

namespace CMEsteban\Lib;

use CMEsteban\CMEsteban;

abstract class Cache
{
    public function autoClear()
    {
        if (CMEsteban::$setup->getSettings('CacheTime') == 'auto') {
            $this->clear();
        }
    }

    public function getDir()
    {
        return CMEsteban::$setup->getSettings('Path') . '/CMEsteban/Cache';
    }
    public function getFilename($index)
    {
        return $this->getDir() . "/$index";
    }
}
