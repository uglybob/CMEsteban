<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\PageTable;

class Pages extends Backend
{
    // {{{ renderContent
    public function renderContent()
    {
        return parent::renderContent() . (new PageTable($this, $this->controller->getPages()));
    }
    // }}}
}
