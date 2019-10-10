<?php

namespace CMEsteban\Page\Module;

class Table
{
    // {{{ constructor
    public function __construct($page, array $items, array $attributes)
    {
        $page->addStylesheet('/CMEsteban/Page/css/table.css');
        $this->list = '';

        $header = '';
        foreach ($attributes as $attribute => $caption) {
            $header .= HTML::div(['.cthead'], $caption);
        }
        $this->list .= HTML::div(['.ctheader'], HTML::div(['.ctrow'], $header));

        foreach ($items as $item) {
            foreach ($attributes as $attribute => $caption) {
                $propertyList .= HTML::div([".$caption", '.ctcell'], $item[$attribute]);
            }
            $this->list .= HTML::div(['.ctrow'], $propertyList);
        }

        $this->list = HTML::div(['.ctable'], $this->list);
    }
    // }}}

    // {{{ toString
    public function __toString()
    {
        return $this->list;
    }
    // }}}
}
