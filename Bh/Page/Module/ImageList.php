<?php

namespace Bh\Page\Module;

class ImageList extends ObjectList
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
