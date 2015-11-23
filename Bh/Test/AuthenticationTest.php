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

    // {{{ testRegister
    public function testRegister()
    {
        $user = new \Bh\Entity\User('newUserName');
        $user->setEmail('email@email.com');
        $user->setPass('newUserPass');

        $this->assertTrue($this->controller->editUser($user));

        $this->assertTrue($this->controller->login('newUserName', 'newUserPass'));
        $this->assertEquals('newUserName', $this->controller->getCurrentUser()->getName());
    }
    // }}}
    // {{{ testRegisterDuplicateName
    public function testRegisterDuplicateName()
    {
        $user = new \Bh\Entity\User('userName');
        $user->setEmail('email@email.com');
        $user->setPass('newUserPass');

        $this->assertFalse($this->controller->editUser($user));
    }
    // }}}
    // {{{ testRegisterDuplicateEmail
    public function testRegisterDuplicateEmail()
    {
        $user = new \Bh\Entity\User('newUserName');
        $user->setEmail('user@bh.net');
        $user->setPass('newUserPass');

        $this->assertFalse($this->controller->editUser($user));
    }
    // }}}

    // {{{ testLogin
    public function testLogin()
    {
        $this->assertTrue($this->controller->login('userName', 'bh_test_pass'));
        $this->assertEquals('userName', $this->controller->getCurrentUser()->getName());
    }
    // }}}
    // {{{ testLoginFailUser
    public function testLoginFailUser()
    {
        $this->assertFalse($this->controller->login('unknownuser', 'bh_test_pass'));
        $this->assertNull($this->controller->getCurrentUser());
    }
    // }}}
    // {{{ testLoginFailPass
    public function testLoginFailPass()
    {
        $this->assertFalse($this->controller->login('userName', 'wrong_pass'));
        $this->assertNull($this->controller->getCurrentUser());
    }
    // }}}
}
