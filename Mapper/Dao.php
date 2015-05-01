<?php

namespace Bh\Mapper;

use \Bh\Exceptions\DataException;

class Dao
{
    // {{{ __get
    public function __get($attribute)
    {
        $result = null;

        if (self::isValidField($this->getClass(), $attribute)) {
            if (isset($this->$attribute)) {
                $result = $this->$attribute;
            }
        } else {
            throw new DataException('Invalid field "' . $fieldName . '" for Class "' . $daoClass . '".');
        }

        return $result;
    }
    // }}}
    // {{{ __set
    public function __set($attribute, $value)
    {
        if (self::isValidField($this->getClass(), $attribute)) {
            $this->$attribute = $value;
        } else {
            throw new DataException('Invalid field "' . $fieldName . '" for Class "' . $daoClass . '".');
        }
    }
    // }}}

    // {{{ getList
    private function getList($attribute, $arguments)
    {
        $target = \Bh\Lib\Controller::getClass('Entity', $attribute);
        $reference = lcfirst($this->getType());

        self::isValidField($target, $reference);

        return \Bh\Mapper\Mapper::getAllWhere($attribute, [$reference => $this->getId()]);
    }
    // }}}
    // {{{ add
    private function add($attribute, $arguments)
    {
        $target = \Bh\Lib\Controller::getClass('Entity', $attribute);
        self::isValidField($target, lcfirst($attribute));
        $object = $arguments[0];
        $object->{'set' . $this->getType()}($this->getId());

        return \Bh\Mapper\Mapper::save($object);
    }
    // }}}

    // {{{ save
    public function save()
    {
        return \Bh\Mapper\Mapper::save($this);
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
            'id' === $fieldName ||
            'timestamp' === $fieldName ||
            array_key_exists($fieldName, self::getFields($daoClass))
        ) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }
    // }}}
    // {{{ isAssociationField
    public static function isAssociationField($daoClass, $fieldName)
    {
        $fields = self::getFields($daoClass);
        $type = (isset($fields[$fieldName])) ? $fields[$fieldName]->getType() : null;

        if (
            'Oto' === $type ||
            'Otp' === $type
        ) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }
    // }}}
}
