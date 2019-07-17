<?php

namespace CMEsteban\Test;

class DatabaseTestCase extends \PHPUnit_Extensions_Database_TestCase
{
    // {{{ variables
    protected $pdo = null;
    protected $conn = null;
    // }}}

    // {{{ setUp
    protected function setUp() {
        \CMEsteban\Lib\Mapper::getEntityManager()->clear();
        $this->getConnection();
        $this->setForeignKeyChecks(false);
        parent::setUp();
        $this->setForeignKeyChecks(true);
    }
// }}}
    // {{{ getConnection
    final public function getConnection()
    {
        $this->pdo = new \Pdo(
            $GLOBALS['DB_DSN'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_PASS'],
            array(
                'prefix' => 'xmldb',
                \PDO::ATTR_PERSISTENT => true,
            )
        );
        $this->conn = $this->createDefaultDBConnection($this->pdo, $GLOBALS['DB_NAME']);

        return $this->conn;
    }
    // }}}
    // {{{ getDataSet
    protected function getDataSet() {
        return $this->createXMLDataSet(__DIR__.'/dataset.xml');
    }
    // }}}

    // {{{ setKeyChecks
    protected function setForeignKeyChecks($enable) {
        $setString = 'SET FOREIGN_KEY_CHECKS=';
        $setString .= ($enable) ? '1;' : '0;';

        $this->pdo->exec($setString);
    }
    // }}}

    // {{{ tableExists
    protected function tableExists($tableName)
    {
        $exists = false;

        try {
            $this->pdo->query('SELECT 1 FROM ' . $tableName);
            $exists = true;
        } catch (\PDOException $expected) {
            // only catch "table doesn't exist" exception
            if ($expected->getCode() != '42S02') {
                throw $expected;
            }
        }

        return $exists;
    }
    // }}}
    // {{{ dropTable
    protected function dropTable($tableName)
    {
        $this->setForeignKeyChecks(false);
        $this->pdo->query('DROP TABLE IF EXISTS ' . $tableName);
        $this->setForeignKeyChecks(true);
        $this->assertFalse($this->tableExists($tableName));
    }
    // }}}
    // {{{ dropTables
    protected function dropTables($tableNames)
    {
        foreach($tableNames as $tableName) {
            $this->dropTable($tableName);
        }
    }
    // }}}
    // {{{ insertDummyDataIntoTable
    protected function insertDummyDataIntoTable($tableName)
    {
        $statement = $this->pdo->query('DESCRIBE ' . $tableName . ';');
        $statement->execute();
        while ($row = $statement->fetch()) {
            $values[] = '" "';
        }

        $this->setForeignKeyChecks(false);
        $rows = $this->pdo->exec('INSERT INTO ' . $tableName . ' VALUES (' . implode(',', $values) . ');');
        $this->assertEquals(1, $rows);
        $this->setForeignKeyChecks(true);
    }
    // }}}

    // {{{ assertTableEmpty
    protected function assertTableEmpty($tableName)
    {
        $statement = $this->pdo->query('SELECT COUNT(*) FROM ' . $tableName . ';');
        $statement->execute();
        $result = $statement->fetch();

        $this->assertEquals(0, $result['COUNT(*)']);
    }
    // }}}
}

/* vim:set ft=php sw=4 sts=4 fdm=marker et : */
