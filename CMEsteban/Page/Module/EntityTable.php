<?php

namespace CMEsteban\Page\Module;

class EntityTable extends Table
{
    // {{{ constructor
    public function __construct(array $entities, $edit = null, $add = true, $delete = 'Delete')
    {
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
            $this->list .= HTML::div(
                HTML::div(
                    HTML::a(['href' => "/edit/$edit/"], 'add ' . $edit)
                )
            );
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
