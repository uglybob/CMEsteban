<?php

namespace CMEsteban\Page\Module;

class Email extends Module
{
    // {{{ constructor
    public function __construct($page, $email)
    {
        parent::__construct($page);

        $this->email = $email;

        $this->page->getTemplate()->addScript('/CMEsteban/Page/js/lib.js');
        $this->page->getTemplate()->addScript('/CMEsteban/Page/js/mail.js');
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
