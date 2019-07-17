<?php

namespace CMEsteban\Page\Module;

class Cache
{
    // {{{ render
    public function render()
    {
        $list = \CMEsteban\Lib\Cache::list();
        $rendered = '';

        if (is_array($list)) {
            foreach ($list as $file => $valid) {
                $rendered .= HTML::div($file . ' ' . $valid . 's');
            }
        }

        return $rendered;
    }
    // }}}
}
