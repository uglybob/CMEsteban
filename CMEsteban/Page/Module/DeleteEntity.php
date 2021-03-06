<?php

namespace CMEsteban\Page\Module;

use CMEsteban\Lib\Mapper;
use CMEsteban\Page\Page;

class DeleteEntity extends Form
{
    protected function prepare()
    {
        $this->class = ucfirst($this->getPage()->getPath(1));
        $this->id = $this->getPage()->getPath(2);

        $entity = $this->getController()->{'get' . $this->class}($this->id);

        if (!$entity) {
            Page::redirect('/' . lcfirst($this->class) . 's');
        }

        $name = is_callable([$entity, 'getName']) ? $entity->getName() : $entity->getId();

        $delete = ($entity->isDeleted()) ? 'undelete' : 'delete';

        $this->form = new \Depage\HtmlForm\HtmlForm($delete . $this->class, ['label' => $delete]);
        $this->form->addBoolean('sure', ['label' => "$delete " . $name . '?'])->setRequired();
        $this->form->process();

        if ($this->form->validate()) {
            $entity->$delete();
            Mapper::commit();
            $this->form->clearSession();

            Page::redirect('/table/' . $this->class);
        }
    }
}
