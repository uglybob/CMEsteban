<?php

namespace CMEsteban\Page\Module;

class Table
{
    // {{{ constructor
    public function __construct($page, array $items, array $attributes = [])
    {
        $page->addStylesheet('/CMEsteban/Page/css/table.css');
        $this->list = '';

        if (empty($attributes)) {
            $key = array_key_first($items);

            if (isset($items[$key])) {
                foreach ($items[$key] as $attribute => $value) {
                    $attributes[$attribute] = $attribute;
                }
            }
        }

        $header = '';
        foreach ($attributes as $attribute => $caption) {
            $header .= HTML::div(['.cthead'], $caption);
        }
        $this->list .= HTML::div(['.ctheader'], HTML::div(['.ctrow'], $header));

        foreach ($items as $item) {
            $propertyList = '';

            foreach ($attributes as $attribute => $caption) {
                $class = preg_replace('/[^_\-a-z0-9]/i', '_', $caption);
                $propertyList .= HTML::div([".$class", '.ctcell'], $item[$attribute]);
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
