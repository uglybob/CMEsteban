<?php

namespace CMEsteban\Page;

use CMEsteban\Page\Module\HTML;

class Text extends Home
{
    public function __construct($path = [], $text)
    {
        parent::__construct($path);

        $this->title = $text->getName();
        $rendered = HTML::h1($this->title) . $text->getFormattedText();

        $this->addContent('main', $rendered);
    }
}
