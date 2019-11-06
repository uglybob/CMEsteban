<?php

namespace CMEsteban\Page;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Module\HTML;

class Cache extends Backend
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->addContent('main', new \CMEsteban\Page\Module\Cache());
    }
    // }}}
}
