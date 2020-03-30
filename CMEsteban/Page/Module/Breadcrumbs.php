<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

class Breadcrumbs extends Module
{
    public function __construct($items = [])
    {
        $this->items = $items;

        parent::__construct();
    }

    public function add($name, $link)
    {
        $this->items[$name] = $link;
    }
    public function render()
    {
        $breadcrumbs = '';
        $first = true;

        foreach ($this->items as $title => $link) {
            if ($first) {
                $first = false;
            } else {
                $breadcrumbs .= HTML::span('>');
            }

            $breadcrumbs .= HTML::span(HTML::a(['href' => $link], $title));
        }

        return HTML::div(['.breadcrumbs'], $breadcrumbs);
    }
}
