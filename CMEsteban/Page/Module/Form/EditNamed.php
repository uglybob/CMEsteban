<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\Page\Page;

class EditNamed extends EditForm
{
    protected function create()
    {
        parent::create();

        $this->form->addText('Name', ['required' => true]);
    }
    protected function populate()
    {
        $values = [
            'Name' => $this->entity->getName(),
        ];

        $this->form->populate($values);

        parent::populate();
    }
    protected function save()
    {
        $values = $this->form->getValues();

        $this->entity->setName($values['Name']);

        parent::save();
    }
}
