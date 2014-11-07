<?php

namespace BH\Entity;

class ImageMapper extends Mapper
{
    // {{{ constructor
    public function __construct($pdo)
    {
        parent::__construct($pdo);

        $this->class    = 'BH\Entity\Image';
        $this->table    = 'Image';
        $this->columns  = array(
            'alt',
            'path',
        );
    }
    // }}}
    // {{{ save
    public function save($object)
    {
        if (isset($object->tmp)) {
            $tempName   = str_replace('/tmp/depage-form-upload-', '', $object->tmp);
            $fileName   = $tempName . $object->fileName;
            // @todo hard coded image path
            $path       = '/var/www/brausehaus/Images/Content/' . $fileName;

            copy($object->tmp, $path);

            $object->path = $path;
        }
        parent::save($object);
    }
    // }}}
}
