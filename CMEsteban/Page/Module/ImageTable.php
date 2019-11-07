<?php

namespace CMEsteban\Page\Module;

class ImageTable extends EntityTable
{
    // {{{ getProperties
    public function getProperties($image)
    {
        return [
            'Name' => $this->shorten($image->getName(), 30),
            'Alt' => $this->shorten($image->getAlt(), 40),
        ];
    }
    // }}}
}
