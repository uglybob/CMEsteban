<?php

namespace Bh\Page;

use Bh\Lib\Controller;

class Edit extends Backend
{
    // {{{ hookConstructor
    protected function hookConstructor()
    {
        $this->stylesheets[] = '/vendor/depage/htmlform/lib/css/depage-forms.css';

        $this->class = ucfirst($this->getPath(1));
        $formType = 'Bh\Page\Edit' . $this->class;

        $this->editForm = new $formType($this->controller, $this->class, $this->getPath(2));

        $this->title = "edit $this->class";
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->editForm;
    }
    // }}}
}
