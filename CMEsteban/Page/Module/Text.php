<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

class Text extends Module
{
    // {{{ constructor
    public function __construct($text)
    {
        parent::__construct();

        $this->text = $text;
    }
    // }}}
    // {{{ toString
    public function __toString()
    {
        $result = '';

        if ($this->text) {
            $result = HTML::div(['.ctext'], $this->text);
        }

        return $result;
    }
    // }}}
}
