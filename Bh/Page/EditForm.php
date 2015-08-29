<?php

namespace Bh\Page;

class EditForm
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
        $this->form = new \Depage\HtmlForm\HtmlForm('edit' . $this->class . $this->id, ['label' => 'speichern']);
        $this->form->registerNamespace('\\Bh\\Page');

        $this->loadObject();

        $this->create();

        if ($this->object) {
            $this->title = $this->class . ' editieren';
            $this->populate();
        } else {
            $this->title = $this->class . ' erstellen';
            $this->instantiateObject();
        }

        $this->form->process();

        if ($this->form->validate()) {
            $this->save();
            $this->form->clearSession();
            $this->redirect();
        }
    }
    // }}}
    // {{{ loadObject
    protected function loadObject()
    {
        $getter = 'get' . ucfirst($this->class);
        $this->object = $this->controller->$getter($this->id);
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

    // {{{ renderContent
    public function renderContent()
    {
        return $this->form;
    }
    // }}}
}
