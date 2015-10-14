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
        $this->form->addEmail('Email');
        $this->form->addPassword('Pass');

        if ($user = $this->controller->getCurrentUser()) {
            $this->object = $user;
        }
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

        $this->controller->editUser($this->object);
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
