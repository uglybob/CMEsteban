<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

class EditEntity extends Form
{
    protected function prepare()
    {
        $class = ucfirst(CMEsteban::$page->getPath(1));
        $formType = 'CMEsteban\Page\Module\Form\Edit' . $class;

        $this->form = new $formType($class, CMEsteban::$page->getPath(2));
    }
}
