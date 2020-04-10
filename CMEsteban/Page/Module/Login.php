<?php

namespace CMEsteban\Page\Module;

use CMEsteban\Page\Page;
use Depage\HtmlForm\HtmlForm;

class Login extends Form
{
    protected function prepare()
    {
        $user = $this->getController()->getCurrentUser();

        if ($user) {
            $this->form = new HtmlForm('login', ['label' => 'logout']);
        } else {
            $this->form = new HtmlForm('login', ['label' => 'login']);
            $this->form->addText('User', ['required' => true]);
            $this->form->addPassword('Pass');
        }

        $this->form->process();

        if ($this->form->validate()) {
            if ($user) {
                $this->getController()->logoff();
                $this->form->clearSession();
                Page::redirect('/');
            } else {
                $values = $this->form->getValues();

                if ($this->getController()->login($values['User'], $values['Pass'])) {
                    $this->form->clearSession();
                    Page::redirect('/');
                } else {
                    $this->form->addHtml('Wrong user name or password');
                    $this->form->clearSession();
                }
            }
        }
    }
}
