<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\Login;

class Login extends Page
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->loginModule = new Login($this->controller, $this);
        $this->cacheable = false;
        $this->title = 'Login';
    }
    // }}}
    // {{{ renderContent
    public function renderContent()
    {
        return $this->loginModule;
    }
    // }}}
}
