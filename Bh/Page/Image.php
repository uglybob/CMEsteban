<?php

namespace Bh\Page;

use Bh\Page\Module\HTML;
use Bh\Lib\Mapper;

class Image extends Page
{
    // {{{ render
    public function render()
    {
        $object = $this->controller->getImage($this->getPath(1));

        if ($object->getLevel() == 0) {
            $this->redirect($object->getSrc());
        }

        $path = $object->getSrc();
        $path = ltrim($path, '/');
        $image = imagecreatefromjpeg($path);

        header('Content-Type: image/jpeg');

        return imagejpeg($image);
    }
    // }}}
}
