<?php

namespace CMEsteban\Test;

use CMEsteban\Lib\Mapper;

class DatabaseTestCase extends \PHPUnit\Framework\TestCase
{
    // {{{ setUp
    protected function setUp() : void
    {
        Mapper::reset();
    }
    // }}}

    // {{{ insertData
    protected function insertData($data)
    {
        Mapper::insertData($data);
    }
    // }}}
}
