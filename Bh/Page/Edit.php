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

        $class = ucfirst($path[1]);
        $formType = 'Bh\Page\Edit' . $class;

        $id = isset($path[2]) ? $path[2] : null;
        $this->editForm = new $formType($controller, $class, $id);
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->editForm->__toString();
    }
    // }}}
}
