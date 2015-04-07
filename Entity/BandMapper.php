<?php

namespace BH\Entity;

class BandMapper extends Mapper
{
    // {{{ constructor
    public function __construct($pdo)
    {
        parent::__construct($pdo);

        $this->class = 'BH\Entity\Band';
        $this->table = 'Band';

        $this->addField(new Field('name',         'Text',         'Name',         array('required' => true)));
        $this->addField(new Field('description',  'TextArea',     'Beschreibung'));
        $this->addField(new Field('image',        'Connection',   'Bild'));
    }
    // }}}
}
