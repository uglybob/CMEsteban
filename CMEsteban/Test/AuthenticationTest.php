<?php

namespace CMEsteban\Test;

use CMEsteban\CMEsteban;
use CMEsteban\Entity\User;

class AuthenticationTest extends DatabaseTestCase
{
    // {{{ setUp
    protected function setUp() : void
    {
        parent::setUp();

        $_SESSION = [];

        $this->controller = CMEsteban::$controller;

        $user = new User('userName');
        $user->setPass('cmesteban_test_pass');
        $user->setEmail('user@cmesteban.net');
        $this->save($user);
    }
    // }}}

    // {{{ testLogin
    public function testLogin()
    {
        $this->assertTrue($this->controller->login('userName', 'cmesteban_test_pass'));
        $this->assertEquals('userName', $this->controller->getCurrentUser()->getName());
    }
    // }}}
    // {{{ testLoginFailUser
    public function testLoginFailUser()
    {
        $this->assertFalse($this->controller->login('unknownuser', 'cmesteban_test_pass'));
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

    // {{{ testRegister
    public function testRegister()
    {
        $user = new User('newUserName');
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
        $user = new \CMEsteban\Entity\User('userName');
        $user->setEmail('email@email.com');
        $user->setPass('newUserPass');

        $this->assertFalse($this->controller->editUser($user));
    }
    // }}}
    // {{{ testRegisterDuplicateEmail
    public function testRegisterDuplicateEmail()
    {
        $user = new \CMEsteban\Entity\User('newUserName');
        $user->setEmail('user@cmesteban.net');
        $user->setPass('newUserPass');

        $this->assertFalse($this->controller->editUser($user));
    }
    // }}}

    // {{{ testEditUser
    public function testEditUser()
    {
        $this->assertTrue($this->controller->login('userName', 'cmesteban_test_pass'));

        $user = $this->controller->getCurrentUser();

        $user->setName('newUserName');
        $user->setEmail('email@email.com');
        $user->setPass('newUserPass');

        $this->assertTrue($this->controller->editUser($user));
        $this->controller->logoff();

        $this->assertTrue($this->controller->login('newUserName', 'newUserPass'));
        $this->assertEquals('newUserName', $this->controller->getCurrentUser()->getName());
    }
    // }}}
    // {{{ testEditUserDuplicateName
    public function testEditUserDuplicateName()
    {
        $user = new User('userName2');
        $user->setPass('cmesteban_test_pass');
        $user->setEmail('user2@cmesteban.net');
        $this->save($user);

        $this->assertTrue($this->controller->login('userName', 'cmesteban_test_pass'));

        $user = $this->controller->getCurrentUser();

        $user->setName('userName2');
        $user->setEmail('email@email.com');
        $user->setPass('newUserPass');

        $this->assertFalse($this->controller->editUser($user));
    }
    // }}}
    // {{{ testEditUserDuplicateEmail
    public function testEditUserDuplicateEmail()
    {
        $user = new User('userName2');
        $user->setPass('cmesteban_test_pass');
        $user->setEmail('user2@cmesteban.net');
        $this->save($user);

        $this->assertTrue($this->controller->login('userName', 'cmesteban_test_pass'));

        $user = $this->controller->getCurrentUser();

        $user->setName('newUserName');
        $user->setEmail('user2@cmesteban.net');
        $user->setPass('newUserPass');

        $this->assertFalse($this->controller->editUser($user));
    }
    // }}}
}
