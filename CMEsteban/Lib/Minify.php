<?php

namespace CMEsteban\Lib;

use CMEsteban\CMEsteban;

abstract class Minify
{
    public static function minify($type, $files) {
        $result = $files;

        if (!CMEsteban::$setup->getSettings('DevMode')) {
            $index = md5(implode(' ', $files)) . ".$type";
            $cached = Cache::load($index);

            if (!$cached) {
                $minifier = ($type == 'css') ? new \MatthiasMullie\Minify\CSS() : new \MatthiasMullie\Minify\JS();

                foreach ($files as $file) {
                    $minifier->add(CMEsteban::$setup->getSettings('Path') . $file);
                }

                Cache::store($index, $minifier->minify());
            }

            $result = ["/CMEsteban/Cache/$index"];
        }

        return $result;
    }
}
