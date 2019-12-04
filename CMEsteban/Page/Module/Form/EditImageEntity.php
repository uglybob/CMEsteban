<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\CMEsteban;
use CMEsteban\Lib\Mapper;
use CMEsteban\Page\Page;
use CMEsteban\Page\Module\HTML;

abstract class EditImageEntity extends EditForm
{
    // {{{ create
    protected function create()
    {
        $this->form->addText('Name', ['required' => true]);

        if ($this->image) {
            $this->form->addHtml(
                HTML::p(
                    HTML::label(
                        HTML::span(['.depage-label'], 'Preview') .
                        $this->image
                    )
                )
            );
        }

        $this->form->addFile('Upload');
    }
    // }}}
    // {{{ populate
    protected function populate()
    {
        $values = [
            'Name' => $this->entity->getName(),
        ];

        $this->form->populate($values);
    }
    // }}}
    // {{{ save
    protected function save()
    {
        $values = $this->form->getValues();
        $name = $values['Name'];

        $this->entity->setName($name);

        $this->image->setName($name . '_image');
        $this->image->setAlt("$name Image");

        if ($values['Upload']) {
            $this->image->download($values['Upload'][0]['tmp_name']);
        } else {
            $this->entity->setImage($this->image);
        }

        $this->entity->save();
        $this->image->save();

        Mapper::commit();
    }
    // }}}

    // {{{ loadEntity
    protected function loadEntity()
    {
        parent::loadEntity();

        if ($this->entity) {
            $this->image = $this->entity->getImage();
        }
    }
    // }}}
    // {{{ instantiateEntity
    protected function instantiateEntity()
    {
        parent::instantiateEntity();

        $this->image = new \CMEsteban\Entity\Image('');

        $this->entity->setImage($this->image);
    }
    // }}}
}
