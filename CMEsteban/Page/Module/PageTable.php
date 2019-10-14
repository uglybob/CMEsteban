<?php

namespace CMEsteban\Page\Module;

class PageTable extends EntityTable
{
    // {{{ constructor
    public function __construct($page, $pages)
    {
        parent::__construct($page, $pages, 'page', true, 'delete');
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
