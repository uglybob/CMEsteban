<?php

namespace CMEsteban\Page\Module;

class TextTable extends EntityTable
{
    // {{{ getHeading
    public function getHeadings()
    {
        return [
            'Name',
            'Link',
            'Text',
        ];
    }
    // }}}
    // {{{ getRow
    public function getRow($text)
    {
        return [
            $this->shorten($text->getName(), 30),
            $text->getPage(),
            $this->shorten($text->getText(), 30),
        ];
    }
    // }}}
}
