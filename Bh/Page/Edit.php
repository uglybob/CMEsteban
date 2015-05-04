<?php

namespace Bh\Page;

use \depage\htmlform\htmlform;

class Edit extends Backend
{
    // {{{ constructor
    public function __construct($controller, $path)
    {
        $this->controller = $controller;
        $this->logic = $controller->getLogic();

        $this->id = (isset($path[2])) ? $path[2] : null;
        // @todo hard coded
        $this->stylesheets[] = '/Bh/Page/css/depage-forms.css';
        $this->class = ucfirst($path[1]);
        $editString = $this->controller->getClass('Page', 'Edit' . $this->class);

        $this->form = new htmlform('edit' . $this->class, ['label' => 'speichern']);

        $editString::createForm($this->form);

        $object = $this->logic->{'get' . $this->class}($this->id);
        if ($object) {
            $this->title = $this->class . ' editieren';
            $editString::populateForm($this->form, $object);
        } else {
            $this->title = $this->class . ' erstellen';
            // @todo hard coded
            $classString = '\Bh\Content\Entity\\' . $this->class;
            $object = new $classString();
        }

        $this->form->process();

        if ($this->form->validate()) {
            $editString::saveForm($this->form, $object);
            $this->logic->save($object);
            $this->logic->commit();
            $this->form->clearSession();
            $this->redirect('/list/' . lcfirst($this->class));
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
