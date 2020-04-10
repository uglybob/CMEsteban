<?php

namespace CMEsteban\Page\Module;

abstract class Form extends Module
{
    protected $form;

    public function __construct()
    {
        $this->getTemplate()->addStylesheet($this->getSetup()->getSettings('PathCme') . '/CMEsteban/Page/css/depage-forms.css');

        parent::__construct();
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
