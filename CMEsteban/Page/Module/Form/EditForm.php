<?php

namespace CMEsteban\Page\Module\Form;

abstract class EditForm
{
    // {{{ constructor
    public function __construct($controller, $class, $id)
    {
        $this->controller = $controller;
        $this->id = $id;
        $this->class = $class;

        $this->buildForm();
    }
    // }}}

    // {{{ buildForm
    protected function buildForm()
    {
        $this->form = new \Depage\HtmlForm\HtmlForm('edit' . $this->class . $this->id, ['label' => 'save']);

        $this->loadEntity();

        $this->create();

        if ($this->entity) {
            $this->title = 'edit ' . $this->class;
        } else {
            $this->title = 'create ' . $this->class;
            $this->instantiateEntity();
        }

        $this->populate();
        $this->form->process();

        if ($this->form->validate()) {
            $this->save();
            $this->form->clearSession();
            $this->redirect();
        }
    }
    // }}}
    // {{{ populate
    protected function populate()
    {
    }
    // }}}
    // {{{ loadEntity
    protected function loadEntity()
    {
        if (!is_null($this->id)) {
            $getter = 'get' . ucfirst($this->class);
            $this->entity = $this->controller->$getter($this->id);
        }
    }
    // }}}
    // {{{ instantiateEntity
    protected function instantiateEntity()
    {
        $classString = 'CMEsteban\\Entity\\' . $this->class;
        $this->entity = new $classString();
    }
    // }}}
    // {{{ redirect
    protected function redirect()
    {
        Page::redirect('/list/' . lcfirst($this->class));
    }
    // }}}

    // {{{ toString
    public function __toString()
    {
        return (string) $this->form;
    }
    // }}}
}
