<?php

namespace Bh\Entity;

class Image extends NamedEntity
{
    // {{{ constructor
    public function __construct()
    {
        $this->addField('alt',  'TextArea');
        $this->addField('path', 'File',     ['required' => true]);
    }
    // }}}
    // {{{ save
    public function save($object)
    {
        // @todo move to dao
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
