<?php

namespace CMEsteban\Page\Module;

class Cache extends Form
{
    // {{{ constructor
    public function __construct($controller, $page)
    {
        parent::__construct($controller, $page);

        $list = Table::formatArray(\CMEsteban\Lib\Cache::list());
        $attributes = [0 => 'file', 1 => 'valid'];

        $rendered = new Table($page, $list, $attributes);

        $this->form = new \Depage\HtmlForm\HtmlForm('clear' , ['label' => 'clear']);
        $this->form->addHTML($rendered);
        $this->form->process();

        if ($this->form->validate()) {
            \CMEsteban\Lib\Cache::clear();
            $this->form->clearSession();
            \CMEsteban\Page\Page::redirect('/cache');
        }
    }
    // }}}
}
