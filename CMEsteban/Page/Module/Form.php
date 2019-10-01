<?php

namespace CMEsteban\Page\Module;

abstract class Form
{
    // {{{ constructor
    public function __construct($controller, $page)
    {
        $page->addStylesheet('/vendor/depage/htmlform/lib/css/depage-forms.css');
    }
    // }}}
    // {{{ toString
    public function __toString()
    {
        return preg_replace('~>\\s+<~m', '><', $this->form->__toString());
    }
    // }}}
}
