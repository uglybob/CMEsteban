<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

class Menu extends Module
{
    public function __construct($links = [])
    {
        parent::__construct();

        CMEsteban::$template->addStylesheet(CMEsteban::$setup->getSettings('PathCme') . '/CMEsteban/Page/css/menu.css');
        $this->links = $links;
    }
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
}
