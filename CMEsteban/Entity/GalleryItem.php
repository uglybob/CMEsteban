<?php

namespace CMEsteban\Entity;

/**
 * @MappedSuperclass
 **/
abstract class GalleryItem extends ImageEntity
{
    /**
     * @Column(type="integer")
     **/
    protected $position;

    public static function getHeadings()
    {
        return [
            'Name',
            'Position',
        ];
    }
    public function getRow()
    {
        return [
            \CMEsteban\Page\Module\Text::shortenString($this->getName(), 30),
            $this->getPosition(),
        ];
    }
}
