<?php

namespace CMEsteban\Entity;

class Page extends Entity
{
    protected $request;
    protected $page;

    // {{{ toString
    public function __toString()
    {
        return $this->page;
    }
    // }}}
}
