<?php

namespace BH\Page;

class EditImage extends Edit
{
    public function __construct($controller, $path)
    {
        parent::__construct($controller, $path);
    }

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
        $this->editForm->populate(
            array(
                'Name'          => $this->{$this->class}->name,
                'Beschreibung'  => $this->{$this->class}->alt,
                'Bild'          => $this->{$this->class}->path,
            )
        );
    }
    // }}}
    // {{{ saveForm
    protected function saveForm()
    {
        $this->{$this->class}->name     = $this->editForm->getValues()['Name'];
        $this->{$this->class}->alt      = $this->editForm->getValues()['Beschreibung'];
        $this->{$this->class}->tmp      = $this->editForm->getValues()['Bild'][0]['tmp_name'];
        $this->{$this->class}->fileName = $this->editForm->getValues()['Bild'][0]['name'];
    }
    // }}}
}
