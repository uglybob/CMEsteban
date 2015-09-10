<?php

namespace Bh\Page;

use Bh\Lib\Controller;

class Login extends Page
{
    // {{{ constructor
    public function __construct(Controller $controller, array $path)
    {
        parent::__construct($controller, $path);

        $this->stylesheets[] = '/vendor/depage/htmlform/lib/css/depage-forms.css';

        $this->title = 'login';

        $this->form = new LoginForm($this->controller);
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->form->__toString();
    }
    // }}}
}
