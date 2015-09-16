<?php

namespace Bh\Page;

class Delete extends Backend
{
    // {{{ constructor
    public function __construct($controller, $path)
    {
        $this->class = ucfirst($path[1]);
        $this->id = $path[2];

        $this->controller = $controller;

        $this->title = 'delete ' . $this->class;
        $this->stylesheets[] = '/Bh/Page/css/depage-forms.css';

        $object = $this->controller->{'get' . $this->class}($this->id);

        if (!$object) {
            $this->redirect('/list/' . lcfirst($this->class));
        }

        $this->deleteForm = new \Depage\HtmlForm\HtmlForm('delete' . $this->class, ['label' => 'delete']);
        $this->deleteForm->addBoolean('sure', ['label' => $object->getName() . ' delete?'])->setRequired();
        $this->deleteForm->process();

        if ($this->deleteForm->validate()) {
            $object->delete();
            $this->controller->commit();
            $this->deleteForm->clearSession();

            $this->redirect('/list/' . lcfirst($this->class));
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
