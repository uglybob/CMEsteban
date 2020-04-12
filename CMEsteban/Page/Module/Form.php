<?php

namespace CMEsteban\Page\Module;

abstract class Form extends Module
{
    protected $form;

    protected function addStylesheets()
    {
        $this->addStylesheet('/CMEsteban/Page/css/depage-forms.css', true);
    }
    protected function render()
    {
        $this->prepare();

        return ($this->form) ? preg_replace('~>\\s+<~m', '><', $this->form->__toString()) : '';
    }

    protected function prepare()
    {
    }
}
