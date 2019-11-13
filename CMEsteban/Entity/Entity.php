<?php

namespace CMEsteban\Entity;

use CMEsteban\Lib\Mapper;

abstract class Entity
{
    // {{{ variables
    private $id;
    private $created;
    private $modified;
    private $deleted;

    private $protected = [
        'protected',
        'id',
        'created',
        'modified',
    ];
    // }}}

    // {{{ constructor
    public function __construct()
    {
        $this->deleted = false;

        $now = new \DateTime('now');
        $this->created = $now;
        $this->modified = $now;
    }
    // }}}

    // {{{ toString
    public function __toString()
    {
        return (string) $this->id;
    }
    // }}}

    // {{{ call
    public function __call($name, $arguments)
    {
        $methods = ['get', 'set'];
        foreach ($methods as $method) {
            $rest = $this->extractAttribute($name, $method);
            if ($rest) {
                return $this->$method(lcfirst($rest), $arguments);
            }
        }

        $this->undefinedMethodException($name);
    }
    // }}}
    // {{{ get
    private function get($attribute, $arguments)
    {
        $result = null;

        if (property_exists($this, $attribute)) {
            if (
                $this->$attribute instanceOf \Doctrine\ORM\PersistentCollection
                && (
                    !isset($arguments[0])
                    || $arguments[0] == false
                )
            ) {
                $result = $this->$attribute->filter(
                    function($entity) {
                        return !$entity->isDeleted();
                    }
                );
            } else {
                $result = $this->$attribute;
            }
        } else {
            $this->undefinedMethodException('get' . ucfirst($attribute));
        }

        return $result;
    }
    // }}}
    // {{{ set
    private function set($attribute, $arguments)
    {
        if (
            property_exists($this, $attribute)
            && !in_array(strtolower($attribute), $this->protected)
        ) {
            $this->$attribute = $arguments[0];
            $this->modified = new \DateTime('now');
        } else {
            $this->undefinedMethodException('set' . ucfirst($attribute));
        }
    }
    // }}}
    // {{{ extractAttribute
    private function extractAttribute($haystack, $needle)
    {
        if (substr($haystack, 0, strlen($needle)) === $needle) {
            return substr($haystack, strlen($needle), strlen($haystack) - strlen($needle));
        } else {
            return false;
        }
    }
    // }}}

    // {{{ save
    public function save()
    {
        return Mapper::save($this);
    }
    // }}}
    // {{{ delete
    public function delete()
    {
        $this->deleted = true;
    }
    // }}}
    // {{{ undelete
    public function undelete()
    {
        $this->deleted = false;
    }
    // }}}
    // {{{ isDeleted
    public function isDeleted()
    {
        return $this->deleted;
    }
    // }}}

    // {{{ undefinedMethodException
    public function undefinedMethodException($name)
    {
        throw new \CMEsteban\Exception\EntityException('Call to undefined method ' . get_class($this) . '::' . $name);
    }
    // }}}
}
