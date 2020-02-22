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
        $rendered = HTML::h1($this->title) . $text->getFormattedText();

        $this->addContent('main', $rendered);
    }
    // }}}
}
