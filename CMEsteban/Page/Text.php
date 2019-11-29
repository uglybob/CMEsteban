<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\HTML;

class Text extends Home
{
    // {{{ constructor
    public function __construct($path = [], $text)
    {
        parent::__construct($path);

        $this->title = $text->getName();
        $this->text = $this->cleanText($text->getText());
        $this->addContent('main', $this->text);
    }
    // }}}
}
