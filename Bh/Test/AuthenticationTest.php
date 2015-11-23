<?php

namespace Bh\Test;

class AuthenticationTest extends DatabaseTestCase
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
        $this->controller->login('userName', 'bh_test_pass');
        $this->assertEquals('userName', $this->controller->getCurrentUser()->getName());
    }
    // }}}
    // {{{ testLoginFailUser
    public function testLoginFailUser()
    {
        $this->controller->login('unknownuser', 'bh_test_pass');
        $this->assertNull($this->controller->getCurrentUser());
    }
    // }}}
    // {{{ testLoginFailPass
    public function testLoginFailPass()
    {
        $this->controller->login('userName', 'wrong_pass');
        $this->assertNull($this->controller->getCurrentUser());
    }
    // }}}
}
