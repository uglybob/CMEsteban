<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\EntityTable;

class Pages extends Backend
{
    public $title = 'Pages';

    // {{{ renderContent
    public function renderContent()
    {
        return parent::renderContent() . (new EntityTable($this, $this->controller->getPages(), 'page', true, 'delete'));
    }
    // }}}
}
