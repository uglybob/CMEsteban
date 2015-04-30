<?php

namespace Bh\Page;

use \depage\htmlform\htmlform;

class Edit extends Backend
{
    // {{{ constructor
    public function __construct($controller, $path)
    {
        $this->controller = $controller;

        $this->id = (isset($path[2])) ? $path[2] : null;
        $this->stylesheets[] = '/Page/css/depage-forms.css';
        $this->class = ucfirst($path[1]);
        $this->editString = $this->controller->getClass('Page', 'Edit' . ucfirst($this->class));

        $this->form = new htmlform('edit' . $this->class, ['label' => 'speichern']);

        $editString = $this->editString;
        $editString::createForm($this->form);

        $object = $controller->getLogic()->{'get' . $this->class}($this->id);
        if ($object) {
            $this->title = ucfirst($this->class) . ' editieren';
            $editString::populateForm($this->form, $object);
        } else {
            $this->title = ucfirst($this->class) . ' erstellen';
            $classString = '\Bh\Content\Entity\\' . $this->class;
            $this->object = new $classString;
        }

        $this->form->process();

        if ($this->form->validate()) {
            $editString::saveForm($this->form, $object);
            $object->save();
            $this->form->clearSession();
            $this->redirect('/Directory/' . $this->class);
        }
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->form;
    }
    // }}}
}
