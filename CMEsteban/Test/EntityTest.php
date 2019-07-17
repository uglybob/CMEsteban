<?php

namespace CMEsteban\Test;

class EntityTest extends \PhpUnit\Framework\TestCase
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
     * @expectedException CMEsteban\Exception\EntityException
     * @expectedExceptionMessage Call to undefined method CMEsteban\Test\EntityTestClass::getUndefinedAttribute
     */
    public function testGetUndefined()
    {
        $this->entity->getUndefinedAttribute();
    }
    // }}}

    // {{{ testUndefinedMethod
    /**
     * @expectedException CMEsteban\Exception\EntityException
     * @expectedExceptionMessage Call to undefined method CMEsteban\Test\EntityTestClass::thisIsNotAMethod
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
     * @expectedException CMEsteban\Exception\EntityException
     * @expectedExceptionMessage Call to undefined method CMEsteban\Test\EntityTestClass::setUndefinedAttribute
     */
    public function testSetUndefined()
    {
        $this->entity->setUndefinedAttribute('test');
    }
    // }}}
    // {{{ testSetProtectedId
    /**
     * @expectedException CMEsteban\Exception\EntityException
     * @expectedExceptionMessage Call to undefined method CMEsteban\Test\EntityTestClass::setId
     */
    public function testSetProtectedId()
    {
        $this->entity->setId(42);
    }
    // }}}
    // {{{ testSetProtectedCreated
    /**
     * @expectedException CMEsteban\Exception\EntityException
     * @expectedExceptionMessage Call to undefined method CMEsteban\Test\EntityTestClass::setCreated
     */
    public function testSetProtectedCreated()
    {
        $this->entity->setCreated(new \DateTime('now'));
    }
    // }}}
    // {{{ testSetProtectedModified
    /**
     * @expectedException CMEsteban\Exception\EntityException
     * @expectedExceptionMessage Call to undefined method CMEsteban\Test\EntityTestClass::setModified
     */
    public function testSetProtectedModified()
    {
        $this->entity->setModified(new \DateTime('now'));
    }
    // }}}
    // {{{ testSetProtectedProtected
    /**
     * @expectedException CMEsteban\Exception\EntityException
     * @expectedExceptionMessage Call to undefined method CMEsteban\Test\EntityTestClass::setProtected
     */
    public function testSetProtectedProtected()
    {
        $this->entity->setProtected([]);
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
