<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

class ImageZoom extends Module
{
    // {{{ constructor
    public function __construct($image)
    {
        parent::__construct();

        $this->image = $image;
        CMEsteban::$template->addStylesheet(CMEsteban::$setup->getSettings('PathCme') . '/CMEsteban/Page/css/image-zoom.css');
    }
    // }}}
    // {{{ toString
    public function __toString()
    {
        return HTML::div(['.cimg-zoom'],
            HTML::div(
                [
                    'class' => 'image',
                    'style' => 'background-image: url(\'' . $this->image->getSrc() . '\');',
                ]
            )
        );
    }
    // }}}
}
