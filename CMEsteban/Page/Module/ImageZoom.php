<?php

namespace CMEsteban\Page\Module;

class ImageZoom extends Module
{
    public function __construct($image, $width = null, $height = -1)
    {
        $this->image = $image;
        $this->width = $width;
        $this->height = $height;

        parent::__construct();
    }

    protected function addStylesheets()
    {
        $this->addStylesheet('/CMEsteban/Page/css/image-zoom.css', true);
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
