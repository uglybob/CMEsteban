<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Page;

class UserForm extends EditForm
{
    public function __construct($id)
    {
        $settings = CMEsteban::$setup->getSettings();

        if (
            $settings['EnableRegistration']
            || CMEsteban::$controller->getCurrentUser()
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
        $this->form->addPassword('Pass');
    }
    protected function save()
    {
        $values = $this->form->getValues();

        $this->entity->setName($values['Name']);
        $this->entity->setEmail($values['Email']);

        if (!empty($values['Pass'])) {
            $this->entity->setPass($values['Pass']);
        }

        CMEsteban::$controller->editUser($this->entity);
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

    protected function loadEntity()
    {
        $this->entity = CMEsteban::$controller->getCurrentUser();
    }
    protected function redirect()
    {
        Page::redirect('/');
    }
}
