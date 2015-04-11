<?php

namespace Bh\Entity;

class ImageMapper extends Mapper
{
    // {{{ constructor
    public function __construct($pdo)
    {
        parent::__construct($pdo);

        $this->class = 'BH\Entity\Image';
        $this->table = 'Image';

        $this->addField(new Field('name',   'Text',         'Name',         array('required' => true)));
        $this->addField(new Field('alt',    'TextArea',     'Beschreibung'));
        $this->addField(new Field('path',   'File',         'Bild',         array('required' => true)));
    }
    // }}}
    // {{{ save
    public function save($object)
    {
        if (isset($object->tmp)) {
            // @todo hard coded image path
            $tempName   = str_replace('/tmp/depage-form-upload-', '', $object->tmp);
            $fileName   = $tempName . $object->fileName;
            // @todo hard coded image path
            $path       = 'Images/Content/' . $fileName;

            if (copy($object->tmp, $path)) {
                $object->path = $path;
            } else {
                throw new \Bh\Exceptions\PermissionsException();
            }

        }
        parent::save($object);
    }
    // }}}
}
