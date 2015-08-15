<?php

namespace Bh\Page;

class EditForm
{
    // {{{ constructor
    public function __construct($controller, $class, $id)
    {
        $this->controller = $controller;
        $this->logic = $controller->getLogic();
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
        $this->object = $this->loadObject();

        $this->create();

        if ($this->object) {
            $this->title = $this->class . ' editieren';
            $this->populate();
        } else {
            $this->title = $this->class . ' erstellen';
            $classString = $this->controller->getClass('Entity', $this->class);
            $this->object = new $classString();
        }

        $this->form->process();

        if ($this->form->validate()) {
            $this->save();
            $this->logic->save($this->object);
            $this->logic->commit();
            $this->form->clearSession();
            Page::redirect('/list/' . lcfirst($this->class));
        }
    }

    // {{{ loadObject
    protected function loadObject()
    {
        return $this->logic->{'get' . $this->class}($this->id);
    }
 
    // {{{ renderContent
    public function renderContent()
    {
        return $this->form;
    }
    // }}}
}
