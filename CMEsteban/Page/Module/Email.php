<?php

namespace CMEsteban\Page\Module;

class Email extends Module
{
    public function __construct($email, $createAnchors = true)
    {
        $this->addScript('/CMEsteban/Page/js/lib.js', true);
        $this->addScript('/CMEsteban/Page/js/mail.js', true);
        $this->addStylesheet('/CMEsteban/Page/css/mail.css', true);

        $this->email = $email;
        $this->createAnchors = $createAnchors;

        parent::__construct();
    }

    protected function render()
    {
        $in = ['@', '.'];
        $out = ['+', ','];

        $encrypted = str_replace($in, $out, str_rot13($this->email));
        $message = 'Please activate JavaScript to see this email address.';

        $encryptClass = ($this->createAnchors) ? 'cmoe' : 'cmoa';

        return HTML::span(['.cmo'],
            HTML::span(['.cmom'], $message) .
            HTML::span([".$encryptClass"], $encrypted)
        );
    }
}
