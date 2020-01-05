<?php

namespace CMEsteban\Entity;

use CMEsteban\Page\Page;

abstract class GalleryItem extends ImageEntity
{
    protected $position;
    protected $text;

    // {{{ getHeading
    public static function getHeadings()
    {
        return [
            'Name',
            'Position',
        ];
    }
    // }}}
    // {{{ getRow
    public function getRow()
    {
        return [
            Page::shortenString($this->getName(), 30),
            $this->getPosition(),
        ];
    }
    // }}}
}
