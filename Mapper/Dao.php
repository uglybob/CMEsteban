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
        if ('List' === substr($attribute, -4, strlen($attribute))) {
            return $this->getList(ucfirst(substr($attribute, 0, -4)), $arguments);
        } else {
            self::isValidField(get_class($this), $attribute);
            return $this->$attribute;
        }
    }
    // }}}
    // {{{ set
    private function set($attribute, $arguments)
    {
        self::isValidField(get_class($this), $attribute);
        $this->$attribute = $arguments[0];
    }
    // }}}
    // {{{ getList
    private function getList($attribute, $arguments)
    {
        $target = \Bh\Lib\Controller::getClass('Entity', $attribute);
        self::isValidField($target, lcfirst($attribute));

        return \Bh\Mapper\Mapper::getAllWhere($attribute, ['id' => $this->getId()]);
    }
    // }}}

    // {{{ getClass
    public function getClass()
    {
        return get_class($this);;
    }
    // }}}
    // {{{ getType
    public function getType()
    {
        $classNameArray = explode('\\', $this->getClass());
        return end($classNameArray);
    }
    // }}}
    // {{{ getColumns
    public static function getColumns($daoClass)
    {
        return array_keys($daoClass::getFields($daoClass));
    }
    // }}}
    // {{{ getFields
    public static function getFields($daoClass)
    {
        $fieldObjects = [];
        foreach ($daoClass::daoFields() as $fieldParams) {
            $field = new Field($fieldParams);
            $fieldObjects[$field->getName()] = $field;
        }
        return $fieldObjects;
    }
    // }}}

    // {{{ isValidField
    public static function isValidField($daoClass, $fieldName)
    {
        if (
            'id' !== $fieldName &&
            'timestamp' != $fieldName &&
            !array_key_exists($fieldName, self::getFields($daoClass))
        ) {
            throw new DataException('Invalid field "' . $fieldName . '" for Class "' . $daoClass . '".');
        }
        return true;
    }
    // }}}
}
