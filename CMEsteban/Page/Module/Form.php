<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

abstract class Form extends Module
{
    // {{{ constructor
    public function __construct()
    {
        parent::__construct();

        CMEsteban::$template->addStylesheet('/vendor/depage/htmlform/lib/css/depage-forms.css');
    }
    // }}}
    // {{{ toString
    public function __toString()
    {
        return preg_replace('~>\\s+<~m', '><', $this->form->__toString());
    }
    // }}}
}
