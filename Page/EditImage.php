<?php

namespace BH\Page;

use BH\Lib\HTML;

class EditImage extends Edit
{
    protected function handlePath($path)
    {
        $this->id       = array_shift($path);
        $this->class    = 'Image';
    }

    // {{{ createForm
    protected function createForm()
    {
        $this->editForm->addText('Name')->setRequired();
        $this->editForm->addText('Beschreibung');
        $this->editForm->addFile('Bild')->setRequired();;
    }
    // }}}
    // {{{ populateForm
    protected function populateForm()
    {
        $this->editForm->addHtml(HTML::img('src="/' . $this->object->path . '"'));
        $this->editForm->populate(
            array(
                'Name'          => $this->object->name,
                'Beschreibung'  => $this->object->alt,
                'Bild'          => $this->object->path,
            )
        );
    }
    // }}}
    // {{{ saveForm
    protected function saveForm()
    {
        $this->object->name     = $this->editForm->getValues()['Name'];
        $this->object->alt      = $this->editForm->getValues()['Beschreibung'];
        $this->object->tmp      = $this->editForm->getValues()['Bild'][0]['tmp_name'];
        $this->object->fileName = $this->editForm->getValues()['Bild'][0]['name'];
    }
    // }}}
}
