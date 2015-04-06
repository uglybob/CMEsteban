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

        $images = $this->controller->getMapper('Image')->getAll();
        $list = array('null' => 'auswählen');
        foreach($images as $image) {
            $list[$image->id] = $image->name;
        }
        $this->editForm->addSingle('Bild', array('skin' => 'select', 'list' => $list));
    }
    // }}}
    // {{{ populateForm
    protected function populateForm()
    {
        $this->editForm->populate(
            array(
                'Name'          => $this->object->name,
                'Beschreibung'  => $this->object->description,
                'Bild'          => $this->object->image,
            )
        );
    }
    // }}}
    // {{{ saveForm
    protected function saveForm()
    {
        $this->object->name         = $this->editForm->getValues()['Name'];
        $this->object->description  = $this->editForm->getValues()['Beschreibung'];
        $this->object->image        = $this->editForm->getValues()['Bild'];
    }
    // }}}
}
