<?php

namespace Bh\Test;

class PageTest extends \PhpUnit_Framework_TestCase
{
    // {{{ setUp
    protected function setUp()
    {
        @session_start();
        $this->controller = new \Bh\Lib\Controller();
 
        parent::setUp();
    }
    // }}}

    // {{{ testPath
    public function testPath()
    {
        $path = ['aaa', 'bbb', 'ccc'];
        $page = new PageTestClass($this->controller, $path);

        $this->assertEquals($path, $page->getPath());
        $this->assertEquals('aaa', $page->getPath(0));
        $this->assertEquals('ccc', $page->getPath(2));

        $this->assertNull($page->getPath(-1));
        $this->assertNull($page->getPath(3));
    }
    // }}}
    // {{{ testPathEmpty
    public function testPathEmpty()
    {
        $page = new PageTestClass($this->controller, []);

        $this->assertEquals([], $page->getPath());

        $this->assertNull($page->getPath(0));
        $this->assertNull($page->getPath(1));
    }
    // }}}
}
