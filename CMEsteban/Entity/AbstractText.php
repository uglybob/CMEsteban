<?php

namespace CMEsteban\Entity;

/**
 * @MappedSuperclass
 **/
abstract class AbstractText extends AbstractSimpleText
{
    /**
     * @Column(type="string", unique=true, nullable=true)
     **/
    protected $link;

    public static function getHeadings()
    {
        $headings = parent::getHeadings();
        $headings[] = 'Link';

        return $headings;
    }
    public function getRow()
    {
        $rows = parent::getRow();
        $rows[] = $this->getLink();

        return $rows;
    }

}
