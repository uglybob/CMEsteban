<?php

namespace BH\Page;

class EditBand extends Edit
{
    protected function handlePath($path)
    {
        $this->id       = array_shift($path);
        $this->class    = 'Band';
    }

    // {{{ createForm
    protected function createForm()
    {
        $this->editForm->addText('Name')->setRequired();
        $this->editForm->addTextArea('Beschreibung');
        $this->editForm->addFile('Bild');
    }
    // }}}
    // {{{ populateForm
    protected function populateForm()
    {
        $this->editForm->populate(
            array(
                'Name'          => $this->object->name,
                'Beschreibung'  => $this->object->description,
            )
        );
    }
    // }}}
    // {{{ saveForm
    protected function saveForm()
    {
        $this->object->name         = $this->editForm->getValues()['Name'];
        $this->object->description  = $this->editForm->getValues()['Beschreibung'];
    }
    // }}}
}
