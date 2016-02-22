<?php

namespace Bh\Page;

use Bh\Lib\Controller;
use Bh\Page\Module\ObjectList;

class Pages extends Backend
{
    // {{{ constructor
    public function __construct(Controller $controller, array $path)
    {
        parent::__construct($controller, $path);

        $this->list = new ObjectList($this->controller->getPages(), 'page');
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->list->__toString();
    }
    // }}}
}
