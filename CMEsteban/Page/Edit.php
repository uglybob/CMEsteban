<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\EditEntity;
use CMEsteban\CMEsteban;

class Edit extends Backend
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->addContent('main', new EditEntity($this, CMEsteban::$controller));
    }
    // }}}
}
