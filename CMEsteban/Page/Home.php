<?php

namespace CMEsteban\Page;

class Home extends Page
{
    protected $cacheable = true;

    protected function hookConstructor()
    {
        parent::hookConstructor();

        $this->addContent('main', '');
    }
}
