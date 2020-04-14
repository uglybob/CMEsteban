<?php

namespace CMEsteban\Page\Module;

/**
 * Thanks to https://loading.io/css/
 */
class Loader extends Module
{
    protected function addStylesheets()
    {
        $this->addStylesheet('/CMEsteban/Page/css/loader.css', true);
    }
    protected function render()
    {
        return HTML::div(['.loader'],
            HTML::div(['.lds-ellipsis'],
                HTML::div() . HTML::div() . HTML::div() . HTML::div()
            )
        );
    }
}
