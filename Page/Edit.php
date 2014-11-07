<?php

namespace BH\Page;

class Edit extends Backend
{
    // {{{ constructor
    public function __construct($controller, $path)
    {
        parent::__construct($controller);
        $this->handlePath($path);

        $this->stylesheets[]    = '/Lib/css/depage-forms.css';
        $this->editForm         = new \depage\htmlform\htmlform('edit' . $this->class, array('label' => 'speichern'));

        $this->mapper           = $this->controller->getMapper($this->class);
        $this->createForm();

        $objects = $this->mapper->getAllWhere(array('id' => $this->id));

        if (isset($objects[0])) {
            $this->title    = $this->class . ' editieren';
            $this->object   = $objects[0];

            $this->populateForm();
        } else {
            $this->title    = $this->class . ' erstellen';
            $classString    = '\BH\Entity\\' . $this->class;
            $this->object   = new $classString();
        }

        $this->editForm->process();

        if ($this->editForm->validate()) {
            $this->saveForm();

            $this->mapper->save($this->object);
            $this->editForm->clearSession();

            header('Location: /Directory/' . $this->class);
            die();
        }
    }
    // }}}
    // {{{ handlePath
    protected function handlePath($path)
    {
        $this->class    = array_shift($path);
        $this->id       = array_shift($path);
    }
    // }}}

    // {{{ createForm
    protected function createForm()
    {
    }
    // }}}
    // {{{ populateForm
    protected function populateForm()
    {
    }
    // }}}
    // {{{ saveForm
    protected function saveForm()
    {
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->editForm;
    }
    // }}}
}
