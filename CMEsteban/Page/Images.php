<?php

namespace CMEsteban\Page;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Module\ImageTable;

class Images extends Backend
{
    public $title = 'Images';

    // {{{ hookConstructor
    public function hookConstructor()
    {
        parent::hookConstructor();

        $this->addContent('main', new ImageTable(CMEsteban::$controller->getImages(), 'Image', true, 'delete'));
    }
    // }}}
}
