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
    /**
     * @Column(type="text", nullable=true)
     **/
    protected $text;

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

    public function toHtmlText($createAnchors = true)
    {
        return new \CMEsteban\Page\Module\Text($this, $createAnchors);
    }
}
