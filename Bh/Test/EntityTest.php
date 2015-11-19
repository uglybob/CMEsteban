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
        $this->assertInstanceOf('DateTime', $this->entity->getCreated());
        $this->assertFalse($this->entity->isDeleted());
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
        $this->assertFalse($this->entity->isDeleted());

        $this->entity->setDeleted(true);

        $this->assertTrue($this->entity->isDeleted());
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
    // {{{ testSetIdFail
    /**
     * @expectedException Bh\Exception\EntityException
     * @expectedExceptionMessage Call to undefined method Bh\Test\EntityTestClass::setId
     */
    public function testSetIdFail()
    {
        $this->entity->setId(42);
    }
    // }}}

    // {{{ testTimestampCreated
    public function testTimestampCreated()
    {
        $start = new \DateTime('now');
        sleep(1);
        $entity = new EntityTestClass();
        sleep(1);
        $end = new \DateTime('now');

        $created = $entity->getCreated();

        $this->assertInstanceOf('DateTime', $created);
        $this->assertTrue($start < $created);
        $this->assertTrue($created < $end);
    }
    // }}}
    // {{{ testTimestampModified
    public function testTimestampModified()
    {
        $created = $this->entity->getCreated();
        $modifiedBefore = $this->entity->getModified();

        sleep(1);
        $this->entity->setDeleted(true);

        $modifiedAfter = $this->entity->getModified();

        $this->assertInstanceOf('DateTime', $created);
        $this->assertInstanceOf('DateTime', $modifiedBefore);
        $this->assertInstanceOf('DateTime', $modifiedAfter);

        $this->assertTrue($created == $modifiedBefore);
        $this->assertTrue($modifiedBefore < $modifiedAfter);
    }
    // }}}

    // {{{ testDelete
    public function testDelete()
    {
        $this->assertFalse($this->entity->isDeleted());

        $this->entity->delete();

        $this->assertTrue($this->entity->isDeleted());
    }
    // }}}
}
