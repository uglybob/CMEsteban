<?php

namespace CMEsteban\Page;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Module\EntityTable;

class Table extends Backend
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $class = ucfirst(CMEsteban::$page->getPath(1));
        $getter = "get{$class}s";

        $entities = CMEsteban::$controller->$getter(true);

        $this->addContent('main', new EntityTable($class, $entities));
    }
    // }}}
}
