<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\EditObject;

class Edit extends Backend
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->editModule = new EditObject($this->controller, $this);
    }
    // }}}
    // {{{ renderContent
    public function renderContent()
    {
        return parent::renderContent() . $this->editModule;
    }
    // }}}
}
