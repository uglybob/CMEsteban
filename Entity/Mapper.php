<?php

namespace Bh\Entity;

class Mapper
{
    // {{{ variables
    protected $pdo = null;
    protected $class = null;
    protected $table = null;
    protected $fields = array();
    // }}}
    // {{{ constructor
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    // }}}

    // {{{ addField
    public function addField($field)
    {
        $this->fields[] = $field;
    }
    // }}}
    // {{{ getFields
    public function getFields()
    {
        return $this->fields;
    }
    // }}}
    // {{{ getColumns
    protected function getColumns()
    {
        $columns = array();
        foreach ($this->getFields() as $field) {
            $columns[] = $field->getColumn();
        }
        return $columns;
    }
    // }}}

    // {{{ save
    public function save($object)
    {
        $columns = $this->getColumns();

        if ($object->id) {
            $setString = '';

            foreach ($columns as $column) {
                $setString .= $column . ' = :' . $column . ', ';
            }

            $setString = substr($setString, 0, -2 ) . ' ';
            $sql = 'UPDATE ' . $this->table . ' SET ' . $setString . 'WHERE id = :id';
            $statement = $this->pdo->prepare($sql);

            $statement->bindParam('id', $object->id);

            foreach($columns as $column) {
                $statement->bindParam($column, $object->$column);
            }

            if (!$statement->execute()) {
                // @todo data exception
                throw new \Exception(implode($statement->errorInfo()));
            }
        } else {
            $sql = 'INSERT INTO ' . $this->table . ' (' . implode(', ', $columns) . ') VALUES (:' . implode(', :', $columns) . ')';
            $statement = $this->pdo->prepare($sql);

            foreach($columns as $column) {
                $statement->bindParam($column, $object->$column);
            }

            if (!$statement->execute()) {
                // @todo data exception
                throw new \Exception(implode($statement->errorInfo()));
            }

            $object->id = $this->pdo->lastInsertId();
        }
    }
    // }}}
    // {{{ delete
    public function delete($object)
    {
        $sql = ('DELETE FROM ' . $this->table . ' WHERE id = :id');
        $statement = $this->pdo->prepare($sql);

        $statement->bindParam('id', $object->id);
        $statement->execute();
    }
    // }}}
    // {{{ load
    public function load($id)
    {
        $objects = $this->getAllWhere(array('id' => $id));

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
    public function getAllWhere($conditions = array())
    {
        $whereString = '';

        foreach ($conditions as $column => $value) {
            $whereString .= $column . ' = :' . $column . ' AND ';
        }

        $whereString = substr($whereString, 0, -5 );

        $sql = 'SELECT id,timestamp,' . implode(',', $this->getColumns()) . ' FROM ' . $this->table . ' WHERE ' . $whereString;
        $statement = $this->pdo->prepare($sql);

        foreach($conditions as $column => $value) {
            $statement->bindParam($column, $value);
        }

        $statement->execute();
        $results = $statement->fetchAll(\PDO::FETCH_CLASS, $this->class);

        return $results;
    }
    // }}}
    // {{{ getAll
    public function getAll()
    {
        return $this->queryClass('SELECT id,timestamp,' . implode(',', $this->getColumns()) . ' FROM ' . $this->table);
    }
    // }}}

    // {{{ queryClass
    protected function queryClass($query)
    {
        $statement = $this->pdo->query($query);
        $results = $statement->fetchAll(\PDO::FETCH_CLASS, $this->class);

        return $results;
    }
    // }}}
}
