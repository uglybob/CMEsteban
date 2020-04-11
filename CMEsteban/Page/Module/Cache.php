<?php

namespace CMEsteban\Page\Module;

use CMEsteban\Page\Page;
use Depage\HtmlForm\HtmlForm;

class Cache extends Form
{
    protected function prepare()
    {
        $cache = $this->getCache();
        $frontCache = $this->getFrontCache();

        $files = array_merge($cache->list(), $frontCache->list());
        $list = [];

        foreach ($files as $file => $valid) {
            $list[$file] = $valid;
        }

        $list = Table::formatArray($list);
        $attributes = [0 => 'file', 1 => 'valid (s)'];

        $rendered = new Table($list, $attributes);

        $this->form = new HtmlForm('clear' , ['label' => 'clear']);
        $this->form->addHTML($rendered);
        $this->form->process();

        if ($this->form->validate()) {
            $cache->clear();
            $frontCache->clear();

            $this->form->clearSession();
            Page::redirect('/cache');
        }
    }
}
