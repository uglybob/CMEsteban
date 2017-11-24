<?php

namespace Bh\Lib;

class Minify
{
    public static function minify($type, $files) {
        $index = md5(implode(' ', $files)) . ".$type";
        $cached = Cache::get($index);

        if (!$cached) {
            if ($type == 'css') {
                $minifier = new \MatthiasMullie\Minify\CSS();
            } else {
                $minifier = new \MatthiasMullie\Minify\JS();
            }

            foreach ($files as $file) {
                $minifier->add(Setup::getSettings('Path') . $file);
            }

            Cache::set($index, $minifier->minify());
        }

        return "/Bh/Cache/$index";
    }
}
