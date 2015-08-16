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

        $this->setLogic();
        $this->buildForm();
    }
    // }}}

    // {{{ setLogic
    protected function setLogic()
    {
        $this->logic = $this->controller->getLogic();
    }
    // }}}
    // {{{ buildForm
    protected function buildForm()
    {
        $this->form = new \Depage\HtmlForm\HtmlForm('edit' . $this->class . $this->id, ['label' => 'speichern']);
        $this->form->registerNamespace('\\Bh\\Page');

        $this->object = $this->logic->{'get' . $this->class}($this->id);

        $this->create();

        if ($this->object) {
            $this->title = $this->class . ' editieren';
            $this->populate();
        } else {
            $this->title = $this->class . ' erstellen';
            $classString = '\\Bh\\Entity\\' . $this->class;
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
    // }}}

    // {{{ renderContent
    public function renderContent()
    {
        return $this->form;
    }
    // }}}
}
