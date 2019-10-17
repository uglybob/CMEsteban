<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

class Email extends Module
{
    // {{{ constructor
    public function __construct($email)
    {
        parent::__construct();

        CMEsteban::$template->addScript('/CMEsteban/Page/js/lib.js');
        CMEsteban::$template->addScript('/CMEsteban/Page/js/mail.js');

        $this->email = $email;

        $in = ['@', '.'];
        $out = ['+', ','];

        $this->rendered = str_rot13($this->email);
        $this->rendered = str_replace($in, $out, $this->rendered);
        $this->rendered = HTML::span(['.shooo'], $this->rendered);
    }
    // }}}
}
