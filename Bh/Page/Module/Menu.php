<?php

namespace Bh\Page\Module;

class Menu
{
    // {{{ constructor
    public function __construct($links = [])
    {
        $this->links = $links;
    }
    // }}}
    // {{{ toString
    public function __toString()
    {
        $menu = '';

        foreach ($this->links as $title => $link) {
            $menu .= HTML::div(
                HTML::a(['href' => $link], $title)
            );
        }

        return Html::div(['class' => 'menu'], $menu);
    }
    // }}}
}
