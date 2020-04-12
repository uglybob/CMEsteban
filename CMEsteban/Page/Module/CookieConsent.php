<?php

namespace CMEsteban\Page\Module;

class CookieConsent extends Module
{
    public function __construct($message)
    {
        $this->message = $message;

        parent::__construct();
    }

    protected function addStylesheets()
    {
        $this->addStylesheet('/CMEsteban/Page/css/cookieConsent.css', true);
    }
    protected function addScripts()
    {
        $this->addScript('/CMEsteban/Page/js/lib.js', true);
        $this->addScript('/CMEsteban/Page/js/cookies.js', true);
        $this->addScript('/CMEsteban/Page/js/cookieConsent.js', true);
    }
    protected function render()
    {
        return HTML::div(['#cookieConsent'],
            HTML::div(
                HTML::div(['.ccwrap'],
                    HTML::div(['.cctext'], $this->message) .
                    HTML::div(['.ccbtn'], HTML::button('ok'))
                )
            )
        );
    }
}
