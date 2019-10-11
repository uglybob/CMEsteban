<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\EditEntity;

class Edit extends Backend
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->editModule = new EditEntity($this->controller, $this);
    }
    // }}}
    // {{{ renderContent
    public function renderContent()
    {
        return parent::renderContent() . $this->editModule;
    }
    // }}}
}
