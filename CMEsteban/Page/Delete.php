<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\DeleteObject;

class Delete extends Backend
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->deleteModule = new DeleteObject($this->controller, $this);
    }
    // }}}
    // {{{ renderContent
    public function renderContent()
    {
        return parent::renderContent() . $this->deleteModule;
    }
    // }}}
}
