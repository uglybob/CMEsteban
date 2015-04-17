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

        if ($xet === 'get' || $xet === 'set') {
            return $this->$xet($attribute, $arguments);
        }
    }
    // }}}

    // {{{ get
    private function get($attribute, $arguments)
    {
        $length = strlen($attribute);
        if (substr($attribute, -4, $length) === 'List') {
            return $this->getList(ucfirst(substr($attribute, 0, -4)), $arguments);
        } else {
            return $this->$attribute;
        }
    }
    // }}}
    // {{{ set
    private function set($attribute, $arguments)
    {
        $this->$attribute = $arguments[0];
    }
    // }}}
    // {{{ getList
    private function getList($attribute, $arguments)
    {
        $target = \Bh\Lib\Controller::getClass('Entity', $attribute);
        // @todo test if field exists
        return \Bh\Mapper\Mapper::getAllWhere($attribute, ['id' => $this->getId()]);
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
    public static function getColumns($daoClass)
    {
        $columns = [];
        foreach ($daoClass::getFields($daoClass) as $field) {
            $columns[] = $field->getName();
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
