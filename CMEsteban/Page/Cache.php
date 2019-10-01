<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\HTML;

class Cache extends Backend
{
    // {{{ renderContent
    public function renderContent()
    {
        $rendered = parent::renderContent();

        if ($this->getPath(1) == 'delete') {
            $result = (\CMEsteban\Lib\Cache::clear()) ? 'Success' : 'Error';
            $rendered .= HTML::div($result);
        }

        return $rendered . (new \CMEsteban\Page\Module\Cache())->render();
    }
    // }}}
}
