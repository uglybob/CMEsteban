<?php

namespace Bh\Page\Module;

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
        return $this->form->__toString();
    }
    // }}}
}
