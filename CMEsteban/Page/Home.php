<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\FilteredEventList;
use CMEsteban\Page\Module\Menu;

class Home extends Page
{
    protected $cacheable = true;

    // {{{ renderContent
    public function renderContent()
    {
        $user = $this->controller->getCurrentUser();

        if ($user) {
            $links = [
                'home' => '/',
                'pages' => 'pages',
                'cache' => 'cache',
                $user->getName() => 'user',
                'logout' => 'login',
            ];
        } else {
            $links = [
                'home' => '/',
                'register' => 'user',
                'login' => 'login',
            ];
        }

        return new Menu($links);
    }
    // }}}
}
