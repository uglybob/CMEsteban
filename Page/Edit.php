<?php

namespace BH\Page;

use \depage\htmlform\htmlform;

class Edit extends Backend
{
    // {{{ constructor
    public function __construct($controller, $path)
    {
        parent::__construct($controller);
        $this->handlePath($path);

        $this->stylesheets[]    = '/Lib/css/depage-forms.css';
        $this->form             = new htmlform('edit' . $this->class, array('label' => 'speichern'));
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
            $params = (isset($field['params'])) ? $field['params'] : array();
            if ($field['input'] == 'Connection') {
                $objects = $this->controller->getMapper(ucfirst($field['name']))->getAll();
                $list = array('null' => 'auswählen');
                foreach($objects as $object) {
                    $list[$object->id] = $object->name;
                }
                // @todo merge with params
                $this->form->addSingle($field['label'], array('skin' => 'select', 'list' => $list));
            } else {
                $addInput = 'add' . $field['input'];
                $this->form->$addInput($field['label'], $params);
            }
        }
    }
    // }}}
    // {{{ populateForm
    protected function populateForm()
    {
        $data = array();
        foreach($this->fields as $field) {
            $data[$field['label']] = $this->object->{$field['name']};
        }

        $this->form->populate($data);
    }
    // }}}
    // {{{ saveForm
    protected function saveForm()
    {
        foreach($this->fields as $field) {
            $this->object->{$field['name']} = $this->form->getValues()[$field['label']];
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
