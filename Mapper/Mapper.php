<?php

namespace Bh\Mapper;

use \Bh\Exceptions\DataException;

abstract class Mapper
{
    // {{{ variables
    protected $pdo = null;
    // }}}
    // {{{ constructor
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    // }}}

    // {{{ save
    public function save($object)
    {
        $columns = $object->getColumns();

        if ($object->id) {
            $setString = '';

            foreach ($columns as $column) {
                $setString .= $column . ' = :' . $column . ', ';
            }

            $setString = substr($setString, 0, -2 ) . ' ';
            $sql = 'UPDATE ' . $this->class . ' SET ' . $setString . 'WHERE id = :id';
            $statement = $this->pdo->prepare($sql);

            $statement->bindParam('id', $object->id);

            foreach($columns as $column) {
                $statement->bindParam($column, $object->$column);
            }

            if (!$statement->execute()) {
                throw new DataException(implode($statement->errorInfo()));
            }
        } else {
            $sql = 'INSERT INTO ' . $this->class . ' (' . implode(', ', $columns) . ') VALUES (:' . implode(', :', $columns) . ')';
            $statement = $this->pdo->prepare($sql);

            foreach($columns as $column) {
                $statement->bindParam($column, $object->$column);
            }

            if (!$statement->execute()) {
                throw new DataException(implode($statement->errorInfo()));
            }

            $object->id = $this->pdo->lastInsertId();
        }

        return $object->id;
    }
    // }}}
    // {{{ delete
    public function delete($object)
    {
        $sql = ('DELETE FROM ' . $object->getClass() . ' WHERE id = :id');
        $statement = $this->pdo->prepare($sql);

        $statement->bindParam('id', $object->id);
        $statement->execute();
    }
    // }}}
    // {{{ load
    public function load($class, $id)
    {
        $objects = $this->getAllWhere($class, ['id' => $id]);

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
    public function getAllWhere($class, $conditions = [])
    {
        $whereString = '';

        if (!empty($conditions)) {
            foreach ($conditions as $column => $value) {
                $whereString .= $column . ' = :' . $column . ' AND ';
            }
            $whereString = ' WHERE ' . substr($whereString, 0, -5 );
        }

        $namespaceClass = \Bh\Lib\Controller::getClass('Entity', $class);
        $columns = (new $namespaceClass())->getColumns();

        $query = 'SELECT id,timestamp,' . implode(',', $columns) . ' FROM ' . $class . $whereString;
        $statement = $this->pdo->prepare($query);

        foreach($conditions as $column => $value) {
            $statement->bindParam($column, $value);
        }

        $statement->execute();
        $results = $statement->fetchAll(\PDO::FETCH_CLASS, $namespaceClass);

        return $results;
    }
    // }}}
    // {{{ getAll
    public function getAll($class)
    {
        return $this->getAllWhere($class);
    }
    // }}}
}
