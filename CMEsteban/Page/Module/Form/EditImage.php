<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\CMEsteban;
use CMEsteban\Lib\Mapper;
use CMEsteban\Page\Page;
use CMEsteban\Page\Module\HTML;

class EditImage extends EditForm
{
    // {{{ create
    protected function create()
    {
        $this->form->addText('Name');
        $this->form->addText('Alt');
        $this->form->addText('Import');
        $this->form->addText('Level');
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
    // }}}
    // {{{ save
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

        $this->entity->save();
        Mapper::commit();

    }
    // }}}
    // {{{ populate
    protected function populate()
    {
        $values = [
            'Name' => $this->entity->getName(),
            'Alt' => $this->entity->getAlt(),
            'Level' => $this->entity->getLevel(),
        ];

        $this->form->populate($values);
    }
    // }}}

    // {{{ redirect
    protected function redirect()
    {
        Page::redirect('/images');
    }
    // }}}

    // {{{ instantiateEntity
    protected function instantiateEntity()
    {
        $this->entity = new \CMEsteban\Entity\Image('');
    }
    // }}}
}
