<?php

namespace Bh\Entity;

class Entity
{
    // {{{ variables
    protected $id;
    protected $timestamp;
    protected $deleted;
    // }}}

    // {{{ constructor
    public function __construct()
    {
        $this->deleted = false;
        $this->timestamp = new \DateTime('now');
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
                        return !$entity->getDeleted();
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
        if (property_exists($this, $attribute)) {
            $this->$attribute = $arguments[0];
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

    // {{{ delete
    public function delete()
    {
        $this->deleted = true;
    }
    // }}}
    // {{{ undefinedMethodException
    public function undefinedMethodException($name)
    {
        throw new \Bh\Exception\EntityException('Call to undefined method ' . get_class($this) . '::' . $name);
    }
    // }}}
}
