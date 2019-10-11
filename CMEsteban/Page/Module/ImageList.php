<?php

namespace CMEsteban\Page\Module;

class ImageList extends EntityList
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
