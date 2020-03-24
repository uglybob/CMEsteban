<?php

namespace CMEsteban\Entity;

/**
 * @MappedSuperclass
 **/
abstract class AbstractSimpleText extends Named
{
    /**
     * @Column(type="text", nullable=true)
     **/
    protected $text;
    public function toHtml($createAnchors = true)
    {
        return new \CMEsteban\Page\Module\Text($this, $createAnchors);
    }
}
