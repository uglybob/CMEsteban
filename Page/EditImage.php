<?php

namespace Bh\Page;

use Bh\Lib\Html;

class EditImage extends Edit
{
    // {{{ handlePath
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
        $this->object->tmp = $this->form->getValues()['Bild'][0]['tmp_name'];
        $this->object->fileName = $this->form->getValues()['Bild'][0]['name'];

        parent::saveForm();
    }
    // }}}
}
