<?php

namespace CMEsteban\Page\Module;

abstract class Form extends Module
{
    // {{{ constructor
    public function __construct($page, $controller)
    {
        parent::__construct($page);

        $this->page->getTemplate()->addStylesheet('/vendor/depage/htmlform/lib/css/depage-forms.css');
        $this->controller = $controller;
    }
    // }}}
    // {{{ toString
    public function __toString()
    {
        return preg_replace('~>\\s+<~m', '><', $this->form->__toString());
    }
    // }}}
}
