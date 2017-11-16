<?php

namespace Bh\Page\Module;

use Bh\Page\Page;
use Depage\HtmlForm\HtmlForm;

class Login extends Form
{
    // {{{ constructor
    public function __construct($controller, $page)
    {
        parent::__construct($controller, $page);

        $user = $controller->getCurrentUser();

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
                $controller->logoff();
            } else {
                $values = $this->form->getValues();
                $controller->login($values['User'], $values['Pass']);
            }

            $this->form->clearSession();
            Page::redirect('/');
        }
    }
    // }}}
}
