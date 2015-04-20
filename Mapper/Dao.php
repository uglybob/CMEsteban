<?php

namespace Bh\Mapper;

use \Bh\Exceptions\DataException;

class Dao
{
    // {{{ call
    public function __call($name, $arguments)
    {
        $methods = ['get', 'set', 'add'];

        foreach ($methods as $method) {
            $rest = $this->startsWith($name, $method);
            if ($rest) {
                return $this->$method(lcfirst($rest), $arguments);
            }
        }
    }
    // }}}

    // {{{ get
    private function get($attribute, $arguments)
    {
        if ($rest = $this->endsWith($attribute, 'List')) {
            return $this->getList(ucfirst($rest), $arguments);
        } else {
            self::isValidField($this->getClass(), $attribute);
            if (isset($this->$attribute)) {
                return $this->$attribute;
            } elseif ($this->isAssociationField($this->getClass(), $attribute . 'Id')) {
                return \Bh\Mapper\Mapper::load(ucfirst($attribute), $this->{$attribute . 'Id'});
            } else {
                return null;
            }
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
        $reference = lcfirst($this->getType()) . 'Id';

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
            array_key_exists($fieldName, self::getFields($daoClass)) ||
            array_key_exists($fieldName . 'Id', self::getFields($daoClass))
        ) {
            return true;
        } else {
            throw new DataException('Invalid field "' . $fieldName . '" for Class "' . $daoClass . '".');
        }
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

    // {{{ startsWith
    private function startsWith($haystack, $needle)
    {
        if (substr($haystack, 0, strlen($needle)) === $needle) {
            return substr($haystack, strlen($needle), strlen($haystack) - strlen($needle));
        } else {
            return false;
        }
    }
    // }}}
    // {{{ endsWith
    private function endsWith($haystack, $needle)
    {
        if (substr($haystack, - strlen($needle), strlen($haystack)) === $needle) {
           return substr($haystack, 0, -strlen($needle));
        } else {
            return false;
        }
    }
    // }}}
}
