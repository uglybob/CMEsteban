<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Page;

class UserForm extends EditForm
{
    public function __construct($id)
    {
        $settings = $this->getSetup()->getSettings();

        if (
            $settings['EnableRegistration']
            || $this->getController()->getCurrentUser()
        ) {
            parent::__construct('User', $id);
        } else {
            $this->form = 'Registration disabled';
        }
    }

    protected function create()
    {
        $this->form->addText('Name', ['required' => true]);
        $this->form->addEmail('Email', ['required' => true]);
        $this->form->addPassword('Password');
        $this->form->addPassword('Confirm');
    }
    protected function save()
    {
        $values = $this->form->getValues();

        $this->entity->setName($values['Name']);
        $this->entity->setEmail($values['Email']);

        if (!empty($values['Password'])) {
            $this->entity->setPass($values['Password']);
        }

        $this->getController()->editUser($this->entity);
    }
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

    protected function validate()
    {
        $values = $this->form->getValues();

        $equal = ($values['Password'] === $values['Confirm']);

        if (!$equal) {
            $this->addErrorMessage('passwords don\'t match');
        }

        return parent::validate() && $equal;
    }
    protected function loadEntity()
    {
        $this->entity = $this->getController()->getCurrentUser();
    }
    protected function redirect()
    {
        Page::redirect('/');
    }
}
