<?php

namespace Bh\Lib;

class Minify
{
    public static function minify($type, $files) {
        if ($type == 'css') {
            $minifier = new \MatthiasMullie\Minify\CSS();
        } else {
            $minifier = new \MatthiasMullie\Minify\JS();
        }

        foreach ($files as $file) {
            $minifier->add(Setup::getSettings('Path') . $file);
        }

        return $minifier->minify();
    }
}
