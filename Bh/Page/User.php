<?php

namespace Bh\Page;

use Bh\Lib\Controller;

class User extends Page
{
    // {{{ hookConstructor
    protected function hookConstructor()
    {
        $this->stylesheets[] = '/vendor/depage/htmlform/lib/css/depage-forms.css';
        $this->registrationForm = new UserForm($this->controller, $this->getPath(1));
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->registrationForm;
    }
    // }}}
}
