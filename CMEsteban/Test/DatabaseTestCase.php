<?php

namespace CMEsteban\Test;

use CMEsteban\Lib\Mapper;

class DatabaseTestCase extends \PHPUnit\Framework\TestCase
{
    // {{{ setUpBeforeClass
    public static function setUpBeforeClass() : void
    {
        $setup = new \CMEsteban\Lib\Setup();
        \CMEsteban\CMEsteban::start($setup);
        Mapper::connect();

        $classes = ['\CMEsteban\Entity\User', '\CMEsteban\Entity\LogEntry', '\CMEsteban\Entity\Page'];

        $em = Mapper::getEntityManager();
        $conn = $em->getConnection();
        $conn->getConfiguration()->setSQLLogger(null);

        $sm = $conn->getSchemaManager();

        $paths = [__DIR__ . '/../Mapper'];

        $metadata = [];
        foreach ($classes as $class) {
            array_push($metadata, $em->getClassMetadata($class));
        }
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($em);
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }
    // }}}
    // {{{ setUp
    protected function setUp() : void
    {
        $em = Mapper::getEntityManager();

        if ($em->isOpen()) {
            $conn = $em->getConnection();
            $sm = $conn->getSchemaManager();

            foreach($sm->listTableNames() as $tableName) {
                $conn->prepare('DELETE FROM ' . $tableName)->execute();
            }
        } else {
            $this->setUpBeforeClass();
        }
    }
    // }}}

    // {{{ save
    protected function save($entity)
    {
        Mapper::save($entity);
        Mapper::commit();
    }
    // }}}
}
