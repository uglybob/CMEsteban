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

        $object = $this->mapper->load($this->id);

        if ($object) {
            $this->title            = $this->class . ' editieren';
            $this->{$this->class}   = $object;

            $this->populateForm();
        } else {
            $this->title            = $this->class . ' erstellen';
            $classString            = '\BH\Entity\\' . $this->class;
            $this->{$this->class}   = new $classString();
        }

        $this->editForm->process();

        if ($this->editForm->validate()) {
            $this->saveForm();
            $this->mapper->save($this->{$this->class});
            $this->editForm->clearSession();

            $this->redirect('/Directory/' . $this->class);
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
