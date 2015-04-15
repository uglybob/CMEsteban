<?php

namespace Bh\Entity;

class NamedEntity extends \Bh\Mapper\Dao
{
    // {{{ daoFields
    public static function daoFields()
    {
        return [
            ['name', 'Text', ['required' => true]],
        ];
    }
    // }}}
}
