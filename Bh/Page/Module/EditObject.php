<?php

namespace Bh\Page\Module;

class EditObject extends FormModule
{
    // {{{ constructor
    public function __construct($controller, $page)
    {
        parent::__construct($controller, $page);

        $class = ucfirst($page->getPath(1));
        $formType = 'Bh\Page\Module\Edit' . $class;

        $this->form = new $formType($controller, $class, $page->getPath(2));
    }
    // }}}
}
