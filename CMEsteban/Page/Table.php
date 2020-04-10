<?php

namespace CMEsteban\Page;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Module\EntityTable;

class Table extends Backend
{
    public function hookConstructor()
    {
        parent::hookConstructor();

        $class = ucfirst($this->getPage()->getPath(1));
        $getter = "get{$class}s";

        $entities = $this->getController()->$getter(true);

        $this->addContent('main', new EntityTable($class, $entities));
    }
}
