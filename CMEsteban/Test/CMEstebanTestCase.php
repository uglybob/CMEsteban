<?php

namespace CMEsteban\Test;

use CMEsteban\CMEsteban;
use CMEsteban\Lib\Setup;
use CMEsteban\Lib\Controller;

class CMEstebanTestCase extends \PHPUnit\Framework\TestCase
{
    // {{{ setUp
    protected function setUp() : void
    {
        CMEsteban::$setup = new Setup();
        CMEsteban::$controller = new Controller();
        CMEsteban::$page = new PageTestClass();
        CMEsteban::$template = new TemplateTestClass;
    }
    // }}}
    // {{{ tearDown
    protected function tearDown() : void
    {
        CMEsteban::$instance = null;
        CMEsteban::$setup = null;
        CMEsteban::$controller = null;
        CMEsteban::$page = null;
        CMEsteban::$template = null;
    }
    // }}}
}
