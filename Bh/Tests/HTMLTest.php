<?php

use Bh\Page\HTML;

class HTMLTest extends PhpUnit_Framework_TestCase
{
    protected $tags = ['html', 'title', 'head', 'body', 'a', 'p', 'label', 'img', 'div', 'span'];

    // {{{ testTags
    public function testTags()
    {
        foreach ($this->tags as $tag) {
            $this->assertEquals("<$tag/>", HTML::$tag());
            $this->assertEquals("<$tag/>", HTML::$tag(''));
            $this->assertEquals("<$tag/>", HTML::$tag(null));
            $this->assertEquals("<$tag>content</$tag>", HTML::$tag('content'));
            $this->assertEquals("<$tag name=\"value\"/>", HTML::$tag(['name' => 'value']));
            $this->assertEquals("<$tag name=\"value\" anotherName=\"anotherValue\"/>", HTML::$tag(['name' => 'value', 'anotherName' => 'anotherValue']));
            $this->assertEquals("<$tag name=\"value\"/>", HTML::$tag(['name' => 'value']), '');
            $this->assertEquals("<$tag name=\"value\"/>", HTML::$tag(['name' => 'value']), null);
            $this->assertEquals("<$tag name=\"value\" anotherName=\"anotherValue\">content</$tag>", HTML::$tag(['name' => 'value', 'anotherName' => 'anotherValue'], 'content'));
        }
    }
    // }}}
    // {{{ 
    /**
     * @expectedException           Exception
     * @expectedExceptionMessage    invalid tag signature
     */
    public function testSignatureException()
    {
        HTML::html('content', 'content');
    }
    // }}}
}
