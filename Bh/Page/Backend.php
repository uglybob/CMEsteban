<?php

namespace Bh\Page;

abstract class Backend extends Page {
    protected $accessLevel = 1;

    // {{{ constructor
    public function __construct($controller)
    {
        parent::__construct($controller);
    }
    // }}}
}
