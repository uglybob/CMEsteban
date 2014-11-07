<?php

namespace BH\Page;

class Delete extends Backend
{
    // {{{ constructor
    public function __construct($controller, $path)
    {
        parent::__construct($controller);
        $this->class            = array_shift($path);
        $this->id               = array_shift($path);

        $this->title            = $this->class . ' löschen';
        $this->stylesheets[]    = '/Lib/css/depage-forms.css';
        $this->mapper           = $this->controller->getMapper($this->class);

        $objects = $this->mapper->getAllWhere(array('id' => $this->id));

        if (isset($objects[0])) {
            $this->object = $objects[0];
        } else {
            $this->redirect('/Directory/' . $this->class);
        }

        $this->deleteForm = new \depage\htmlform\htmlform('delete' . $this->class, array('label' => 'löschen'));
        $this->deleteForm->addBoolean('sure', array('label' => $this->object->name . ' wirklich löschen?'))->setRequired();
        $this->deleteForm->process();

        if ($this->deleteForm->validate()) {
            $this->mapper->delete($this->object);
            $this->deleteForm->clearSession();

            $this->redirect('/Directory/' . $this->class);
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
