<?php

namespace CMEsteban\Test;

use CMEsteban\Lib\Mapper;

class DatabaseTest extends \PHPUnit\Framework\TestCase
{
    // {{{ setUp
    public function setUp() : void
    {
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
    }
    // }}}

    // {{{ testInit
    public function testInit()
    {
        Mapper::connect();
        Mapper::init();
    }
    // }}}
}
