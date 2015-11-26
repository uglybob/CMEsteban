<?php

namespace Bh\Page;

class UserForm extends EditForm
{
    // {{{ constructor
    public function __construct($controller, $id)
    {
        $settings = \Bh\Lib\Setup::getSettings();

        if (
            $settings['EnableRegistration']
            || $controller->getCurrentUser()
        ) {
            parent::__construct($controller, 'User', $id);
        } else {
            $this->form = 'Registration disabled';
        }
    }
    // }}}

    // {{{ create
    protected function create()
    {
        $this->form->addText('Name');
        $this->form->addEmail('Email');
        $this->form->addPassword('Pass');
    }
    // }}}
    // {{{ save
    protected function save()
    {
        $values = $this->form->getValues();

        $this->object->setName($values['Name']);
        $this->object->setEmail($values['Email']);

        if (!empty($values['Pass'])) {
            $this->object->setPass($values['Pass']);
        }

        $this->controller->editUser($this->object);
    }
    // }}}
    // {{{ populate
    protected function populate()
    {
        if ($this->object) {
            $values = [
                'Name' => $this->object->getName(),
                'Email' => $this->object->getEmail(),
            ];

            $this->form->populate($values);
        }
    }
    // }}}

    // {{{ instantiateObject
    protected function instantiateObject()
    {
        return new \Bh\Entity\User('unnamed');
    }
    // }}}

    // {{{ loadObject
    protected function loadObject()
    {
        $this->object = $this->controller->getCurrentUser();
    }
    // }}}
    // {{{ redirect
    protected function redirect()
    {
        Page::redirect('/');
    }
    // }}}
}
