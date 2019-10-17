<?php

class CMEstebanTest extends \PHPUnit\Framework\TestCase
{
    // {{{ setUp
    protected function setUp() : void
    {
        $this->controller = new CMEsteban\Lib\Controller();
 
        parent::setUp();
    }
    // }}}

    // {{{ testCMEstebanDefault
    public function testCMEstebanDefault()
    {
        $this->expectOutputString('Page not found: home');
        \CMEsteban\CMEsteban::init();
    }
    // }}}
    // {{{ testCMEstebanCustomController
    public function testCMEstebanCustomController()
    {
        $customController = new \CMEsteban\Lib\CustomController();

        $this->expectOutputString('This is a custom controller page.');
        $cmesteban = new \CMEsteban\CMEsteban($customController);
    }
    // }}}
}
