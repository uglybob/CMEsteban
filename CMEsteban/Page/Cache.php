<?php

namespace CMEsteban\Page;

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
