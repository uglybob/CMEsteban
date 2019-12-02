<?php

namespace CMEsteban\Entity;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Module\HTML;

class Image extends Named
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

    // {{{ setName
    public function setName($new)
    {
        if (
            $this->getName()
            && $new != $this->getName()
        ) {
            $oldPath = $this->getSrc(true);

            $path = CMEsteban::$setup->getSettings('Path');

            if (file_exists($oldPath)) {
                $ext = $this->getExtension();

                if (substr(strtolower($new), - strlen($ext)) != $ext) {
                    $new = "$name$ext";
                }

                $newPath = $path . '/CMEsteban/Images/' . $new;

                rename($oldPath, $newPath);
            }
        }

        parent::setName($new);
    }
    // }}}
    // {{{ getExtension
    public function getExtension($url = '')
    {
        if (!$url) {
            $url = $this->getSrc(true);
        }

        $info = getimagesize($url);

        return image_type_to_extension($info[2]);
    }
    // }}}
    // {{{ getProperName
    public function getProperName($url = '')
    {
        $ext = $this->getExtension($url);
        $name = $this->getName();

        if (substr(strtolower($name), - strlen($ext)) != $ext) {
            $name = "$name$ext";
        }

        return $name;
    }
    // }}}
    // {{{ download
    public function download($url)
    {
        $img = file_get_contents($url);
        $this->name = $this->getProperName($url);

        return file_put_contents($this->getSrc(true), $img);
    }
    // }}}

    // {{{ getSrc
    public function getSrc($internal = false)
    {
        $path = ($internal) ? CMEsteban::$setup->getSettings('Path') : '';

        if ($this->level == 0) {
            $src = $path . '/CMEsteban/Images/' . $this->getName();
        } else {
            $src = $path . '/CMEsteban/PrivateImages/' . $this->getName();
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
