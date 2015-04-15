<?php

namespace Bh\Mapper;

use \Bh\Exceptions\DataException;

class Dao
{
    // {{{ variables
    protected $fields = [];
    protected $class = null;
    // }}}

    // {{{ call
    public function __call($name, $arguments)
    {
        $xet = substr($name, 0, 3);
        $attribute = lcfirst(substr($name, 3, strlen($name) - 3));

        if ($xet === 'get') {
            return $this->$attribute};
        } elseif ($xet === 'set') {
            $this->$attribute = $arguments[0];
        }
    }
    // }}}

    // {{{ getClass
    public function getClass()
    {
        $classNameArray = explode('\\', get_class($this));
        return end($classNameArray);
    }
    // }}}
    // {{{ getColumns
    public function getColumns()
    {
        $columns = [];
        foreach ($this->getFieldObjects() as $field) {
            $columns[] = $field->getColumn();
        }
        return $columns;
    }
    // }}}
    // {{{ getFields
    public function getFields()
    {
        foreach ($this->daoFields() as $field) {
            $fieldObjects = new Field($field);
        }
        return $fieldObjects;
    }
    // }}}
}
