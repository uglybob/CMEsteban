<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Module\Form\UserForm;

class User extends Form
{
    // {{{ constructor
    public function __construct()
    {
        parent::__construct();

        $this->form = new UserForm(CMEsteban::$page->getPath(1));
    }
    // }}}
}
