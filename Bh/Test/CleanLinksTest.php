<?php

namespace Bh\Test;

use Bh\Page\Page;

class CleanLinksTest extends \PHPUnit\Framework\TestCase
{
    // {{{ testEmpty
    public function testEmpty()
    {
        $testString = '';

        $this->assertEquals($testString, Page::cleanLinks($testString));
    }
    // }}}
    // {{{ testNoLink
    public function testNoLink()
    {
        $testString = 'nolink';

        $this->assertEquals($testString, Page::cleanLinks($testString));
    }
    // }}}
    // {{{ testUrl
    public function testUrl()
    {
        $this->assertEquals('<a href="https://www.url.com">>url.com</a>', Page::cleanLinks('www.url.com'));
    }
    // }}}
}
