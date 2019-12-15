<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\Page\Page;

class EditNamed extends EditForm
{
    // {{{ create
    protected function create()
    {
        parent::create();

        $this->form->addText('Name', ['required' => true]);
    }
    // }}}
    // {{{ populate
    protected function populate()
    {
        $values = [
            'Name' => $this->entity->getName(),
        ];

        $this->form->populate($values);

        parent::populate();
    }
    // }}}
    // {{{ save
    protected function save()
    {
        $values = $this->form->getValues();

        $this->entity->setName($values['Name']);

        parent::save();
    }
    // }}}
}
