<?php

namespace CMEsteban\Page;

use CMEsteban\CMEsteban;

class Image extends Page
{
    // {{{ render
    public function render()
    {
        $image = CMEsteban::$controller->getImage($this->getPath(1));

        if ($image->getLevel() == 0) {
            $this->redirect($image->getSrc());
        }

        $path = ltrim($image->getSrc(), '/')
        $resource = imagecreatefromjpeg($path);

        header('Content-Type: image/jpeg');

        return imagejpeg($resource);
    }
    // }}}
}
