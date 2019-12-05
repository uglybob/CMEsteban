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
        ];
    }
    // }}}
    // {{{ getRow
    public function getRow($text)
    {
        return [
            $this->shorten($text->getName(), 30),
            $text->getPage(),
        ];
    }
    // }}}
}
