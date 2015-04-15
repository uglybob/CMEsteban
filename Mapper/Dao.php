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

    // {{{ addField
    public function addField($name, $type, $params = [])
    {
        $this->fields[] = new Field($name, $type, $params);
    }
    // }}}
    // {{{ getFields
    public function getFields()
    {
        return $this->fields;
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
        foreach ($this->getFields() as $field) {
            $columns[] = $field->getColumn();
        }
        return $columns;
    }
    // }}}
}
