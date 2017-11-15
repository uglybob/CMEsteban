<?php

namespace Bh\Page\Module;

class EditObject
{
    // {{{ constructor
    public function __construct($controller, $page)
    {
        $page->addStylesheet('/vendor/depage/htmlform/lib/css/depage-forms.css');

        $class = ucfirst($page->getPath(1));
        $formType = 'Bh\Page\Module\Edit' . $class;

        $this->editForm = new $formType($controller, $class, $page->getPath(2));
    }
    // }}}
    // {{{ toString
    public function __toString()
    {
        return $this->editForm->__toString();
    }
    // }}}
}
