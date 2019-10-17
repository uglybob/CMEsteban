<?php

namespace CMEsteban\Page;

use CMEsteban\CMEsteban;

class Home extends Page
{
    protected $cacheable = true;

    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $user = CMEsteban::$controller->getCurrentUser();
        $name = ($user) ? $user->getName() : '';

        CMEsteban::$template->addContent('main', "hi $name :)");
    }
    // }}}
}
