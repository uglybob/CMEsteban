<?php

namespace CMEsteban\Page\Module;

class Table extends Form
{
    protected $table;

    public function __construct(array $rows, array $headings, array $classes = [])
    {
        $this->rows = $rows;
        $this->headings = $headings;
        $this->classes = $classes;

        $this->prepareTable();

        parent::__construct();
    }

    protected function addStylesheets()
    {
        $this->addStylesheet('/CMEsteban/Page/css/table.css', true);
    }
    protected function render()
    {
        return $this->table . parent::render();
    }

    protected function prepareTable()
    {
        $this->table = $this->generateHeader();

        foreach ($this->rows as $number => $row) {
            $this->table .= $this->generateRow($number, $row);
        }

        $this->table = HTML::div(['.ctable'], $this->table);
    }

    public function generateHeader()
    {
        $cells = '';

        foreach ($this->headings as $heading) {
            $cells .= HTML::div(['.cthead'], $heading);
        }

        return HTML::div(['.ctheader'], HTML::div(['.ctrow'], $cells));
    }
    public function generateRow($number, $row)
    {
        $properties = '';

        foreach ($this->headings as $heading => $caption) {
            $properties .= HTML::div(['.ctcell'], $row[$heading]);
        }

        $rowClasses = $this->generateRowClasses($number);

        return HTML::div($rowClasses, $properties);
    }
    public function generateRowClasses($number)
    {
        $classes = ['.ctrow'];

        if (!empty($this->classes)) {
            $classes = array_merge($classes, $this->classes[$number]);
        }

        return $classes;
    }

    public function formatArray(array $input)
    {
        $result = [];

        foreach ($input as $key => $value) {
            $result[] = [$key, $value];
        }

        return $result;
    }
}
