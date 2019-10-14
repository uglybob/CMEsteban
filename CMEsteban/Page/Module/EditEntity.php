<?php

namespace CMEsteban\Page\Module;

class EditEntity extends Form
{
    // {{{ constructor
    public function __construct($page, $controller)
    {
        parent::__construct($page, $controller);

        $class = ucfirst($page->getPath(1));
        $formType = 'CMEsteban\Page\Module\Form\Edit' . $class;

        $this->form = new $formType($controller, $class, $page->getPath(2));
    }
    // }}}
}
