<?php

namespace Bh\Page;

use Bh\Lib\Controller;

class Login extends Backend
{
    // {{{ constructor
    public function __construct(Controller $controller, array $path)
    {
        $this->stylesheets[] = '/vendor/depage/htmlform/lib/css/depage-forms.css';

        $this->controller = $controller;
        $this->title = 'login';

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
                $this->controller->logoff();
            } else {
                $values = $this->form->getValues();
                $this->controller->login($values['Email'], $values['Pass']);
            }

            $this->form->clearSession();
            Page::redirect('/');
        }
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->form->__toString();
    }
    // }}}
}
