<?php

namespace CMEsteban\Entity;

use CMEsteban\Page\Page;

/**
 * @MappedSuperclass
 **/
abstract class GalleryItem extends ImageEntity
{
    /**
     * @Column(type="integer")
     **/
    protected $position;
    /**
     * @Column(type="text", nullable=true)
     **/
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
