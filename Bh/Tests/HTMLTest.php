<?php

use Bh\Page\HTML;

class HTMLTest extends PhpUnit_Framework_TestCase
{
    protected $nonVoidTags = ['html', 'title', 'head', 'body', 'a', 'p', 'label', 'div', 'span'];
    protected $voidTags = ['img', 'meta', 'link'];

    // {{{ testNonVoidTags
    public function testNonVoidTags()
    {
        foreach ($this->nonVoidTags as $tag) {
            $this->assertEquals("<$tag></$tag>", HTML::$tag());
            $this->assertEquals("<$tag></$tag>", HTML::$tag(''));
            $this->assertEquals("<$tag></$tag>", HTML::$tag(null));
            $this->assertEquals("<$tag>content</$tag>", HTML::$tag('content'));
            $this->assertEquals("<$tag name=\"value\"></$tag>", HTML::$tag(['name' => 'value']));
            $this->assertEquals("<$tag name=\"value\" anotherName=\"anotherValue\"></$tag>", HTML::$tag(['name' => 'value', 'anotherName' => 'anotherValue']));
            $this->assertEquals("<$tag name=\"value\"></$tag>", HTML::$tag(['name' => 'value']), '');
            $this->assertEquals("<$tag name=\"value\"></$tag>", HTML::$tag(['name' => 'value']), null);
            $this->assertEquals("<$tag name=\"value\" anotherName=\"anotherValue\">content</$tag>", HTML::$tag(['name' => 'value', 'anotherName' => 'anotherValue'], 'content'));
        }
    }
    // }}}
    // {{{ testVoidTags
    public function testVoidTags()
    {
        foreach ($this->voidTags as $tag) {
            $this->assertEquals("<$tag />", HTML::$tag());
            $this->assertEquals("<$tag />", HTML::$tag(''));
            $this->assertEquals("<$tag />", HTML::$tag(null));
            $this->assertEquals("<$tag>content</$tag>", HTML::$tag('content'));
            $this->assertEquals("<$tag name=\"value\" />", HTML::$tag(['name' => 'value']));
            $this->assertEquals("<$tag name=\"value\" anotherName=\"anotherValue\" />", HTML::$tag(['name' => 'value', 'anotherName' => 'anotherValue']));
            $this->assertEquals("<$tag name=\"value\" />", HTML::$tag(['name' => 'value']), '');
            $this->assertEquals("<$tag name=\"value\" />", HTML::$tag(['name' => 'value']), null);
            $this->assertEquals("<$tag name=\"value\" anotherName=\"anotherValue\">content</$tag>", HTML::$tag(['name' => 'value', 'anotherName' => 'anotherValue'], 'content'));
        }
    }
    // }}}
    // {{{ testSignatureException
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
