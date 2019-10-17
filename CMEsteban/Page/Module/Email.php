<?php

namespace CMEsteban\Page\Module;

class Email extends Module
{
    // {{{ constructor
    public function __construct($email)
    {
        parent::__construct();

        $this->email = $email;

        CMEsteban::$template->addScript('/CMEsteban/Page/js/lib.js');
        CMEsteban::$template->addScript('/CMEsteban/Page/js/mail.js');
    }
    // }}}

    // {{{ toString
    public function __toString() {
        $in = ['@', '.'];
        $out = ['+', ','];

        $renderedMail = str_rot13($this->email);
        $renderedMail = str_replace($in, $out, $renderedMail);
        $renderedMail = HTML::span(['.shooo'], $renderedMail);

        return $renderedMail;
    }
    // }}}
}
