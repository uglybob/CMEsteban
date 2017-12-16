<?php

class BhTest extends \PHPUnit\Framework\TestCase
{
    // {{{ setUp
    protected function setUp()
    {
        @session_start();
        $this->controller = new Bh\Lib\Controller();
 
        parent::setUp();
    }
    // }}}

    // {{{ testBhDefault
    public function testBhDefault()
    {
        $this->expectOutputString('Page not found: home');
        $bh = new \Bh\Bh();
    }
    // }}}
    // {{{ testBhCustomController
    public function testBhCustomController()
    {
        $customController = new \Bh\Lib\CustomController();

        $this->expectOutputString('This is a custom controller page.');
        $bh = new \Bh\Bh($customController);
    }
    // }}}
}
