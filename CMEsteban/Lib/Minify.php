<?php

namespace CMEsteban\Lib;

use CMEsteban\CMEsteban;

abstract class Minify
{
    public static function minify($type, $files) {
        $result = $files;
        $setup = CMEsteban::$setup;
        $cache = CMEsteban::$frontCache;

        if (!$setup->getSettings('DevMode')) {
            $index = hash('crc32b', implode(' ', $files)) . ".$type";
            $link = $cache->getLink($index, true);

            if (!$link) {
                $minifier = ($type == 'css') ? new \MatthiasMullie\Minify\CSS() : new \MatthiasMullie\Minify\JS();

                foreach ($files as $file) {
                    $minifier->add($setup->getSettings('Path') . "/$file");
                }

                if ($cache->write($index, $minifier->minify())) {
                    $link = $cache->getFilename($index, false);
                }
            }

            if ($link) {
                $result = [$link];
            }
        }

        return $result;
    }
}
