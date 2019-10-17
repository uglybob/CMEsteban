<?php

namespace CMEsteban\Page;

use CMEsteban\CMEsteban;

class User extends Home
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        CMEsteban::$template->addContent('main', new \CMEsteban\Page\Module\User());
        $this->cacheable = false;

        $user = CMEsteban::$controller->getCurrentUser();

        if ($user) {
            $this->title = $user->getName();
        } else {
            $this->title = 'register';
        }
    }
    // }}}
}
