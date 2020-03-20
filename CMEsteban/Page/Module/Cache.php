<?php

namespace CMEsteban\Page\Module;

class Cache extends Form
{
    public function __construct()
    {
        parent::__construct();

        $cache = \CMEsteban\Lib\Cache::list();
        $path = \CMEsteban\Lib\Cache::getDir();
        $list = [];

        foreach ($cache as $file => $valid) {
            $list[str_replace("$path/", '', $file)] = $valid;
        }

        $list = Table::formatArray($list);
        $attributes = [0 => 'file', 1 => 'valid (s)'];

        $rendered = new Table($list, $attributes);

        $this->form = new \Depage\HtmlForm\HtmlForm('clear' , ['label' => 'clear']);
        $this->form->addHTML($rendered);
        $this->form->process();

        if ($this->form->validate()) {
            \CMEsteban\Lib\Cache::clear();
            $this->form->clearSession();
            \CMEsteban\Page\Page::redirect('/cache');
        }
    }
}
