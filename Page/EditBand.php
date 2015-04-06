<?php

namespace BH\Page;

class EditBand extends Edit
{
    public function __construct($controller, $path)
    {
        parent::__construct($controller, $path);
    }

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

        $list = array();
        foreach($images as $image) {
            $list[$image->id] = $image->name;
        }
        var_dump($list);
        $this->editForm->addSingle('Bild', array('list' => $list));
    }
    // }}}
    // {{{ populateForm
    protected function populateForm()
    {
        $this->editForm->populate(
            array(
                'Name'          => $this->{$this->class}->name,
                'Beschreibung'  => $this->{$this->class}->description,
                'Bild'          => $this->{$this->class}->image,
            )
        );
    }
    // }}}
    // {{{ saveForm
    protected function saveForm()
    {
        $this->{$this->class}->name         = $this->editForm->getValues()['Name'];
        $this->{$this->class}->description  = $this->editForm->getValues()['Beschreibung'];
        $this->{$this->class}->description  = $this->editForm->getValues()['Bild'];
    }
    // }}}
}
