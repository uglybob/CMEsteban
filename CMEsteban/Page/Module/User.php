<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Module\Form\UserForm;

class User extends Form
{
    protected function prepare()
    {
        $this->form = new UserForm(CMEsteban::$page->getPath(1));
    }
}
