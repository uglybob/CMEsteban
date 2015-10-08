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
        $this->controller->login('user@bh.net', 'bh_test_pass');
        $this->assertEquals('user@bh.net', $this->controller->getCurrentUser()->getEmail());
    }
    // }}}
    // {{{ testLoginFailUser
    public function testLoginFailUser()
    {
        $this->controller->login('unknownuser@bh.net', 'bh_test_pass');
        $this->assertNull($this->controller->getCurrentUser());
    }
    // }}}
    // {{{ testLoginFailPass
    public function testLoginFailPass()
    {
        $this->controller->login('user@bh.net', 'wrong_pass');
        $this->assertNull($this->controller->getCurrentUser());
    }
    // }}}
    // {{{ testLoginUpperCase
    public function testLoginUpperCase()
    {
        $this->controller->login('User@Bh.Net', 'bh_test_pass');
        $this->assertEquals('user@bh.net', $this->controller->getCurrentUser()->getEmail());
    }
    // }}}
}
