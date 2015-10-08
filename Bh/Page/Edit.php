<?php

namespace Bh\Page;

use Bh\Lib\Controller;

class Edit extends Backend
{
    // {{{ hookConstructor
    protected function hookConstructor()
    {
        $this->stylesheets[] = '/vendor/depage/htmlform/lib/css/depage-forms.css';

        $class = ucfirst($this->getPath(1));
        $formType = 'Bh\Page\Edit' . $class;

        $this->editForm = new $formType($this->controller, $class, $this->getPath(2));
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->editForm;
    }
    // }}}
}
