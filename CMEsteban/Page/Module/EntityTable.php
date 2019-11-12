<?php

namespace CMEsteban\Page\Module;

use Depage\HtmlForm\HtmlForm;
use CMEsteban\Page\Page;

class EntityTable extends Table
{
    // {{{ constructor
    public function __construct(array $entities, $edit = null, $add = true, $delete = 'Delete')
    {
        $items = [];

        foreach ($entities as $entity) {
            $properties = $this->getProperties($entity);

            if ($edit) {
                $id = $entity->getId();
                foreach ($properties as $key => $property) {
                    $properties[$key] = HTML::a(['href' => "/edit/$edit/$id"], $property);
                }
            }

            if ($delete) {
                $properties[$delete] = HTML::a(['href' => "/delete/$edit/$id"], 'x');
            }

            $items[] = $properties;
        }

        parent::__construct($items);

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

    // {{{ getProperties
    public function getProperties($entity)
    {
        return ['name' => $entity];
    }
    // }}}
}
