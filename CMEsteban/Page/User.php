<?php

namespace CMEsteban\Page;

use CMEsteban\CMEsteban;

class User extends Home
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->cacheable = false;
        $this->addContent('main', new \CMEsteban\Page\Module\User());

        $user = CMEsteban::$controller->getCurrentUser();

        if ($user) {
            $this->title = $user->getName();
        } else {
            $this->title = 'register';
        }
    }
    // }}}
}
