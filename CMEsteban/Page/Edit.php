<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\EditEntity;

class Edit extends Backend
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->addContent('main', new EditEntity());
    }
    // }}}
}
