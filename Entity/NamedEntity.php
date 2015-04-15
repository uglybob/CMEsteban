<?php

namespace Bh\Entity;

class NamedEntity extends Dao
{
    // {{{ daoFields
    public function daoFields()
    {
        return [
            ['name', 'Text', ['required' => true]],
        ];
    }
    // }}}
}
