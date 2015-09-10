<?php

namespace Bh\Page;

use Bh\Lib\Controller;

class LoginForm
{
    // {{{ constructor
    public function __construct($controller)
    {
        $user = $controller->getCurrentUser();

        if ($user) {
            $this->form = new \Depage\HtmlForm\HtmlForm('login', ['label' => 'logoff']);
        } else {
            $this->form = new \Depage\HtmlForm\HtmlForm('login', ['label' => 'login']);
            $this->form->addEmail('Email');
            $this->form->addPassword('Pass');
        }

        $this->form->process();

        if ($this->form->validate()) {
            if ($user) {
                $controller->logoff();
            } else {
                $values = $this->form->getValues();
                $controller->login($values['Email'], $values['Pass']);
            }

            $this->form->clearSession();
            Page::redirect('/');
        }
    }
    // }}}

    // {{{ toString
    public function __toString()
    {
        return $this->form->__toString();
    }
    // }}}
}
