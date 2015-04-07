<?php

namespace BH\Page;

class EditBand extends Edit
{
    // {{{ constructor
    public function __construct($controller, $path)
    {
        $this->fields = array(
            array(
                'name' => 'name',
                'label' => 'Name',
                'input' => 'Text',
                'params' => array('required' => true),
            ),
            array(
                'name' => 'description',
                'label' => 'Beschreibung',
                'input' => 'TextArea',
            ),
            array(
                'name' => 'image',
                'label' => 'Bild',
                'input' => 'Connection',
            ),
        );

        parent::__construct($controller, $path);
    }
    // }}}

    // {{{ handlePath
    protected function handlePath($path)
    {
        $this->id = array_shift($path);
        $this->class = 'Band';
    }
    // }}}
}
