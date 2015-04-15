<?php

namespace Bh\Mapper;

class Field
{
    // {{{ variables
    protected $name;
    protected $type;
    protected $params;
    // }}}

    // {{{ constructor
    public function __construct($params = [])
    {
        $this->name = lcfirst($params[0]);
        $this->type = $params[1];
        $this->params = isset($params[2]) ? $params[2] : [];
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
