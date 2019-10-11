<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\Page\Page;

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
    }
    // }}}
    // {{{ save
    protected function save()
    {
        $values = $this->form->getValues();

        $this->controller->editImage($this->entity);
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
        Page::redirect('/Images');
    }
    // }}}
}
