<?php

namespace CMEsteban\Entity;

/**
 * @Entity
 * @Table(name="texts")
 **/
class Text extends Named
{
    /**
     * @Column(type="text")
     **/
    protected $text;
    /**
     * @Column(type="string", unique=true)
     **/
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
