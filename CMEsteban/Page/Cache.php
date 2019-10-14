<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\HTML;

class Cache extends Backend
{
    // {{{ renderContent
    public function renderContent()
    {
        return parent::renderContent() . (new \CMEsteban\Page\Module\Cache($this, $this->controller));
    }
    // }}}
}
