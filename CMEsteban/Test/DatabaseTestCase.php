<?php

namespace CMEsteban\Test;

use CMEsteban\Lib\Mapper;

class DatabaseTestCase extends \PHPUnit\Framework\TestCase
{
    // {{{ setUp
    protected function setUp() : void
    {
        $em = Mapper::getEntityManager();
        $em->beginTransaction();
    }
    // }}}
    // {{{ tearDown
    protected function tearDown() : void
    {
        $em = Mapper::getEntityManager();
        $em->rollback();
    }
    // }}}
}
