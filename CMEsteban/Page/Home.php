<?php

namespace CMEsteban\Page;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Module\Menu;
use CMEsteban\Lib\Setup;

class Home extends Page
{
    protected $cacheable = true;

    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $user = CMEsteban::$controller->getCurrentUser();
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
                'login' => '/login',
            ];

            if (Setup::getSettings('EnableRegistration')) {
                $links['register'] = '/user';
            }
        }

        $menu = new Menu($links);

        CMEsteban::$template->addContent('header', $menu);
        CMEsteban::$template->addContent('main', "hi $name :)");
    }
    // }}}
}
