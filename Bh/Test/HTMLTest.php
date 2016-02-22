<?php

use Bh\Page\Module\HTML;

class HTMLTest extends PhpUnit_Framework_TestCase
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
            $this->assertEquals("<$tag name=\"value\" />", HTML::$tag(['name' => 'value']), '');
            $this->assertEquals("<$tag name=\"value\" />", HTML::$tag(['name' => 'value']), null);
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
            $this->assertEquals("<$tag name=\"value\"></$tag>", HTML::$tag(['name' => 'value']), '');
            $this->assertEquals("<$tag name=\"value\"></$tag>", HTML::$tag(['name' => 'value']), null);
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
    /**
     * @expectedException           Exception
     * @expectedExceptionMessage    invalid tag signature
     */
    public function testSignatureException()
    {
        HTML::html('content', 'content');
    }
    // }}}
    // {{{ testUndefinedMethodException
    /**
     * @expectedException           Exception
     * @expectedExceptionMessage    Call to undefined method Bh\Page\HTML::iDontExist()
     */
    public function testUndefinedMethodException()
    {
        HTML::iDontExist();
    }
    // }}}
    // {{{ testInvalidAttributeException
    /**
     * @expectedException           Exception
     * @expectedExceptionMessage    invalid attributes
     */
    public function testInvalidAttributeException()
    {
        HTML::div(['.'], 'content');
    }
    // }}}
    // {{{ testUnknownSelectorException
    /**
     * @expectedException           Exception
     * @expectedExceptionMessage    unknown selector
     */
    public function testUnknownSelectorException()
    {
        HTML::div(['$name'], 'content');
    }
    // }}}
}
