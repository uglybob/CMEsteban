<?php

namespace CMEsteban\Page\Module;

use CMEsteban\Page\Module\Form\UserForm;

class User extends Form
{
    // {{{ constructor
    public function __construct($page, $controller)
    {
        parent::__construct($page, $controller);

        $this->form = new UserForm($controller, $page->getPath(1));
    }
    // }}}
}
