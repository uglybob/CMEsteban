<?php

namespace CMEsteban\Page\Module;

class Cache extends Form
{
    // {{{ constructor
    public function __construct($controller, $page)
    {
        parent::__construct($controller, $page);

        $list = \CMEsteban\Lib\Cache::list();
        $rendered = '';

        if (is_array($list)) {
            foreach ($list as $file => $valid) {
                $rendered .= HTML::div($file . ' ' . $valid . 's');
            }
        }

        $this->form = new \Depage\HtmlForm\HtmlForm('clear' , ['label' => 'clear']);
        $this->form->addHTML($rendered);
        $this->form->addBoolean('sure', ['label' => $name . ' sure?'])->setRequired();
        $this->form->process();

        if ($this->form->validate()) {
            \CMEsteban\Lib\Cache::clear();
            $this->form->clearSession();
            \CMEsteban\Page\Page::redirect('/cache');
        }
    }
    // }}}
}
