<?php

namespace BH\Page;

use BH\Lib\HTML;

class EditImage extends Edit
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
                'name' => 'alt',
                'label' => 'Beschreibung',
                'input' => 'TextArea',
            ),
            array(
                'name' => 'path',
                'label' => 'Bild',
                'input' => 'File',
                'params' => array('required' => true),
            ),
        );

        parent::__construct($controller, $path);
    }
    // }}}

   // {{{ constructor
    protected function handlePath($path)
    {
        $this->id = array_shift($path);
        $this->class = 'Image';
    }
    // }}}

    // {{{ populateForm
    protected function populateForm()
    {
        parent::populateForm();
        $this->form->addHtml(HTML::img('src="/' . $this->object->path . '"'));
    }
    // }}}
    // {{{ saveForm
    protected function saveForm()
    {
        $this->object->tmp      = $this->form->getValues()['Bild'][0]['tmp_name'];
        $this->object->fileName = $this->form->getValues()['Bild'][0]['name'];

        parent::saveForm();
    }
    // }}}
}
