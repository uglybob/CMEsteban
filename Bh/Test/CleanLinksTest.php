<?php

namespace Bh\Test;

use Bh\Page\Page;

class CleanLinksTest extends \PHPUnit\Framework\TestCase
{
    // {{{ testEmpty
    public function testEmpty()
    {
        $testString = '';

        $this->assertEquals($testString, Page::cleanText($testString));
    }
    // }}}
    // {{{ testNoLink
    public function testNoLink()
    {
        $testString = 'nolink';

        $this->assertEquals($testString, Page::cleanText($testString));
    }
    // }}}
    // {{{ testUrl
    public function testUrl()
    {
        $this->assertEquals('<a href="https://www.url.com">>url.com</a>', Page::cleanText('www.url.com'));
    }
    // }}}
    // {{{ testUrlHttp
    public function testUrlHttp()
    {
        $this->assertEquals('<a href="http://www.url.com">>url.com</a>', Page::cleanText('http://www.url.com'));
    }
    // }}}
    // {{{ testUrlHttps
    public function testUrlHttps()
    {
        $this->assertEquals('<a href="https://www.url.com">>url.com</a>', Page::cleanText('https://www.url.com'));
    }
    // }}}
    // {{{ testUrlMultiple
    public function testUrlMultiple()
    {
        $this->assertEquals('<a href="https://www.url.com">>url.com</a> <a href="https://www.url2.com">>url2.com</a>', Page::cleanText('www.url.com www.url2.com'));
    }
    // }}}
    // {{{ testUrlRecursive
    public function testUrlRecursive()
    {
        $this->assertEquals('<a href="https://www.url.com">>url.com</a> <a href="https://www.url.co">>url.co</a>', Page::cleanText('www.url.com www.url.co'));
    }
    // }}}
    // {{{ testUrlEnclosed
    public function testUrlEnclosed()
    {
        $this->assertEquals('|<a href="https://www.url.com">>url.com</a>|', Page::cleanText('|www.url.com|'));
    }
    // }}}
    // {{{ testUrlKnownSite
    public function testUrlKnownSite()
    {
        $this->assertEquals('<a href="https://www.twitter.com/account">>twitter</a>', Page::cleanText('www.twitter.com/account'));
    }
    // }}}
}
