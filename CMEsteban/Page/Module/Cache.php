<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;
use CMEsteban\Page\Page;
use Depage\HtmlForm\HtmlForm;

class Cache extends Form
{
    protected function prepare()
    {
        $cache = $this->getCache();

        $files = $cache->list();
        $path = $cache->getDir();
        $list = [];

        foreach ($files as $file => $valid) {
            $list[str_replace("$path/", '', $file)] = $valid;
        }

        $list = Table::formatArray($list);
        $attributes = [0 => 'file', 1 => 'valid (s)'];

        $rendered = new Table($list, $attributes);

        $this->form = new HtmlForm('clear' , ['label' => 'clear']);
        $this->form->addHTML($rendered);
        $this->form->process();

        if ($this->form->validate()) {
            $cache->clear();
            $this->form->clearSession();
            Page::redirect('/cache');
        }
    }
}
