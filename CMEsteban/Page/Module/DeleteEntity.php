<?php

namespace CMEsteban\Page\Module;

use CMEsteban\Lib\Mapper;
use CMEsteban\Page\Page;

class DeleteEntity extends Form
{
    // {{{ constructor
    public function __construct($controller, $page)
    {
        parent::__construct($controller, $page);

        $this->class = ucfirst($page->getPath(1));
        $this->id = $page->getPath(2);

        $entity = $controller->{'get' . $this->class}($this->id);

        if (!$entity) {
            Page::redirect('/' . lcfirst($this->class) . 's');
        }

        $name = method_exists($entity, 'getName') ? $entity->getName() : $entity->getId();

        $this->form = new \Depage\HtmlForm\HtmlForm('delete' . $this->class, ['label' => 'delete']);
        $this->form->addBoolean('sure', ['label' => $name . ' delete?'])->setRequired();
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
