<?php

namespace Bh\Page\Module;

class Cache
{
    // {{{ render
    public function render()
    {
        $list = \Bh\Lib\Cache::list();
        $rendered = '';

        if (is_array($list)) {
            foreach ($list as $file => $valid) {
                $rendered .= HTML::div($file . (($valid) ? ' valid' : ' invalid'));
            }
        }

        return $rendered;
    }
    // }}}
}
