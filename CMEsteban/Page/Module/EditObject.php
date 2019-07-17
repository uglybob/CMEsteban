<?php

namespace CMEsteban\Page\Module;

class EditObject extends Form
{
    // {{{ constructor
    public function __construct($controller, $page)
    {
        parent::__construct($controller, $page);

        $class = ucfirst($page->getPath(1));
        $formType = 'CMEsteban\Page\Module\Form\Edit' . $class;

        $this->form = new $formType($controller, $class, $page->getPath(2));
    }
    // }}}
}
