<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\EntityList;

class Pages extends Backend
{
    public $title = 'Pages';

    // {{{ renderContent
    public function renderContent()
    {
        return parent::renderContent() . (new EntityList($this, $this->controller->getPages(), 'page', true, 'delete'));
    }
    // }}}
}
