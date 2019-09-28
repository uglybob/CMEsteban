<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\ObjectList;

class Pages extends Backend
{
    public $title = 'Pages';

    // {{{ renderContent
    public function renderContent()
    {
        return new ObjectList($this, $this->controller->getPages(), 'page', true, 'delete');
    }
    // }}}
}
