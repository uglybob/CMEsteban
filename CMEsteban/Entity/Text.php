<?php

namespace CMEsteban\Entity;

use CMEsteban\Page\Page;

class Text extends Named
{
    protected $text;
    protected $page;

    // {{{ getHeading
    public static function getHeadings()
    {
        return [
            'Name',
            'Link',
        ];
    }
    // }}}
    // {{{ getRow
    public function getRow()
    {
        return [
            Page::shortenString($this->getName(), 30),
            $this->getPage(),
        ];
    }
    // }}}
}
