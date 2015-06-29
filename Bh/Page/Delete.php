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
        $this->logic = $controller->getLogic();

        $this->title = $this->class . ' löschen';
        $this->stylesheets[] = '/Bh/Page/css/depage-forms.css';

        $object = $this->logic->{'get' . $this->class}($this->id);

        if (!$object) {
            $this->redirect('/list/' . lcfirst($this->class));
        }

        $this->deleteForm = new \Depage\HtmlForm\HtmlForm('delete' . $this->class, ['label' => 'löschen']);
        $this->deleteForm->addBoolean('sure', ['label' => $object->getName() . ' wirklich löschen?'])->setRequired();
        $this->deleteForm->process();

        if ($this->deleteForm->validate()) {
            $object->delete();
            $this->logic->commit();
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
