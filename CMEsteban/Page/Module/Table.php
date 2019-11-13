<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

class Table extends Form
{
    // {{{ variables
    protected $table;
    // }}}
    // {{{ constructor
    public function __construct(array $rows, array $headings = [])
    {
        parent::__construct();

        CMEsteban::$template->addStylesheet(CMEsteban::$setup->getSettings('PathCme') . '/CMEsteban/Page/css/table.css');

        $this->headings = (empty($headings)) ? $this->generateHeadings($rows) : $headings;
        $this->table = $this->generateHeader();

        foreach ($rows as $row) {
            $this->table .= $this->generateRow($row);
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

    // {{{ generateHeadings
    public function generateHeadings(array $rows)
    {
        $headings = [];
        $key = array_key_first($rows);

        if (isset($rows[$key])) {
            foreach ($rows[$key] as $heading => $value) {
                $headings[$heading] = $heading;
            }
        }

        return $headings;
    }
    // }}}
    // {{{ generateHeader
    public function generateHeader()
    {
        $cells = '';

        foreach ($this->headings as $heading => $caption) {
            $cells .= HTML::div(['.cthead'], $caption);
        }

        return HTML::div(['.ctheader'], HTML::div(['.ctrow'], $cells));
    }
    // }}}
    // {{{ generateRow
    public function generateRow($row)
    {
        $properties = '';

        foreach ($this->headings as $heading => $caption) {
            $properties .= HTML::div([".$heading", '.ctcell'], $row[$heading]);
        }

        $rowClasses = $this->generateRowClasses($row);

        return HTML::div($rowClasses, $properties);
    }
    // }}}
    // {{{ generateRowClasses
    public function generateRowClasses($row)
    {
        return ['.ctrow'];
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
