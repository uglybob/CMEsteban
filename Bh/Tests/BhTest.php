<?php

class BhTest extends PhpUnit_Framework_TestCase
{
    // {{{ setUp
    protected function setUp()
    {
        @session_start();
        $this->controller = new Bh\Lib\Controller();
 
        parent::setUp();
    }
    // }}}

    // {{{ testBh
    public function testBh()
    {
        $this->expectOutputString('This is a home mockup');
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

    // {{{ testGetPage
    public function testGetPage()
    {
        $this->assertEquals('This is a home mockup', $this->controller->getPageByRequest(null)->render());
    }
    // }}}
}
