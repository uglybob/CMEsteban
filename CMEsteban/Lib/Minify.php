<?php

namespace CMEsteban\Lib;

use CMEsteban\CMEsteban;

abstract class Minify
{
    public static function minify($type, $files) {
        $result = $files;

        if (!CMEsteban::$setup->getSettings('DevMode')) {
            $index = hash('crc32b', implode(' ', $files)) . ".$type";
            $link = Cache::getLink($index, true);

            if (!$link) {
                $minifier = ($type == 'css') ? new \MatthiasMullie\Minify\CSS() : new \MatthiasMullie\Minify\JS();

                foreach ($files as $file) {
                    $minifier->add(CMEsteban::$setup->getSettings('Path') . "/$file");
                }

                if (Cache::set($index, $minifier->minify())) {
                    $link = Cache::getFilename($index, false);
                }
            }

            if ($link) {
                $result = [$link];
            }
        }

        return $result;
    }
}
