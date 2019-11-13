<?php

namespace CMEsteban\Page;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Module\TextTable;

class Texts extends Backend
{
    public $title = 'Texts';

    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->addContent('main', new TextTable(CMEsteban::$controller->getTexts(true), 'Text', true, 'delete'));
    }
    // }}}
}
