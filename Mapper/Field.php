<?php

namespace Bh\Mapper;

class Field
{
    // {{{ variables
    protected $name;
    protected $type;
    protected $label;
    protected $params;
    // }}}

    // {{{ constructor
    public function __construct($name, $type, $params = array())
    {
        $this->name = lcfirst($name);
        $this->type = $type;
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
    // {{{ getParams
    public function getParams()
    {
        return $this->params;
    }
    // }}}
}
