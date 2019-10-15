<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\HTML;

class Cache extends Backend
{
    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->template->addContent('main', new \CMEsteban\Page\Module\Cache($this, $this->controller));
    }
    // }}}
}
