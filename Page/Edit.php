<?php

namespace BH\Page;

use \depage\htmlform\htmlform;

class Edit extends Backend
{
    // {{{ constructor
    public function __construct($controller, $path)
    {
        $this->handlePath($path);
        parent::__construct($controller, $path);

        $this->stylesheets[]    = '/Lib/css/depage-forms.css';
        $this->form             = new htmlform('edit' . $this->class, array('label' => 'speichern'));
        $this->mapper           = $this->controller->getMapper($this->class);
        $this->fields           = $this->mapper->getFields();
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

        $this->form->process();

        if ($this->form->validate()) {
            $this->saveForm();
            $this->redirect('/Directory/' . $this->class);
        }
    }
    // }}}
    // {{{ handlePath
    protected function handlePath($path)
    {
        $this->class = array_shift($path);
        $this->id = array_shift($path);
    }
    // }}}

    // {{{ createForm
    protected function createForm()
    {
        foreach($this->fields as $field) {
            if ($field->getType() == 'Connection') {
                $objects = $this->controller->getMapper($field->getClass())->getAll();
                $list = array('null' => 'auswählen');
                foreach($objects as $object) {
                    $list[$object->id] = $object->name;
                }
                // @todo merge with params
                $this->form->addSingle($field->getLabel(), array('skin' => 'select', 'list' => $list));
            } else {
                $addInput = 'add' . $field->getType();
                $this->form->$addInput($field->getLabel(), $field->getParams());
            }
        }
    }
    // }}}
    // {{{ populateForm
    protected function populateForm()
    {
        $data = array();
        foreach($this->fields as $field) {
            $data[$field->getLabel()] = $this->object->{$field->getName()};
        }

        $this->form->populate($data);
    }
    // }}}
    // {{{ saveForm
    protected function saveForm()
    {
        foreach($this->fields as $field) {
            $this->object->{$field->getName()} = $this->form->getValues()[$field->getLabel()];
        }
        $this->mapper->save($this->object);
        $this->form->clearSession();
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        return $this->form;
    }
    // }}}
}
