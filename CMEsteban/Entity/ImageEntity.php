<?php

namespace CMEsteban\Entity;

/**
 * @MappedSuperclass
 **/
abstract class ImageEntity extends Named
{
    /**
     * @ManyToOne(targetEntity="CMEsteban\Entity\Image")
     **/
    protected $image;
}
