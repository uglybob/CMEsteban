<?php

namespace CMEsteban\Page\Module;

class TextTable extends EntityTable
{
    // {{{ getProperties
    public function getProperties($text)
    {
        return [
            'Name' => $this->shorten($text->getName(), 30),
            'Link' => $text->getPage(),
            'Text' => $this->shorten($text->getText(), 30),
        ];
    }
    // }}}
}
