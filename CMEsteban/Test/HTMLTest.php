<?php

use CMEsteban\Page\Module\HTML;

class HTMLTest extends \PHPUnit\Framework\TestCase
{
    // {{{ variables
    protected $voidTags = ['img', 'meta', 'link'];
    protected $nonVoidTags = ['html', 'title', 'head', 'body', 'a', 'p', 'label', 'div', 'span'];
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
            $this->assertEquals("<$tag name=\"value\" anotherName=\"anotherValue\">content</$tag>", HTML::$tag(['name' => 'value', 'anotherName' => 'anotherValue'], 'content'));
        }
    }
    // }}}
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
            $this->assertEquals("<$tag name=\"value\" anotherName=\"anotherValue\">content</$tag>", HTML::$tag(['name' => 'value', 'anotherName' => 'anotherValue'], 'content'));
        }
    }
    // }}}
    // {{{ testSelectors
    public function testSelectors()
    {
        $this->assertEquals('<div class="testClass">content</div>', HTML::div(['.testClass'], 'content'));
        $this->assertEquals('<div class="testClass testClass2">content</div>', HTML::div(['.testClass', '.testClass2'], 'content'));
        $this->assertEquals('<div class="testClass testClass2 testClass3">content</div>', HTML::div(['.testClass', '.testClass2', 'class' => 'testClass3'], 'content'));
    }
    // }}}

    // {{{ testSignatureException
    public function testSignatureException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('invalid tag signature');

        HTML::html('content', 'content');
    }
    // }}}
    // {{{ testUndefinedMethodException
    public function testUndefinedMethodException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Call to undefined method CMEsteban\Page\HTML::iDontExist()');

        HTML::iDontExist();
    }
    // }}}
    // {{{ testInvalidAttributeException
    public function testInvalidAttributeException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('invalid attributes');

        HTML::div(['.'], 'content');
    }
    // }}}
    // {{{ testUnknownSelectorException
    public function testUnknownSelectorException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('unknown selector');

        HTML::div(['$name'], 'content');
    }
    // }}}
}
