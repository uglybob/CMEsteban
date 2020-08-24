<?php

namespace CMEsteban\Page\Module;

class Menu extends Module
{
    protected $links;
    protected $selected;

    public function __construct($links = [], $selected = null)
    {
        $this->links = $links;
        $this->selected = $selected;

        parent::__construct();
    }

    protected function addStylesheets()
    {
        $this->addStylesheet('/CMEsteban/Page/css/menu.css', true);
    }
    protected function render()
    {
        $menu = '';

        foreach ($this->links as $title => $link) {
            $attributes = [];

            if ($this->selected == $title) {
                $attributes[] = '.selected';
            }

            $menu .= HTML::li($attributes,
                HTML::a(['href' => $link], $title)
            );
        }

        return HTML::nav(['class' => 'cmenu'], HTML::ul($menu));
    }
}
