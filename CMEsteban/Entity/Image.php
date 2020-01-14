<?php

namespace CMEsteban\Entity;

use CMEsteban\CMEsteban;
use CMEsteban\Lib\Cache;
use CMEsteban\Page\Module\HTML;
use CMEsteban\Page\Page;
use CMEsteban\Exception\EntityException;

/**
 * @Table(name="images")
 * @Entity
 **/
class Image extends Named
{
    /**
     * @Column(type="string", nullable=true)
     **/
    protected $alt;
    /**
     * @Column(type="integer")
     **/
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
        $oldPath = $this->getSrc(true);

        if (
            $this->getName()
            && $new
            && $new != $this->getName()
            && file_exists($oldPath)
        ) {
            $path = CMEsteban::$setup->getSettings('Path');
            $newPath = $path . '/CMEsteban/Images/' . $new;

            rename($oldPath, $newPath);
        }

        parent::setName($new);
    }
    // }}}
    // {{{ fixExtension
    public function fixExtension()
    {
        $info = getimagesize($this->getSrc(true));
        $ext = image_type_to_extension($info[2]);
        $name = $this->getName();

        if (substr(strtolower($name), - strlen($ext)) != $ext) {
            $name = "$name$ext";
        }

        $this->setName($name);
    }
    // }}}
    // {{{ download
    public function download($url)
    {
        $img = file_get_contents($url);

        file_put_contents($this->getSrc(true), $img);

        $this->fixExtension();
    }
    // }}}

    // {{{ imagecreatefromfile
    protected static function imagecreatefromfile($filename) {
        if (!file_exists($filename)) {
            throw new EntityException("File \"$filename\" not found.");
        }

        switch (strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
            case 'jpeg':
            case 'jpg':
                return imagecreatefromjpeg($filename);
            break;

            case 'png':
                return imagecreatefrompng($filename);
            break;

            case 'gif':
                return imagecreatefromgif($filename);
            break;

            default:
                throw new EntityException("File \"$filename\" is not valid jpg, png or gif image.");
            break;
        }
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
    // {{{ getSrcDimensions
    public function getSrcDimensions($width, $height = -1)
    {
        $info = pathinfo($this->getName());
        $name = $info['filename'];
        $filename = $name . $width . 'x' . $height . '.jpg';
        $path = Cache::getFilename($filename);

        if (!file_exists($path)) {
            $resource = $this::imagecreatefromfile($this->getSrc(true));
            $scaled = imagescale($resource, $width , $height);
            Cache::storeImage($filename, $scaled);
        }

        return $path;
    }
    // }}}

    // {{{ toHtml
    public function toHtml($width = null, $height = -1)
    {
        if (is_null($width)) {
            $attributes = ['src' => $this->getSrc()];
        } else {
            $attributes = ['src' => $this->getSrcDimensions($width, $height)];
        }

        if ($this->alt) {
            $attributes['alt'] = $this->alt;
        }

        return HTML::img($attributes);
    }
    // }}}
    // {{{ toString
    public function __toString()
    {
        return $this->toHtml();
    }
    // }}}

    // {{{ getHeadings
    public static function getHeadings()
    {
        return [
            'Name',
            'Alt',
        ];
    }
    // }}}
    // {{{ getRow
    public function getRow()
    {
        return [
            Page::shortenString($this->getName(), 30),
            Page::shortenString($this->getAlt(), 40),
        ];
    }
    // }}}
}
