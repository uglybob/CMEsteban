<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\DeleteEntity;

class Delete extends Backend
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->addContent('main', new DeleteEntity());
    }
    // }}}
}
