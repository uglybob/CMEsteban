<?php

namespace Bh\Entity;

use Bh\Page\Module\HTML;

class Image extends Named
{
    protected $alt;
    protected $src;
    protected $private;

    // {{{ constructor
    public function __construct($name, $private = false, $src = null, $alt = null)
    {
        parent::__construct($name);

        $this->private = $private;
        $this->src = $src;
        $this->alt = $alt;
    }
    // }}}

    // {{{ toString
    public function __toString()
    {
        if ($this->private) {
            try {
                //$image = imagecreatefromjpeg($this->src);
                //header('Content-Type: image/jpeg');
                //$src = imagejpeg($image);
            } catch (\Exception $e) {
                $src = '';
            }
        } else {
            $src = $this->src;
        }

        $attributes = ['src' => $src];

        if ($this->alt) {
            $attributes['alt'] = $this->alt;
        }

        try {
            $image = HTML::img($attributes);
        } catch (\Exception $e) {
            $image = '';
        }
    }
    // }}}
}
