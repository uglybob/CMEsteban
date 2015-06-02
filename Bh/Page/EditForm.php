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
        // @todo hard coded
        $this->class = $class;
        $editString = $this->controller->getClass('Page', 'Edit' . $this->class);

        $this->form = new htmlform('edit' . $this->class, ['label' => 'speichern']);
        $object = $this->logic->{'get' . $this->class}($this->id);

        $this->createForm($object);

        if ($object) {
            $this->title = $this->class . ' editieren';
            $this->populateForm($object);
        } else {
            $this->title = $this->class . ' erstellen';
            // @todo hard coded
            $classString = '\Bh\Content\Entity\\' . $this->class;
            $object = new $classString();
        }

        $this->form->process();

        if ($this->form->validate()) {
            $this->saveForm($object);
            $this->logic->save($object);
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
