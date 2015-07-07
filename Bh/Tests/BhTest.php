<?php

class BhTest extends PhpUnit_Framework_TestCase
{
    // {{{ setUp
    protected function setUp()
    {
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
}
