<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\Page\Page;

class EditText extends EditSimpleText
{
    protected function create()
    {
        parent::create();

        $this->form->addText('Link', ['validator' => '/[a-zA-Z0-9\-]+/']);
    }
    protected function populate()
    {
        $values = [
            'Link' => $this->entity->getLink(),
        ];

        $this->form->populate($values);

        parent::populate();
    }
    protected function save()
    {
        $values = $this->form->getValues();

        $this->entity->setLink($values['Link']);

        parent::save();
    }
}
