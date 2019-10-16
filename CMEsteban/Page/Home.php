<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\Menu;

class Home extends Page
{
    protected $cacheable = true;

    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $user = $this->controller->getCurrentUser();
        $name = '';

        if ($user) {
            $name = $user->getName();
            $links = [
                'home' => '/',
                'pages' => '/pages',
                'cache' => '/cache',
                $name => '/user',
                'logout' => '/login',
            ];
        } else {
            $links = [
                'home' => '/',
                'register' => '/user',
                'login' => '/login',
            ];
        }

        $menu = new Menu($this, $links);

        $this->template->addContent('header', $menu);
        $this->template->addContent('main', "hi $name :)");
    }
    // }}}
}
