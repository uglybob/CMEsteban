<?php

namespace CMEsteban\Page\Module;

class Email
{
    // {{{ constructor
    public function __construct($email, $page)
    {
        $this->email = $email;
        $this->page = $page;

        $this->page->addScript('/CMEsteban/Page/js/lib.js');
        $this->page->addScript('/CMEsteban/Page/js/mail.js');
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
