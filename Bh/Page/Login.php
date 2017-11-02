<?php

namespace Bh\Page;

use Bh\Lib\Controller;
use Bh\Page\Module\LoginForm;

class Login extends Page
{
    // {{{ hookConstructor
    protected function hookConstructor()
    {
        $this->stylesheets[] = '/vendor/depage/htmlform/lib/css/depage-forms.css';

        $this->title = 'login';
        $this->form = new LoginForm($this->controller);
        $this->cacheable = false;
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->form->__toString();
    }
    // }}}
}
