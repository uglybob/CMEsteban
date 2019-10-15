<?php

namespace CMEsteban\Page;

class User extends Home
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->template->addContent('main', new \CMEsteban\Page\Module\User($this, $this->controller));
        $this->cacheable = false;

        $user = $this->controller->getCurrentUser();

        if ($user) {
            $this->title = $user->getName();
        } else {
            $this->title = 'register';
        }
    }
    // }}}
}
