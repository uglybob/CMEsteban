<?php

namespace Bh\Mapper;

use \Bh\Exceptions\DataException;

class Mapper
{
    // {{{ variables
    protected static $db;
    protected $pdo;
    // }}}
    // {{{ constructor
    protected function __construct()
    {
        $settings = \Bh\Lib\Setup::getSettings();
        $this->pdo = $this->pdo = new \PDO(
            'mysql:host=' . $settings['DbHost'] . ';dbname=' . $settings['DbName'],
            $settings['DbUser'],
            $settings['DbPass']
        );
    }
    // }}}

    // {{{ getPdo
    public static function getPdo()
    {
        if (is_null(self::$db)) {
            self::$db = new Mapper();
        }
        return self::$db->pdo;
    }
    // }}}

    // {{{ save
    public static function save($object)
    {
        $fields = \Bh\Mapper\Dao::getFields($object->getClass());

        if ($object->getId()) {
            $setString = '';

            foreach ($fields as $column => $field) {
                if (!self::isAssociation($field)) {
                    $setString .= $column . ' = :' . $column . ', ';
                }
            }

            $setString = substr($setString, 0, -2 ) . ' ';
            $sql = 'UPDATE ' . $object->getType() . ' SET ' . $setString . 'WHERE id = :id';
            $statement = self::getPdo()->prepare($sql);

            $id = $object->getId();
            $statement->bindParam('id', $id);

            foreach($fields as $column => $field) {
                if (!self::isAssociation($field)) {
                    $value = $object->{'get' . ucfirst($column)}();
                    $statement->bindValue($column, $value);
                }
            }

            if (!$statement->execute()) {
                throw new DataException(implode($statement->errorInfo()));
            }
        } else {
            $columns = array_keys($fields);
            $sql = 'INSERT INTO ' . $object->getType()  . ' (' . implode(', ', $columns) . ') VALUES (:' . implode(', :', $columns) . ')';
            $statement = self::getPdo()->prepare($sql);

            foreach($fields as $column => $field) {
                $value = $object->{'get' . ucfirst($column)}();
                $statement->bindValue($column, $value);
            }

            if (!$statement->execute()) {
                throw new DataException(implode($statement->errorInfo()));
            }

            $object->setId(self::getPdo()->lastInsertId());
        }

        return $object->getId();
    }
    // }}}
    // {{{ delete
    public static function delete($object)
    {
        $sql = ('DELETE FROM ' . $object->getClass() . ' WHERE id = :id');
        $statement = self::getPdo()->prepare($sql);

        $statement->bindParam('id', $object->getId());
        $statement->execute();
    }
    // }}}
    // {{{ load
    public static function load($class, $id)
    {
        $objects = self::getAllWhere($class, ['id' => $id]);

        if (
            count($objects) === 1
            && isset($objects[0])
        ) {
            $loaded = $objects[0];
        } else {
            // @todo exception on > 1
            $loaded = false;
        }

        return $loaded;
    }
    // }}}
    // {{{ getAllWhere
    public static function getAllWhere($class, $conditions = [])
    {
        $whereString = '';

        if (!empty($conditions)) {
            foreach ($conditions as $column => $value) {
                $whereString .= $column . ' = :' . $column . ' AND ';
            }
            $whereString = ' WHERE ' . substr($whereString, 0, -5 );
        }

        $namespaceClass = \Bh\Lib\Controller::getClass('Mapper', $class);
        $columns = \Bh\Mapper\Dao::getColumns($namespaceClass);

        $query = 'SELECT id,timestamp,' . implode(',', $columns) . ' FROM ' . $class . $whereString;
        $statement = self::getPdo()->prepare($query);

        foreach($conditions as $column => $value) {
            $statement->bindParam($column, $value);
        }

        $statement->execute();
        $results = $statement->fetchAll(\PDO::FETCH_CLASS, $namespaceClass);

        return $results;
    }
    // }}}
    // {{{ getAll
    public static function getAll($class)
    {
        return self::getAllWhere($class);
    }
    // }}}

    // {{{ isAssociation
    public static function isAssociation($field)
    {
        $type = $field->getType();

        return (
            'Oto' === $type ||
            'Mto' === $type
        );
    }
    // }}}
}
