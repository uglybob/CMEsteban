<?php

namespace BH\Page;

class EditBand extends Edit
{
    // {{{ handlePath
    protected function handlePath($path)
    {
        $this->id       = array_shift($path);
        $this->class    = 'Band';
    }
    // }}}

    // {{{ addElements
    protected function addElements()
    {
        $this->editForm->addText('Name')->setRequired();
        $this->editForm->addTextArea('Beschreibung');
    }
    // }}}
    // {{{ populateArray
    protected function populateArray()
    {
        return array(
            'Name'          => $this->object->name,
            'Beschreibung'  => $this->object->description,
        );
    }
    // }}}
    // {{{ saveObject
    protected function saveObject()
    {
        $this->object->name         = $this->editForm->getValues()['Name'];
        $this->object->description  = $this->editForm->getValues()['Beschreibung'];
    }
    // }}}

    // {{{ connections
    protected function connections()
    {
        return array('Image' => 'Bild');
    }
    // }}}
}
