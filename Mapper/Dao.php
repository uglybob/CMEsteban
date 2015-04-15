<?php

namespace Bh\Mapper;

use \Bh\Exceptions\DataException;

class Dao
{
    // {{{ call
    public function __call($name, $arguments)
    {
        $xet = substr($name, 0, 3);
        $attribute = lcfirst(substr($name, 3, strlen($name) - 3));

        if ($xet === 'get') {
            return $this->$attribute;
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
    public function getColumns($daoClass)
    {
        $columns = [];
        foreach ($daoClass::getFields() as $field) {
            $columns[] = $field->getColumn();
        }
        return $columns;
    }
    // }}}
    // {{{ getFields
    public static function getFields($daoClass)
    {
        $fieldObjects = [];
        foreach ($daoClass::daoFields() as $fieldParams) {
            $fieldObjects[] = new Field($fieldParams);
        }
        return $fieldObjects;
    }
    // }}}
}
