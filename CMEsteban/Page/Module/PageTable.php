<?php

namespace CMEsteban\Page\Module;

class PageTable extends EntityTable
{
    // {{{ constructor
    public function __construct($pages)
    {
        parent::__construct($pages, 'page', true, 'delete');
    }
    // }}}

    // {{{ getProperties
    public function getProperties($page)
    {
        return [
            'request' => $page->getRequest(),
            'page' => $page->getPage(),
        ];
    }
    // }}}
}
