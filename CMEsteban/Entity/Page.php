<?php

namespace CMEsteban\Entity;

class Page extends Entity
{
    protected $request;
    protected $page;

    // {{{ constructor
    public function __construct($request, $page)
    {
        parent::__construct();

        $this->request = $request;
        $this->page = $page;
    }
    // }}}
    // {{{ toString
    public function __toString()
    {
        return $this->page;
    }
    // }}}
}
