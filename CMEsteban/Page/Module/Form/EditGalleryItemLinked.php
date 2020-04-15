<?php

namespace CMEsteban\Page\Module\Form;

abstract class EditGalleryItemLinked extends EditGalleryItem
{
    protected function create()
    {
        parent::create();

        $this->form->addText('Link', ['validator' => '/[a-zA-Z0-9\-]+/']);
    }
    protected function populate()
    {
        parent::populate();

        $values = [
            'Link' => $this->entity->getLink(),
        ];

        $this->form->populate($values);
    }
    protected function save()
    {
        $values = $this->form->getValues();

        $this->entity->setLink($values['Link']);

        parent::save();
    }
}
