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
        $headings = parent::getHeadings();
        $headings[] = 'Link';

        return $headings;
    }
    // }}}
    // {{{ getRow
    public function getRow()
    {
        $rows = parent::getRow();
        $rows[] = $this->getPage();

        return $rows;
    }
    // }}}
}
