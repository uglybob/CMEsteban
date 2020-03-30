<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

class Email extends Module
{
    public function __construct($email)
    {
        $path = CMEsteban::$setup->getSettings('PathCme') . '/CMEsteban/Page';
        CMEsteban::$template->addScript($path . '/js/lib.js');
        CMEsteban::$template->addScript($path . '/js/mail.js');
        CMEsteban::$template->addStylesheet($path . '/css/mail.css');

        $this->email = $email;

        parent::__construct();
    }

    protected function render()
    {
        $in = ['@', '.'];
        $out = ['+', ','];

        $encrypted = str_replace($in, $out, str_rot13($this->email));
        $message = 'Please activate JavaScript to see this email address.';

        return HTML::span(['.cmo'],
            HTML::span(['.cmom'], $message) .
            HTML::span(['.cmoe'], $encrypted)
        );
    }
}
