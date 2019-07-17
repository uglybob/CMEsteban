<?php

namespace CMEsteban\Entity;

class LogEntry extends Entity
{
    protected $message;

    // {{{ constructor
    public function __construct($message)
    {
        parent::__construct();

        $this->message = $message;
    }
    // }}}
}
