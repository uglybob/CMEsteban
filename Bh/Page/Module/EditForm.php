<?php

namespace Bh\Page\Module;

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

        $this->loadObject();

        $this->create();

        if ($this->object) {
            $this->title = 'edit ' . $this->class;
        } else {
            $this->title = 'create ' . $this->class;
            $this->instantiateObject();
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
    // {{{ loadObject
    protected function loadObject()
    {
        if (!is_null($this->id)) {
            $getter = 'get' . ucfirst($this->class);
            $this->object = $this->controller->$getter($this->id);
        }
    }
    // }}}
    // {{{ instantiateObject
    protected function instantiateObject()
    {
        $classString = 'Bh\\Entity\\' . $this->class;
        $this->object = new $classString();
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
