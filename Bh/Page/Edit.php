<?php

namespace Bh\Page;

class Edit extends Backend
{
    // {{{ constructor
    public function __construct($controller, $path)
    {
        $this->stylesheets[] = '/vendor/depage/htmlform/lib/css/depage-forms.css';

        $class = ucfirst($path[1]);
        $formType = 'Bh\Page\Edit' . $class;

        $this->editForm = new $formType($controller, $class, $path[2]);
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->editForm->renderContent();
    }
    // }}}
}
