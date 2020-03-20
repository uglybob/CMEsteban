<?php

namespace CMEsteban\Page;

use CMEsteban\CMEsteban;

class Home extends Page
{
    protected $cacheable = true;

    protected function hookConstructor()
    {
        parent::hookConstructor();

        $this->addContent('main', '');
    }
}
