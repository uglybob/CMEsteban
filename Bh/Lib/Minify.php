<?php

namespace Bh\Lib;

abstract class Minify
{
    public static function minify($type, $files) {
        $result = $files;

        if (!Setup::getSettings('DevMode')) {
            $index = md5(implode(' ', $files)) . ".$type";
            $cached = Cache::load($index);

            if (!$cached) {
                $minifier = ($type == 'css') ? new \MatthiasMullie\Minify\CSS() : new \MatthiasMullie\Minify\JS();

                foreach ($files as $file) {
                    $minifier->add(Setup::getSettings('Path') . $file);
                }

                Cache::store($index, $minifier->minify());
            }

            $result = ["/Bh/Cache/$index"];
        }

        return $result;
    }
}
