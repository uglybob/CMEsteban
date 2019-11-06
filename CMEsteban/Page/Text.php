<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\HTML;

class Text extends Home
{
    // {{{ constructor
    public function __construct($path = [], $text)
    {
        $this->text = $this->cleanText($text->getText());
        $this->title = $text->getName();

        parent::__construct($path);
    }
    // }}}

    // {{{ hookConstructor
    protected function hookConstructor()
    {
        parent::hookConstructor();

        $this->addContent('main', $this->text);
    }
    // }}}
}
