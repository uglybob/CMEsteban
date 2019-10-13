<?php

namespace CMEsteban\Page\Module;

class Menu
{
    // {{{ constructor
    public function __construct($page, $links = [])
    {
        $page->addStylesheet('/vendor/uglybob/cmesteban/CMEsteban/Page/css/menu.css');

        $this->links = $links;
    }
    // }}}
    // {{{ toString
    public function __toString()
    {
        $menu = '';

        foreach ($this->links as $title => $link) {
            $menu .= HTML::li(
                HTML::a(['href' => $link], $title)
            );
        }

        return HTML::nav(['class' => 'cmenu'], HTML::ul($menu));
    }
    // }}}
}
