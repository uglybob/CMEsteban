<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Page;
use Depage\HtmlForm\HtmlForm;

class Login extends Form
{
    // {{{ constructor
    public function __construct()
    {
        parent::__construct();

        $user = CMEsteban::$controller->getCurrentUser();

        if ($user) {
            $this->form = new HtmlForm('login', ['label' => 'logout']);
        } else {
            $this->form = new HtmlForm('login', ['label' => 'login']);
            $this->form->addText('User');
            $this->form->addPassword('Pass');
        }

        $this->form->process();

        if ($this->form->validate()) {
            if ($user) {
                CMEsteban::$controller->logoff();
            } else {
                $values = $this->form->getValues();
                CMEsteban::$controller->login($values['User'], $values['Pass']);
            }

            $this->form->clearSession();
            Page::redirect('/');
        }
    }
    // }}}
}
