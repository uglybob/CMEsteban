<?php

namespace CMEsteban\Page;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Module\TextList;

class Texts extends Backend
{
    public $title = 'Texts';

    // {{{ renderContent
    public function renderContent()
    {
        return new TextList(CMEsteban::$controller->getTexts(), 'Text', false, 'delete');
    }
    // }}}
}
