<?php

namespace Bh\Page;

use Bh\Lib\Controller;
use Bh\Page\Module\UserForm;

class User extends Page
{
    // {{{ hookConstructor
    protected function hookConstructor()
    {
        $this->stylesheets[] = '/vendor/depage/htmlform/lib/css/depage-forms.css';
        $this->userForm = new UserForm($this->controller, $this->getPath(1));
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->userForm;
    }
    // }}}
}
