<?php

namespace Bh\Entity;

class Entity
{
    protected $id;
    protected $timestamp;

    // {{{ constructor
    public function __construct()
    {
        $this->timestamp = new \DateTime('now');
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

        // @todo exception
    }
    // }}}
    // {{{ get
    private function get($attribute, $arguments)
    {
        $result = null;

        if (property_exists($this, $attribute)) {
            $result = $this->$attribute;
        } else {
            // @todo exception?
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
            // @todo exception?
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
}
