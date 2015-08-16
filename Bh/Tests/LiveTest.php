<?php

namespace Bh\Tests;

class LiveTest extends DatabaseTestCase
{
    // {{{ setUp
    protected function setUp()
    {
        $this->controller = new \Bh\Lib\Controller();
 
        parent::setUp();
    }
    // }}}

    // {{{ testLogin
    public function testLogin()
    {
        $this->controller->login('user@bh.net', 'bh_test_pass');
        $this->assertEquals('user@bh.net', $this->controller->getCurrentUser()->getEmail());
    }
    // }}}
}
