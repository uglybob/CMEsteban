<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\Page\Page;

class EditText extends EditNamed
{
    protected function create()
    {
        parent::create();

        $this->form->addText('Link');
        $this->form->addTextarea('Text');
    }
    protected function populate()
    {
        $values = [
            'Link' => $this->entity->getLink(),
            'Text' => $this->entity->getText(),
        ];

        $this->form->populate($values);

        parent::populate();
    }
    protected function save()
    {
        $values = $this->form->getValues();

        $this->entity->setLink($values['Link']);
        $this->entity->setText($values['Text']);

        parent::save();
    }
}
