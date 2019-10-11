<?php

namespace CMEsteban\Page\Module;

class EntityList
{
    // {{{ constructor
    public function __construct($page, array $entitys, $edit = null, $add = true, $delete = 'Delete')
    {
        $page->addStylesheet('/CMEsteban/Page/css/table.css');

        $this->list = '';
        $first = true;

        foreach ($entitys as $entity) {
            $properties = $this->getProperties($entity);
            $id = $entity->getId();

            if ($first) {
                $header = '';
                foreach ($properties as $class => $property) {
                    $header .= HTML::div(['.cmestebanthead'], $class);
                }

                if ($delete) {
                    $header .= HTML::div(['.cmestebanthead'], $delete);
                }

                $this->list .= HTML::div(['.cmestebantheader'], HTML::div(['.cmestebantrow'], $header));
                $first = false;
            }

            $propertyList = '';
            foreach ($properties as $class => $property) {
                if ($edit) {
                    $property = HTML::a(['href' => "/edit/$edit/$id"], $property);
                }

                $propertyList .= HTML::div([".$class", '.cmestebantcell'], $property);
            }

            if ($delete) {
                $deleteLink = HTML::div(['.delete', '.cmestebantcell'],
                    HTML::a(['href' => "/delete/$edit/$id"], 'x')
                );
            } else {
                $deleteLink = '';
            }

            $this->list .= HTML::div(['.cmestebantrow'], $propertyList . $deleteLink);
        }

        if ($add && $edit) {
            $this->list .= HTML::div(
                HTML::div(
                    HTML::a(['href' => "/edit/$edit/"], 'add ' . $edit)
                )
            );
        }

        $this->list = HTML::div(['.cmestebantable'], $this->list);
    }
    // }}}

    // {{{ getProperties
    public function getProperties($entity)
    {
        return ['name' => $entity];
    }
    // }}}

    // {{{ toString
    public function __toString()
    {
        return $this->list;
    }
    // }}}
}
