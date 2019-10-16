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

        if ($user) {
            $links = [
                'home' => '/',
                'pages' => '/pages',
                'cache' => '/cache',
                $user->getName() => '/user',
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
        $this->template->addContent('main', 'hi :)');
    }
    // }}}
}
