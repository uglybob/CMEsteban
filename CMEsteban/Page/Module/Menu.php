<?php

namespace CMEsteban\Page\Module;

class Menu extends Module
{
    public function __construct($links = [])
    {
        $this->addStylesheet('/CMEsteban/Page/css/menu.css', true);
        $this->links = $links;

        parent::__construct();
    }

    public function render()
    {
        $menu = '';

        foreach ($this->links as $title => $link) {
            $menu .= HTML::li(
                HTML::a(['href' => $link], $title)
            );
        }

        return HTML::nav(['class' => 'cmenu'], HTML::ul($menu));
    }
}
