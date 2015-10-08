<?php

namespace Bh\Page;

use Bh\Lib\Controller;

class Edit extends Backend
{
    // {{{ constructor
    public function __construct(Controller $controller, array $path)
    {
        parent::__construct($controller, $path);

        $this->stylesheets[] = '/vendor/depage/htmlform/lib/css/depage-forms.css';

        $class = ucfirst($this->getPath(1));
        $formType = 'Bh\Page\Edit' . $class;

        $this->editForm = new $formType($controller, $class, $this->getPath(2));
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->editForm;
    }
    // }}}
}
