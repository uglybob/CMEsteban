<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\PageTable;
use CMEsteban\CMEsteban;

class Pages extends Backend
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        CMEsteban::$template->addContent('main', new PageTable(CMEsteban::$controller->getPages()));
    }
    // }}}
}
