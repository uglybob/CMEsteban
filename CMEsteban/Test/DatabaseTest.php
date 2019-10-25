<?php

namespace CMEsteban\Test;

use CMEsteban\Lib\Mapper;

class DatabaseTest extends CMEstebanTestCase
{
    // {{{ setUp
    public function setUp() : void
    {
        parent::setUp();
        Mapper::connect();

        $classes = ['\CMEsteban\Entity\User', '\CMEsteban\Entity\LogEntry', '\CMEsteban\Entity\Page'];

        $em = Mapper::getEntityManager();
        $conn = $em->getConnection();
        $conn->getConfiguration()->setSQLLogger(null);
        $sm = $conn->getSchemaManager();

        $metadata = [];
        foreach ($classes as $class) {
            array_push($metadata, $em->getClassMetadata($class));
        }
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($em);
        $schemaTool->dropSchema($metadata);
        $this->assertFalse($sm->tablesExist(['users']));
        $this->assertFalse($sm->tablesExist(['pages']));
        $this->assertFalse($sm->tablesExist(['logs']));
    }
    // }}}

    // {{{ testInit
    public function testInit()
    {
        Mapper::connect();
        Mapper::init();

        $em = Mapper::getEntityManager();
        $conn = $em->getConnection();
        $sm = $conn->getSchemaManager();

        $this->assertTrue($sm->tablesExist(['users']));
        $this->assertTrue($sm->tablesExist(['pages']));
        $this->assertTrue($sm->tablesExist(['logs']));
        $this->assertFalse($sm->tablesExist(['notatable']));

        $this->controller = new \CMEsteban\Lib\Controller();
        $this->assertTrue($this->controller->login('sebastian', 'yesitsreallyme'));
    }
    // }}}
    // {{{ testInitTrigger
    public function testInitTrigger()
    {
        Mapper::connect();

        Mapper::findAll('Page');

        $em = Mapper::getEntityManager();
        $conn = $em->getConnection();
        $sm = $conn->getSchemaManager();

        $this->assertTrue($sm->tablesExist(['users']));
        $this->assertTrue($sm->tablesExist(['pages']));
        $this->assertTrue($sm->tablesExist(['logs']));
        $this->assertFalse($sm->tablesExist(['notatable']));
    }
    // }}}
}
