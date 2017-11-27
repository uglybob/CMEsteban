<?php

namespace Bh\Page\Module\Form;

use Bh\Page\Page;

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

        $this->controller->editImage($this->object);
    }
    // }}}
    // {{{ populate
    protected function populate()
    {
        $values = [
            'Name' => $this->object->getName(),
            'Alt' => $this->object->getAlt(),
            'Level' => $this->object->getLevel(),
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
