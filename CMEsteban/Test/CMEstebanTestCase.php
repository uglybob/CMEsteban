<?php

namespace CMEsteban\Test;

use CMEsteban\CMEsteban;

class CMEstebanTestCase extends \PHPUnit\Framework\TestCase
{
    // {{{ tearDown
    protected function tearDown() : void
    {
        CMEsteban::$setup = null;
        CMEsteban::$controller = null;
        CMEsteban::$page = null;
        CMEsteban::$template = null;
    }
    // }}}
}
