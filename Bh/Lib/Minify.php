<?php

namespace Bh\Lib;

abstract class Minify
{
    public static function minify($type, $files) {
        $index = md5(implode(' ', $files)) . ".$type";
        $cached = Cache::get($index);

        if (!$cached) {
            $minifier = ($type == 'css') ? new \MatthiasMullie\Minify\CSS() : new \MatthiasMullie\Minify\JS();

            foreach ($files as $file) {
                $minifier->add(Setup::getSettings('Path') . $file);
            }

            Cache::set($index, $minifier->minify());
        }

        return "/Bh/Cache/$index";
    }
}
