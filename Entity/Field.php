<?php

namespace BH\Entity;

class Field
{
    // {{{ variables
    protected $name;
    protected $type;
    protected $label;
    protected $params;
    // }}}

    // {{{ constructor
    public function __construct($name, $type, $label = null, $params = array())
    {
        $this->name = strtolower($name);
        $this->type = $type;
        $this->label = ($label === null) ? $this->class : $label;
        $this->params = $params;
    }
    // }}}

    // {{{ getName
    public function getName()
    {
        return $this->name;
    }
    // }}}
    // {{{ getClass
    public function getClass()
    {
        return ucfirst($this->name);
    }
    // }}}
    // {{{ getColumn
    public function getColumn()
    {
        return $this->name;
    }
    // }}}
    // {{{ getType
    public function getType()
    {
        return $this->type;
    }
    // }}}
    // {{{ getLabel
    public function getLabel()
    {
        return $this->label;
    }
    // }}}
    // {{{ getParams
    public function getParams()
    {
        return $this->params;
    }
    // }}}
}
