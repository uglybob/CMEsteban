<?php

namespace CMEsteban\Page\Module;

class ImageTable extends EntityTable
{
    // {{{ getHeadings
    public function getHeadings()
    {
        return [
            'Name',
            'Alt',
        ];
    }
    // }}}
    // {{{ getRow
    public function getRow($image)
    {
        return [
            $this->shorten($image->getName(), 30),
            $this->shorten($image->getAlt(), 40),
        ];
    }
    // }}}
}
