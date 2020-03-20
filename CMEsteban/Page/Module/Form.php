<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;

abstract class Form extends Module
{
    protected $form;
    public function __construct()
    {
        parent::__construct();

        CMEsteban::$template->addStylesheet(CMEsteban::$setup->getSettings('PathCme') . '/CMEsteban/Page/css/depage-forms.css');
    }
    public function __toString()
    {
        return ($this->form) ? preg_replace('~>\\s+<~m', '><', $this->form->__toString()) : '';
    }
}
