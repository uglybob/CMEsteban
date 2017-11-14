<?php

namespace Bh\Page;

use Bh\Lib\Mapper;

class Delete extends Backend
{
    // {{{ hookConstructor
    protected function hookConstructor()
    {
        $this->class = ucfirst($this->getPath(1));
        $this->id = $this->getPath(2);

        $this->title = 'delete ' . $this->class;
        $this->stylesheets[] = '/vendor/depage/htmlform/lib/css/depage-forms.css';

        $object = $this->controller->{'get' . $this->class}($this->id);

        if (!$object) {
            $this->redirect('/list/' . lcfirst($this->class));
        }

        $name = method_exists($object, 'getName') ? $object->getName() : $object->getId();

        $this->deleteForm = new \Depage\HtmlForm\HtmlForm('delete' . $this->class, ['label' => 'delete']);
        $this->deleteForm->addBoolean('sure', ['label' => $name . ' delete?'])->setRequired();
        $this->deleteForm->process();

        if ($this->deleteForm->validate()) {
            $object->delete();
            Mapper::commit();
            $this->deleteForm->clearSession();

            $this->redirect('/' . lcfirst($this->class) . 's');
        }
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->deleteForm;
    }
    // }}}
}
