<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

class Email extends Module
{
    public function __construct($email, $createAnchors = true)
    {
        $path = $this->getSetup()->getSettings('PathCme') . '/CMEsteban/Page';
        $this->getTemplate()->addScript($path . '/js/lib.js');
        $this->getTemplate()->addScript($path . '/js/mail.js');
        $this->getTemplate()->addStylesheet($path . '/css/mail.css');

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
