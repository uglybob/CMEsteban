<?php

namespace CMEsteban\Test;

use CMEsteban\Page\Module\Text;

class CleanLinksTest extends CMEstebanTestCase
{
    public function testEmpty()
    {
        $testString = '';

        $this->assertEquals($testString, Text::cleanText($testString));
    }
    public function testNoLink()
    {
        $testString = 'nolink';

        $this->assertEquals($testString, Text::cleanText($testString));
    }
    public function testUrl()
    {
        $this->assertEquals('<a href="https://www.url.com">www.url.com</a>', Text::cleanText('www.url.com'));
    }
    public function testUrlHttp()
    {
        $this->assertEquals('<a href="http://www.url.com">www.url.com</a>', Text::cleanText('http://www.url.com'));
    }
    public function testUrlHttps()
    {
        $this->assertEquals('<a href="https://www.url.com">www.url.com</a>', Text::cleanText('https://www.url.com'));
    }
    public function testUrlMultiple()
    {
        $this->assertEquals('<a href="https://www.url.com">www.url.com</a> <a href="https://www.url2.com">www.url2.com</a>', Text::cleanText('www.url.com www.url2.com'));
    }
    public function testUrlRecursive()
    {
        $this->assertEquals('<a href="https://www.url.com">www.url.com</a> <a href="https://www.url.co">www.url.co</a>', Text::cleanText('www.url.com www.url.co'));
    }
    public function testUrlEnclosed()
    {
        $this->assertEquals('|<a href="https://www.url.com">www.url.com</a>|', Text::cleanText('|www.url.com|'));
    }
    public function testUrlShortenUgly()
    {
        $this->assertEquals('<a href="https://encrypted.google.com/search?hl=en&q=php%20url%20info">encrypted.google.com</a>', Text::cleanText('https://encrypted.google.com/search?hl=en&q=php%20url%20info'));
    }
    public function testUrlShortenTrailingSlash()
    {
        $this->assertEquals('<a href="http://www.url.com/">www.url.com</a>', Text::cleanText('http://www.url.com/'));
    }

    public function testEmail()
    {
        $this->assertEquals('<span class="shooo">nppbhag+ubfg,pbz</span>', Text::cleanText('account@host.com'));
    }
    public function testEmailMultiple()
    {
        $this->assertEquals('<span class="shooo">nppbhag+ubfg,pbz</span> <span class="shooo">nppbhag2+ubfg,pbz</span>', Text::cleanText('account@host.com account2@host.com'));
    }
    public function testEmailRecursive()
    {
        $this->assertEquals('<span class="shooo">nppbhag+ubfg,pbz</span> <span class="shooo">ppbhag+ubfg,pbz</span>', Text::cleanText('account@host.com ccount@host.com'));
    }
    public function testEnclosed()
    {
        $this->assertEquals('|<span class="shooo">nppbhag+ubfg,pbz</span>|', Text::cleanText('|account@host.com|'));
    }

    public function testMixed()
    {
        $this->assertEquals('<span class="shooo">nppbhag+ubfg,pbz</span> <a href="https://www.url.com">url.com</a>', Text::cleanText('account@host.com www.url.com'));
    }

    public function testLineBreak()
    {
        $this->assertEquals('<br />', Text::cleanText("\n"));
    }
}
