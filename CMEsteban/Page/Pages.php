<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\PageTable;

class Pages extends Backend
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->template->addContent('main', new PageTable($this, $this->controller->getPages()));
    }
    // }}}
}
