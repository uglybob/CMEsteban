<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Page;
use CMEsteban\Page\Module\HTML;

class EditImage extends EditForm
{
    protected function create()
    {
        $this->form->addText('Name', ['required' => true]);
        $this->form->addText('Alt');
        $this->form->addNumber('Level', ['label' => 'Access level', 'required' => true]);
        $this->form->addText('Import', ['label' => 'Import URL']);
        $this->form->addFile('Upload');

        if ($this->entity) {
            $this->form->addHtml(
                HTML::p(
                    HTML::label(
                        HTML::span(['.depage-label'], 'Preview') .
                        $this->entity
                    )
                )
            );
        }
    }
    protected function save()
    {
        $values = $this->form->getValues();

        $this->entity->setName($values['Name']);
        $this->entity->setAlt($values['Alt']);
        $this->entity->setLevel($values['Level']);

        if ($values['Upload']) {
            $this->entity->download($values['Upload'][0]['tmp_name']);
        }

        if ($values['Import']) {
            $this->entity->download($values['Import']);
        }

        parent::save();
    }
    protected function populate()
    {
        $values = [
            'Name' => $this->entity->getName(),
            'Alt' => $this->entity->getAlt(),
            'Level' => $this->entity->getLevel(),
        ];

        $this->form->populate($values);
    }
}
