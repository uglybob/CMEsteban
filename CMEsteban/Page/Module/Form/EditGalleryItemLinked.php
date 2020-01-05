<?php

namespace CMEsteban\Page\Module\Form;

abstract class EditGalleryItemLinked extends EditGalleryItem
{
    // {{{ create
    protected function create()
    {
        parent::create();

        $this->form->addText('Link', ['required' => true]);
    }
    // }}}
    // {{{ populate
    protected function populate()
    {
        parent::populate();

        $values = [
            'Link' => $this->entity->getLink(),
        ];

        $this->form->populate($values);
    }
    // }}}
    // {{{ save
    protected function save()
    {
        $values = $this->form->getValues();

        $this->entity->setLink($values['Link']);

        parent::save();
    }
    // }}}
}
