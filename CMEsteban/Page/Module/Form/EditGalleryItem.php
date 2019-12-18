<?php

namespace CMEsteban\Page\Module\Form;

class EditGalleryItem extends EditImageEntity
{
    // {{{ create
    protected function create()
    {
        parent::create();

        $this->form->addNumber('Position');
        $this->form->addTextarea('Description');
    }
    // }}}
    // {{{ populate
    protected function populate()
    {
        parent::populate();

        $values = [
            'Position' => $this->entity->getPosition(),
            'Description' => $this->entity->getDescription(),
        ];

        $this->form->populate($values);
    }
    // }}}
    // {{{ save
    protected function save()
    {
        $values = $this->form->getValues();

        $this->entity->setPosition($values['Position']);
        $this->entity->setDescription($values['Description']);

        parent::save();
    }
    // }}}
}
