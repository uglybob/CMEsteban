<?php

namespace CMEsteban\Test;

class EntityTest extends CMEstebanTestCase
{
    // {{{ setUp
    protected function setUp() : void
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
    public function testGetUndefined()
    {
        $this->expectException(\CMEsteban\Exception\EntityException::class);
        $this->expectExceptionMessage('Call to undefined method CMEsteban\Test\EntityTestClass::getUndefinedAttribute');

        $this->entity->getUndefinedAttribute();
    }
    // }}}

    // {{{ testUndefinedMethod
    public function testUndefinedMethod()
    {
        $this->expectException(\CMEsteban\Exception\EntityException::class);
        $this->expectExceptionMessage('Call to undefined method CMEsteban\Test\EntityTestClass::thisIsNotAMethod');

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
    public function testSetUndefined()
    {
        $this->expectException(\CMEsteban\Exception\EntityException::class);
        $this->expectExceptionMessage('Call to undefined method CMEsteban\Test\EntityTestClass::setUndefinedAttribute');

        $this->entity->setUndefinedAttribute('test');
    }
    // }}}
    // {{{ testSetProtectedId
    public function testSetProtectedId()
    {
        $this->expectException(\CMEsteban\Exception\EntityException::class);
        $this->expectExceptionMessage('Call to undefined method CMEsteban\Test\EntityTestClass::setId');

        $this->entity->setId(42);
    }
    // }}}
    // {{{ testSetProtectedCreated
    public function testSetProtectedCreated()
    {
        $this->expectException(\CMEsteban\Exception\EntityException::class);
        $this->expectExceptionMessage('Call to undefined method CMEsteban\Test\EntityTestClass::setCreated');

        $this->entity->setCreated(new \DateTime('now'));
    }
    // }}}
    // {{{ testSetProtectedModified
    public function testSetProtectedModified()
    {
        $this->expectException(\CMEsteban\Exception\EntityException::class);
        $this->expectExceptionMessage('Call to undefined method CMEsteban\Test\EntityTestClass::setModified');

        $this->entity->setModified(new \DateTime('now'));
    }
    // }}}
    // {{{ testSetProtectedProtected
    public function testSetProtectedProtected()
    {
        $this->expectException(\CMEsteban\Exception\EntityException::class);
        $this->expectExceptionMessage('Call to undefined method CMEsteban\Test\EntityTestClass::setProtected');

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
