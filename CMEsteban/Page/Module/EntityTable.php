<?php

namespace CMEsteban\Page\Module;

use Depage\HtmlForm\HtmlForm;
use CMEsteban\Page\Page;

class EntityTable extends Table
{
    // {{{ constructor
    public function __construct(array $entities, $edit = null, $add = true, $delete = 'Delete')
    {
        $rows = [];
        $classes = [];

        foreach ($entities as $entity) {
            $properties = $this->getRow($entity);

            if ($edit) {
                $id = $entity->getId();
                foreach ($properties as $key => $property) {
                    $properties[$key] = HTML::a(['href' => "/edit/$edit/$id"], $property);
                }
            }

            if ($delete) {
                $properties[] = HTML::a(['href' => "/delete/$edit/$id"], 'x');
            }

            $rows[] = $properties;
            $classes[] = $this->getClasses($entity);
        }

        $headings = $this->getHeadings();

        if ($delete) {
            $headings[] = $delete;
        }

        parent::__construct($rows, $headings, $classes);

        if ($add && $edit) {
            $label = ($add === true) ? '+1' : $add;
            $form = new HtmlForm('login', ['label' => $label]);
            $form->process();

            if ($form->validate()) {
                $form->clearSession();
                Page::redirect("/edit/$edit/");
            }

            $this->table .= $form;
        }
    }
    // }}}

    // {{{ getHeadings
    public function getHeadings()
    {
        return ['Name'];
    }
    // }}}
    // {{{ getRow
    public function getRow($entity)
    {
        return [$entity];
    }
    // }}}
    // {{{ getClasses
    public function getClasses($entity)
    {
        $classes = [];

        if ($entity->isDeleted()) {
            $classes[] = '.ctdeleted';
        }

        return $classes;
    }
    // }}}
}
