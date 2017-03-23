<?php

namespace Bh\Entity;

use Bh\Page\Module\HTML;

class Image extends Named
{
    protected $alt;
    protected $src;
    protected $level;

    // {{{ constructor
    public function __construct($name, $level = 0, $src = null, $alt = null)
    {
        parent::__construct($name);

        $this->level = $level;
        $this->src = $src;
        $this->alt = $alt;
    }
    // }}}

    // {{{ toString
    public function __toString()
    {
        if ($this->level == 0) {
            $src = $this->src;
        } else {
            $src = '/image/' . $this->getId();
        }

        $attributes = ['src' => $src];

        if ($this->alt) {
            $attributes['alt'] = $this->alt;
        }

        return HTML::img($attributes);
    }
    // }}}
}
