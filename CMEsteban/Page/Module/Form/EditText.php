<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\Page\Page;

class EditText extends EditForm
{
    // {{{ create
    protected function create()
    {
        $this->form->addText('Name', ['required' => true]);
        $this->form->addText('Link');
        $this->form->addTextarea('Text');
    }
    // }}}
    // {{{ populate
    protected function populate()
    {
        $values = [
            'Name' => $this->entity->getName(),
            'Link' => $this->entity->getPage(),
            'Text' => $this->entity->getText(),
        ];

        $this->form->populate($values);
    }
    // }}}
    // {{{ save
    protected function save()
    {
        $values = $this->form->getValues();

        $this->entity->setName($values['Name']);
        $this->entity->setPage($values['Link']);
        $this->entity->setText($values['Text']);

        parent::save();
    }
    // }}}
}
