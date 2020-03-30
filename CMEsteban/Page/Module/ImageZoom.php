<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

class ImageZoom extends Module
{
    public function __construct($image, $width = null, $height = -1)
    {

        $this->image = $image;
        $this->width = $width;
        $this->height = $height;

        CMEsteban::$template->addStylesheet(CMEsteban::$setup->getSettings('PathCme') . '/CMEsteban/Page/css/image-zoom.css');

        parent::__construct();
    }

    protected function render()
    {
        $src = (is_null($this->width)) ? $this->image->getSrc() : $this->image->getSrcDimensions($this->width, $this->height);

        return HTML::div(['.cimg-zoom'],
            HTML::div(
                [
                    'class' => 'image',
                    'style' => 'background-image: url(\'' . $src . '\');',
                ]
            )
        );
    }
}
