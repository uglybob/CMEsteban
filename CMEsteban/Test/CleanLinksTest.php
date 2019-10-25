<?php

namespace CMEsteban\Test;

use CMEsteban\Page\Page;

class CleanLinksTest extends CMEstebanTestCase
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
    // {{{ testUrlShortenKnown
    public function testUrlShortenKnown()
    {
        $this->assertEquals('<a href="https://www.twitter.com/account">>twitter</a>', Page::cleanText('www.twitter.com/account'));
    }
    // }}}
    // {{{ testUrlShortenKnownInParams
    public function testUrlShortenKnownInParams()
    {
        $this->assertEquals('<a href="https://www.url.com/twitter">>url.com/twitter</a>', Page::cleanText('www.url.com/twitter'));
    }
    // }}}
    // {{{ testUrlShortenUgly
    public function testUrlShortenUgly()
    {
        $this->assertEquals('<a href="https://encrypted.google.com/search?hl=en&q=php%20url%20info">>encrypted.google.com/search?hl...</a>', Page::cleanText('https://encrypted.google.com/search?hl=en&q=php%20url%20info'));
    }
    // }}}
    // {{{ testUrlShortenTrailingSlash
    public function testUrlShortenTrailingSlash()
    {
        $this->assertEquals('<a href="http://www.url.com/">>url.com</a>', Page::cleanText('http://www.url.com/'));
    }
    // }}}

    // {{{ testEmail
    public function testEmail()
    {
        $this->assertEquals('<span class="shooo">nppbhag+ubfg,pbz</span>', Page::cleanText('account@host.com'));
    }
    // }}}
    // {{{ testEmailMultiple
    public function testEmailMultiple()
    {
        $this->assertEquals('<span class="shooo">nppbhag+ubfg,pbz</span> <span class="shooo">nppbhag2+ubfg,pbz</span>', Page::cleanText('account@host.com account2@host.com'));
    }
    // }}}
    // {{{ testEmailRecursive
    public function testEmailRecursive()
    {
        $this->assertEquals('<span class="shooo">nppbhag+ubfg,pbz</span> <span class="shooo">ppbhag+ubfg,pbz</span>', Page::cleanText('account@host.com ccount@host.com'));
    }
    // }}}
    // {{{ testEmailEnclosed
    public function testEnclosed()
    {
        $this->assertEquals('|<span class="shooo">nppbhag+ubfg,pbz</span>|', Page::cleanText('|account@host.com|'));
    }
    // }}}

    // {{{ testMixed
    public function testMixed()
    {
        $this->assertEquals('<span class="shooo">nppbhag+ubfg,pbz</span> <a href="https://www.url.com">>url.com</a>', Page::cleanText('account@host.com www.url.com'));
    }
    // }}}

    // {{{ testLineBreak
    public function testLineBreak()
    {
        $this->assertEquals('<br />', Page::cleanText("\n"));
    }
    // }}}
}
