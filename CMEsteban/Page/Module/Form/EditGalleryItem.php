<?php

namespace CMEsteban\Page\Module\Form;

abstract class EditGalleryItem extends EditImageEntity
{
    protected function create()
    {
        parent::create();

        $this->form->addNumber('Position');
        $this->form->addTextarea('Text');
    }
    protected function populate()
    {
        parent::populate();

        $values = [
            'Position' => $this->entity->getPosition(),
            'Text' => $this->entity->getText(),
        ];

        $this->form->populate($values);
    }
    protected function save()
    {
        $values = $this->form->getValues();

        $this->entity->setPosition($values['Position']);
        $this->entity->setText($values['Text']);

        parent::save();
    }
}
