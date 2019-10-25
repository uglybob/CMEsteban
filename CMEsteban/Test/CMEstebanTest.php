<?php

namespace CMEsteban\Test;

class CMEstebanTest extends CMEstebanTestCase
{
    // {{{ testCMEstebanDefault
    public function testCMEstebanDefault()
    {
        $this->expectOutputString('Page not found: home');

        $setup = new \CMEsteban\Lib\Setup();
        \CMEsteban\CMEsteban::start($setup);
    }
    // }}}
    // {{{ testCMEstebanCustomController
    public function testCMEstebanCustomController()
    {
        $this->expectOutputString('This is a custom controller page.');

        $setup = new \CMEsteban\Lib\Setup();
        $setup->testController = new \CMEsteban\Lib\CustomController();

        \CMEsteban\CMEsteban::start($setup);
    }
    // }}}
}
