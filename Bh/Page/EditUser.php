<?php

namespace Bh\Page;

class EditUser extends EditForm
{
    // {{{ setLogic
    protected function setLogic()
    {
        $this->logic = $this->controller;
    }
    // }}}

    // {{{ create
    protected function create()
    {
        $this->form->addEmail('Email');
        $this->form->addPassword('Pass');
    }
    // }}}
    // {{{ save
    protected function save()
    {
        $values = $this->form->getValues();

        $this->object->setEmail($values['Email']);
        $this->object->setPass($values['Pass']);
    }
    // }}}
}
