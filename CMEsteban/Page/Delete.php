<?php

namespace CMEsteban\Page;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Module\DeleteEntity;

class Delete extends Backend
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        CMEsteban::$template->addContent('main', new DeleteEntity());
    }
    // }}}
}
