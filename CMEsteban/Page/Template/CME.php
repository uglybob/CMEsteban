<?php

namespace CMEsteban\Page\Template;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Module\Menu;
use CMEsteban\Lib\Setup;

class CME extends Template
{
    // {{{ constructor
    public function __construct()
    {
        parent::__construct();

        $this->addStylesheet('/vendor/uglybob/cmesteban/CMEsteban/Page/css/cme.css');

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

        $this->addContent('header', $menu);
    }
    // }}}
}
