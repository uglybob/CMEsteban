<?php

namespace Bh\Mapper;

class Page extends Dao
{
    // {{{ daoFields
    public static function daoFields()
    {
        return [
            ['request', 'Text'],
            ['page',    'Text'],
        ];
    }
    // }}}
}
