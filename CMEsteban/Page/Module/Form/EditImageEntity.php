<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\CMEsteban;
use CMEsteban\Lib\Mapper;
use CMEsteban\Page\Page;
use CMEsteban\Page\Module\HTML;

abstract class EditImageEntity extends EditForm
{
    protected $image;
    protected function create()
    {
        parent::create();

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
    protected function populate()
    {
        parent::populate();

        $values = [
            'Name' => $this->entity->getName(),
        ];

        $this->form->populate($values);
    }
    protected function save()
    {
        $values = $this->form->getValues();
        $name = $values['Name'];

        $this->entity->setName($name);
        $this->image->setName($name . '_image');
        $this->image->setAlt("$name Image");

        if ($values['Upload']) {
            $this->image->download($values['Upload'][0]['tmp_name']);
        }

        $this->image->fixExtension();
        $this->entity->setImage($this->image);

        $this->image->save();
        $this->entity->save();

        parent::save();
    }

    protected function loadEntity()
    {
        parent::loadEntity();

        if ($this->entity) {
            if (is_null($this->entity->getImage())) {
                $this->instantiateImage();
            } else {
                $this->image = $this->entity->getImage();
            }
        }
    }
    protected function instantiateEntity()
    {
        parent::instantiateEntity();

        $this->instantiateImage();
    }

    protected function instantiateImage()
    {
        $this->image = new \CMEsteban\Entity\Image('');
        $this->entity->setImage($this->image);
    }
}
