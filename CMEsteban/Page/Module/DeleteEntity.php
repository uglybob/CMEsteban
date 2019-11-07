<?php

namespace CMEsteban\Page\Module;

use CMEsteban\CMEsteban;
use CMEsteban\Lib\Mapper;
use CMEsteban\Page\Page;

class DeleteEntity extends Form
{
    // {{{ constructor
    public function __construct()
    {
        parent::__construct();

        $this->class = ucfirst(CMEsteban::$page->getPath(1));
        $this->id = CMEsteban::$page->getPath(2);

        $entity = CMEsteban::$controller->{'get' . $this->class}($this->id);

        if (!$entity) {
            Page::redirect('/' . lcfirst($this->class) . 's');
        }

        $name = is_callable([$entity, 'getName']) ? $entity->getName() : $entity->getId();

        $this->form = new \Depage\HtmlForm\HtmlForm('delete' . $this->class, ['label' => 'delete']);
        $this->form->addBoolean('sure', ['label' => 'delete ' . $name . '?'])->setRequired();
        $this->form->process();

        if ($this->form->validate()) {
            $entity->delete();
            Mapper::commit();
            $this->form->clearSession();

            Page::redirect('/' . lcfirst($this->class) . 's');
        }
    }
    // }}}
}
