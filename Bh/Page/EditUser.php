<?php

namespace Bh\Page;

class EditUser extends EditForm
{
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

        if (!empty($values['Pass'])) {
            $this->object->setPass($values['Pass']);
        }
        \Bh\Lib\Mapper::commit();
        Page::redirect('/');
    }
    // }}}
    // {{{ populate
    protected function populate()
    {
        $values = [
            'Email' => $this->object->getEmail(),
        ];

        $this->form->populate($values);
    }
    // }}}
    // {{{ instantiateObject
    protected function instantiateObject()
    {
        $this->object = new \Bh\Entity\User();
        \Bh\Lib\Mapper::save($this->object);
    }
    // }}}
}
