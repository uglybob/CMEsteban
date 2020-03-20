<?php

namespace CMEsteban\Page\Module;

use Depage\HtmlForm\HtmlForm;
use CMEsteban\Page\Page;

class EntityTable extends Table
{
    public function __construct($class, array $entities, $edit = true, $add = true, $delete = '-1')
    {
        $rows = [];
        $classes = [];

        foreach ($entities as $entity) {
            $properties = $entity->getRow();

            if ($edit) {
                $id = $entity->getId();
                foreach ($properties as $key => $property) {
                    $properties[$key] = HTML::a(['href' => "/edit/$class/$id"], $property);
                }
            }

            if ($delete) {
                $properties[] = HTML::a(['href' => "/delete/$class/$id"], 'x');
            }

            $rows[] = $properties;
            $classes[] = $this->getClasses($entity);
        }

        $fullClass = "\\CMEsteban\\Entity\\$class";
        $headings = $fullClass::getHeadings();

        if ($delete) {
            $headings[] = $delete;
        }

        parent::__construct($rows, $headings, $classes);

        if ($add && $edit) {
            $label = ($add === true) ? '+1' : $add;
            $this->form = new HtmlForm('login', ['label' => $label]);
            $this->form->process();

            if ($this->form->validate()) {
                $this->form->clearSession();
                Page::redirect("/edit/$class/");
            }
        }
    }

    public function getClasses($entity)
    {
        $classes = [];

        if ($entity->isDeleted()) {
            $classes[] = '.ctdeleted';
        }

        return $classes;
    }
}
