<?php

namespace Bh\Mapper;

class Image extends NamedEntity
{
    // {{{ constructor
    public function __construct($controller)
    {
        $this->addField(new Field('alt',    'TextArea',     'Beschreibung'));
        $this->addField(new Field('path',   'File',         'Bild',         array('required' => true)));

        parent::__construct($controller);
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
                throw new \Bh\Exceptions\FileSystemException();
            }

        }
        parent::save($object);
    }
    // }}}
}
