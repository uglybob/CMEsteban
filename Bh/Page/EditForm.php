<?php

namespace Bh\Page;

use \depage\htmlform\htmlform;

class EditForm
{
    // {{{ constructor
    public function __construct($controller, $class, $id)
    {
        $this->controller = $controller;
        $this->logic = $controller->getLogic();
        $this->id = $id;
        $this->class = $class;

        $this->form = new htmlform('edit' . $this->class, ['label' => 'speichern']);
        $this->object = $this->logic->{'get' . $this->class}($this->id);

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
    // }}}

    // {{{ renderContent
    public function renderContent()
    {
        return $this->form;
    }
    // }}}
}
