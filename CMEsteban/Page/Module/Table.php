<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

class Table extends Form
{
    // {{{ variables
    protected $table;
    // }}}
    // {{{ constructor
    public function __construct(array $items, array $attributes = [])
    {
        parent::__construct();

        CMEsteban::$template->addStylesheet(CMEsteban::$setup->getSettings('PathCme') . '/CMEsteban/Page/css/table.css');

        $this->attributes = (empty($attributes)) ? $this->generateAttributes($items) : $attributes;
        $this->table = $this->generateHeader();

        foreach ($items as $item) {
            $this->table .= $this->generateRow($item);
        }

        $this->table = HTML::div(['.ctable'], $this->table);
    }
    // }}}

    // {{{ toString
    public function __toString()
    {
        return $this->table;
    }
    // }}}

    // {{{ generateAttributes
    public function generateAttributes(array $items)
    {
        $attributes = [];
        $key = array_key_first($items);

        if (isset($items[$key])) {
            foreach ($items[$key]['properties'] as $attribute => $value) {
                $attributes[$attribute] = $attribute;
            }
        }

        return $attributes;
    }
    // }}}
    // {{{ generateHeader
    public function generateHeader()
    {
        $cells = '';

        foreach ($this->attributes as $attribute => $caption) {
            $cells .= HTML::div(['.cthead'], $caption);
        }

        return HTML::div(['.ctheader'], HTML::div(['.ctrow'], $cells));
    }
    // }}}
    // {{{ generateRow
    public function generateRow($item)
    {
        $properties = '';

        foreach ($this->attributes as $attribute => $caption) {
            $properties .= HTML::div([".$attribute", '.ctcell'], $item['properties'][$attribute]);
        }

        $rowClasses = $this->generateRowClasses($item);

        return HTML::div($rowClasses, $properties);
    }
    // }}}
    // {{{ generateRowClasses
    public function generateRowClasses($item)
    {
        return array_merge(['.ctrow'], $item['classes']);
    }
    // }}}

    // {{{ formatArray
    public function formatArray(array $input)
    {
        $result = [];

        foreach ($input as $key => $value) {
            $result[] = [$key, $value];
        }

        return $result;
    }
    // }}}
    // {{{ shorten
    public function shorten($text, $length)
    {
        return (strlen($text) > $length) ? substr($text, 0, $length - 3) . '...' : $text;
    }
    // }}}
}
