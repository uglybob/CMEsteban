<?php

namespace CMEsteban\Test;

use CMEsteban\Lib\Mapper;

class DatabaseTest extends CMEstebanTestCase
{
    public function setUp() : void
    {
        parent::setUp();
        Mapper::connect();

        $classes = ['\CMEsteban\Entity\User'];

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
    }

    public function testInit()
    {
        Mapper::connect();
        Mapper::init();

        $em = Mapper::getEntityManager();
        $conn = $em->getConnection();
        $sm = $conn->getSchemaManager();

        $this->assertTrue($sm->tablesExist(['users']));
        $this->assertFalse($sm->tablesExist(['notatable']));

        $this->controller = new \CMEsteban\Lib\Controller();
        $this->assertTrue($this->controller->login('sebastian', 'yesitsreallyme'));
    }
}
