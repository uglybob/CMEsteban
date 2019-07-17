<?php

class CMEstebanTest extends \PHPUnit\Framework\TestCase
{
    // {{{ setUp
    protected function setUp()
    {
        @session_start();
        $this->controller = new CMEsteban\Lib\Controller();
 
        parent::setUp();
    }
    // }}}

    // {{{ testCMEstebanDefault
    public function testCMEstebanDefault()
    {
        $this->expectOutputString('Page not found: home');
        $cmesteban = new \CMEsteban\CMEsteban();
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
