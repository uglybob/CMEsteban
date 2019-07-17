<?php

namespace CMEsteban\Page\Module;

use CMEsteban\Page\Module\Form\UserForm;

class User extends Form
{
    // {{{ constructor
    public function __construct($controller, $page)
    {
        parent::__construct($controller, $page);

        $this->form = new UserForm($controller, $page->getPath(1));
    }
    // }}}
}
