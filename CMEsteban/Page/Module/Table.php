<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

class Table extends Form
{
    // {{{ variables
    protected $table;
    // }}}
    // {{{ constructor
    public function __construct(array $rows, array $headings, array $classes = [])
    {
        parent::__construct();

        CMEsteban::$template->addStylesheet(CMEsteban::$setup->getSettings('PathCme') . '/CMEsteban/Page/css/table.css');

        $this->headings = $headings;
        $this->classes = $classes;
        $this->table = $this->generateHeader();

        foreach ($rows as $number => $row) {
            $this->table .= $this->generateRow($number, $row);
        }

        $this->table = HTML::div(['.ctable'], $this->table);
    }
    // }}}

    // {{{ toString
    public function __toString()
    {
        return $this->table . parent::__toString();
    }
    // }}}

    // {{{ generateHeader
    public function generateHeader()
    {
        $cells = '';

        foreach ($this->headings as $heading) {
            $cells .= HTML::div(['.cthead'], $heading);
        }

        return HTML::div(['.ctheader'], HTML::div(['.ctrow'], $cells));
    }
    // }}}
    // {{{ generateRow
    public function generateRow($number, $row)
    {
        $properties = '';

        foreach ($this->headings as $heading => $caption) {
            $properties .= HTML::div([".$heading", '.ctcell'], $row[$heading]);
        }

        $rowClasses = $this->generateRowClasses($number);

        return HTML::div($rowClasses, $properties);
    }
    // }}}
    // {{{ generateRowClasses
    public function generateRowClasses($number)
    {
        $classes = ['.ctrow'];

        if (!empty($this->classes)) {
            $classes = array_merge($classes, $this->classes[$number]);
        }

        return $classes;
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
}
