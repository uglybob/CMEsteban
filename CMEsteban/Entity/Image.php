<?php

namespace CMEsteban\Entity;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Module\HTML;

abstract class Image extends Named
{
    protected $alt;
    protected $level;

    // {{{ constructor
    public function __construct($name, $level = 0, $alt = null)
    {
        parent::__construct($name);

        $this->level = $level;
        $this->alt = $alt;
    }
    // }}}

    // {{{ download
    public function download($url)
    {
        $img = file_get_contents($url);

        return file_put_contents($this->getSrc(true), $img);
    }
    // }}}

    // {{{ getSrc
    public function getSrc($internal = false)
    {
        $path = ($internal) ? CMEsteban::$setup->getSettings('Path') : '/';

        if ($this->level == 0) {
            $src = $path . 'CMEsteban/Images/' . $this->getName();
        } else {
            $src = $path . 'CMEsteban/PrivateImages/' . $this->getName();
        }

        return $src;

    }
    // }}}

    // {{{ toString
    public function __toString()
    {
        $attributes = ['src' => $this->getSrc()];

        if ($this->alt) {
            $attributes['alt'] = $this->alt;
        }

        return HTML::img($attributes);
    }
    // }}}
}
