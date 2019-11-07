<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

class Email extends Module
{
    // {{{ constructor
    public function __construct($email)
    {
        parent::__construct();

        $path = CMEsteban::$setup->getSettings('PathCme') . '/CMesteban/Page/js';

        CMEsteban::$template->addScript($path . '/lib.js');
        CMEsteban::$template->addScript($path . '/mail.js');

        $this->email = $email;

        $in = ['@', '.'];
        $out = ['+', ','];

        $this->rendered = str_rot13($this->email);
        $this->rendered = str_replace($in, $out, $this->rendered);
        $this->rendered = HTML::span(['.shooo'], $this->rendered);
    }
    // }}}
}
