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
            $this->title    = $this->class . ' editieren';
            $this->object   = $object;
            $this->populateForm();
        } else {
            $this->title    = $this->class . ' erstellen';
            $classString    = '\BH\Entity\\' . $this->class;
            $this->object   = new $classString();
        }

        $this->editForm->process();

        if ($this->editForm->validate()) {
            $this->saveForm();
            $this->mapper->save($this->object);
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
        $this->addElements();

        foreach($this->connections() as $connection => $label) {
            $objects = $this->controller->getMapper($connection)->getAll();
            $list = array('null' => 'auswählen');
            foreach($objects as $object) {
                $list[$object->id] = $object->name;
            }
            $this->editForm->addSingle($label, array('skin' => 'select', 'list' => $list));
        }
    }
    // }}}
    // {{{ populateForm
    protected function populateForm()
    {
        $data = $this->populateArray();

        foreach($this->connections() as $connection => $label) {
            $data[$label] = $this->object->{strtolower($connection)};
        }

        $this->editForm->populate($data);
    }
    // }}}
    // {{{ saveForm
    protected function saveForm()
    {
        $this->saveObject();

        foreach($this->connections() as $connection => $label) {
            $this->object->{strtolower($connection)} = $this->editForm->getValues()[$label];
        }

    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->editForm;
    }
    // }}}
}
