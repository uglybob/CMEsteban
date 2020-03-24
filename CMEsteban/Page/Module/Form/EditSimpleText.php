<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\Page\Page;

class EditSimpleText extends EditNamed
{
    protected function create()
    {
        parent::create();

        $this->form->addTextarea('Text');
    }
    protected function populate()
    {
        $values = [
            'Text' => $this->entity->getText(),
        ];

        $this->form->populate($values);

        parent::populate();
    }
    protected function save()
    {
        $values = $this->form->getValues();

        $this->entity->setText($values['Text']);

        parent::save();
    }
}
