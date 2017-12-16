<?php

namespace Bh\Test;

use Bh\Page\Page;

class CleanLinksTest extends \PHPUnit\Framework\TestCase
{
    // {{{ setUp
    public function setUp()
    {
        $this->controller = new \Bh\Lib\CustomController();
        $this->page = new Page($this->controller);
    }
    // }}}

    // {{{ testEmpty
    public function testEmpty()
    {
        $testString = '';

        $this->assertEquals($testString, $this->page->cleanText($testString));
    }
    // }}}
    // {{{ testNoLink
    public function testNoLink()
    {
        $testString = 'nolink';

        $this->assertEquals($testString, $this->page->cleanText($testString));
    }
    // }}}
    // {{{ testUrl
    public function testUrl()
    {
        $this->assertEquals('<a href="https://www.url.com">>url.com</a>', $this->page->cleanText('www.url.com'));
    }
    // }}}
    // {{{ testUrlHttp
    public function testUrlHttp()
    {
        $this->assertEquals('<a href="http://www.url.com">>url.com</a>', $this->page->cleanText('http://www.url.com'));
    }
    // }}}
    // {{{ testUrlHttps
    public function testUrlHttps()
    {
        $this->assertEquals('<a href="https://www.url.com">>url.com</a>', $this->page->cleanText('https://www.url.com'));
    }
    // }}}
    // {{{ testUrlMultiple
    public function testUrlMultiple()
    {
        $this->assertEquals('<a href="https://www.url.com">>url.com</a> <a href="https://www.url2.com">>url2.com</a>', $this->page->cleanText('www.url.com www.url2.com'));
    }
    // }}}
    // {{{ testUrlRecursive
    public function testUrlRecursive()
    {
        $this->assertEquals('<a href="https://www.url.com">>url.com</a> <a href="https://www.url.co">>url.co</a>', $this->page->cleanText('www.url.com www.url.co'));
    }
    // }}}
    // {{{ testUrlEnclosed
    public function testUrlEnclosed()
    {
        $this->assertEquals('|<a href="https://www.url.com">>url.com</a>|', $this->page->cleanText('|www.url.com|'));
    }
    // }}}
    // {{{ testUrlKnownSite
    public function testUrlKnownSite()
    {
        $this->assertEquals('<a href="https://www.twitter.com/account">>twitter</a>', $this->page->cleanText('www.twitter.com/account'));
    }
    // }}}

    // {{{ testEmail
    public function testEmail()
    {
        $this->assertEquals('<span class="shooo">nppbhag+ubfg,pbz</span>', $this->page->cleanText('account@host.com'));
    }
    // }}}
    // {{{ testEmailMultiple
    public function testEmailMultiple()
    {
        $this->assertEquals('<span class="shooo">nppbhag+ubfg,pbz</span> <span class="shooo">nppbhag2+ubfg,pbz</span>', $this->page->cleanText('account@host.com account2@host.com'));
    }
    // }}}
    // {{{ testRecursive
    public function testRecursive()
    {
        $this->assertEquals('<span class="shooo">nppbhag+ubfg,pbz</span> <span class="shooo">ppbhag+ubfg,pbz</span>', $this->page->cleanText('account@host.com ccount@host.com'));
    }
    // }}}
    // {{{ testEmailEnclosed
    public function testEnclosed()
    {
        $this->assertEquals('|<span class="shooo">nppbhag+ubfg,pbz</span>|', $this->page->cleanText('|account@host.com|'));
    }
    // }}}
}
