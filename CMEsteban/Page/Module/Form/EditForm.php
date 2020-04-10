<?php

namespace CMEsteban\Page\Module\Form;

use CMEsteban\CMEsteban;
use CMEsteban\Lib\Mapper;
use CMEsteban\Page\Page;

abstract class EditForm
{
    protected $entity;
    public function __construct($class, $id)
    {
        $this->id = $id;
        $this->class = $class;

        $this->buildForm();
    }

    protected function buildForm()
    {
        $this->form = new \Depage\HtmlForm\HtmlForm('edit' . $this->class . $this->id, ['label' => 'save']);

        $this->loadEntity();

        $this->create();

        if ($this->entity) {
            $this->title = 'edit ' . $this->class;
        } else {
            $this->title = 'create ' . $this->class;
            $this->instantiateEntity();
        }

        $this->populate();
        $this->form->process();

        if ($this->form->validate()) {
            try {
                $this->save();
                $this->form->clearSession();
                $this->redirect();
            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                $this->form->addHTML('Error: duplicate entry, try again :)');
            }
        }
    }
    protected function create()
    {
    }
    protected function populate()
    {
    }
    protected function save()
    {
        $this->entity->save();

        Mapper::commit();
    }
    protected function loadEntity()
    {
        if ($this->id) {
            $getter = 'get' . ucfirst($this->class);
            $this->entity = $this->getController()->$getter($this->id);
        }
    }
    protected function instantiateEntity()
    {
        $classString = 'CMEsteban\\Entity\\' . $this->class;
        $this->entity = new $classString('');
    }
    protected function redirect()
    {
        Page::redirect('/table/' . $this->class);
    }

    public function __toString()
    {
        return (string) $this->form;
    }

    public function entityList(array $entities)
    {
       $list = [];

        foreach ($entities as $entity) {
            $list[$entity->getId()] = $entity->getName();
        }

        return $list;
    }
}
