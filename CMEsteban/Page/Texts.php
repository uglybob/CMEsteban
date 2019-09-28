<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\TextList;

class Texts extends Backend
{
    public $title = 'Texts';

    // {{{ renderContent
    public function renderContent()
    {
        return new TextList($this, $this->controller->getTexts(), 'Text', false, 'delete');
    }
    // }}}
}
