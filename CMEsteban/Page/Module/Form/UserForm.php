<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\Page\Page;

class UserForm extends EditForm
{
    // {{{ constructor
    public function __construct($controller, $id)
    {
        $settings = \CMEsteban\Lib\Setup::getSettings();

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

        $this->entity->setName($values['Name']);
        $this->entity->setEmail($values['Email']);

        if (!empty($values['Pass'])) {
            $this->entity->setPass($values['Pass']);
        }

        $this->controller->editUser($this->entity);
    }
    // }}}
    // {{{ populate
    protected function populate()
    {
        if ($this->entity) {
            $values = [
                'Name' => $this->entity->getName(),
                'Email' => $this->entity->getEmail(),
            ];

            $this->form->populate($values);
        }
    }
    // }}}

    // {{{ instantiateEntity
    protected function instantiateEntity()
    {
        $this->entity = new \CMEsteban\Entity\User('');
    }
    // }}}

    // {{{ loadEntity
    protected function loadEntity()
    {
        $this->entity = $this->controller->getCurrentUser();
    }
    // }}}
    // {{{ redirect
    protected function redirect()
    {
        Page::redirect('/');
    }
    // }}}
}
