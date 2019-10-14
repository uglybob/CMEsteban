<?php

namespace CMEsteban\Page;

class Login extends Home
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->loginModule = new \CMEsteban\Page\Module\Login($this, $this->controller);
        $this->cacheable = false;
        $this->title = 'Login';
    }
    // }}}
    // {{{ renderContent
    public function renderContent()
    {
        return parent::renderContent() . $this->loginModule;
    }
    // }}}
}
