<?php

namespace CMEsteban\Entity;

use CMEsteban\Page\Module\HTML;
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

    public function __construct($name, $level = 0, $alt = null)
    {
        parent::__construct($name);

        $this->level = $level;
        $this->alt = $alt;
    }

    public function setName($new)
    {
        $oldPath = $this->getSrc(true);

        if (
            $this->getName()
            && $new
            && $new != $this->getName()
            && file_exists($oldPath)
        ) {
            $path = $this->getSetup()->getSettings('Path');
            $newPath = $path . '/CMEsteban/Images/' . $new;

            rename($oldPath, $newPath);
        }

        parent::setName($new);
    }
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
    public function download($url)
    {
        $img = file_get_contents($url);

        file_put_contents($this->getSrc(true), $img);

        $this->fixExtension();
    }

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

    public function isAvailable()
    {
        return file_exists($this->getSrc(true));
    }
    public function getFilemtime()
    {
        return filemtime($this->getSrc(true));
    }
    public function getSrc($internal = false)
    {
        $path = ($internal) ? $this->getSetup()->getSettings('Path') : '';

        if ($this->level == 0) {
            $src = $path . '/CMEsteban/Images/' . $this->getName();
        } else {
            $src = $path . '/CMEsteban/PrivateImages/' . $this->getName();
        }

        $src .= ($internal) ? '' : $this->getFilemtime();

        return $src;

    }
    public function getSrcDimensions($width, $height = -1)
    {
        $info = pathinfo($this->getName());
        $name = $info['filename'];
        $filename = $name . $width . 'x' . $height . '.jpg';
        $cache = $this->getFrontCache();
        $result = $cache->getLink($filename, true);

        if ($result) {
            $result .= '?' . $this->getFilemtime();
        } else {
            try {
                $resource = $this::imagecreatefromfile($this->getSrc(true));
                $scaled = imagescale($resource, $width , $height);

                ob_start();
                imagejpeg($scaled);
                $imageString = ob_get_clean();

                if ($cache->write($filename, $imageString)) {
                    $result = $cache->getLink($filename, true) . '?' . $this->getFilemtime();
                } else {
                    $result = $this->getSrc();
                }
            } catch (\Exception $e) {
                $result = $this->getSrc();
            }
        }

        return $result;
    }

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
    public function __toString()
    {
        return $this->toHtml();
    }

    public static function getHeadings()
    {
        return [
            'Name',
            'Alt',
        ];
    }
    public function getRow()
    {
        return [
            \CMEsteban\Page\Module\Text::shortenString($this->getName(), 30),
            \CMEsteban\Page\Module\Text::shortenString($this->getAlt(), 40),
        ];
    }
}
