<?php

namespace CMEsteban\Page\Module;

class ImageTable extends EntityTable
{
    // {{{ getProperties
    public function getProperties($image)
    {
        return [
            'Name' => $image->getName(),
            'Alt' => $image->getAlt(),
        ];
    }
    // }}}
}
