<?php

namespace CMEsteban\Entity;

/**
 * @MappedSuperclass
 **/
abstract class ImageTextEntity extends ImageEntity
{
    /**
     * @ManyToOne(targetEntity="CMEsteban\Entity\Image")
     **/
    protected $image;
    /**
     * @Column(type="text", nullable=true)
     **/
    protected $text;

    public function toHtmlText($createAnchors = true)
    {
        return new \CMEsteban\Page\Module\Text($this, $createAnchors);
    }
}
