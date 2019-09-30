<?php

namespace CMEsteban\Page;

class Login extends Page
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->loginModule = new \CMEsteban\Page\Module\Login($this->controller, $this);
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
