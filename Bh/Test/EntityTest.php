<?php

namespace Bh\Test;

class EntityTest extends \PhpUnit_Framework_TestCase
{
    // {{{ setUp
    protected function setUp()
    {
        parent::setUp();

        $this->entity = new EntityTestClass();
    }
    // }}}

    // {{{ testGet
    public function testGet()
    {
        $this->assertInstanceOf('DateTime', $this->entity->getTimestamp());
        $this->assertFalse($this->entity->getDeleted());
    }
    // }}}
    // {{{ testGetUndefined
    /**
     * @expectedException Bh\Exception\EntityException
     * @expectedExceptionMessage Call to undefined method Bh\Test\EntityTestClass::getUndefinedAttribute
     */
    public function testGetUndefined()
    {
        $this->entity->getUndefinedAttribute();
    }
    // }}}

    // {{{ testUndefinedMethod
    /**
     * @expectedException Bh\Exception\EntityException
     * @expectedExceptionMessage Call to undefined method Bh\Test\EntityTestClass::thisIsNotAMethod
     */
    public function testUndefinedMethod()
    {
        $this->entity->thisIsNotAMethod();
    }
    // }}}

    // {{{ testSet
    public function testSet()
    {
        $now = new \DateTime('now');

        $this->entity->setTimestamp($now);

        $this->assertEquals($now, $this->entity->getTimestamp());
    }
    // }}}
    // {{{ testSetUndefined
    /**
     * @expectedException Bh\Exception\EntityException
     * @expectedExceptionMessage Call to undefined method Bh\Test\EntityTestClass::setUndefinedAttribute
     */
    public function testSetUndefined()
    {
        $this->entity->setUndefinedAttribute('test');
    }
    // }}}
}
