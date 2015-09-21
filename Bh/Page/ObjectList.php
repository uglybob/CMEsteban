<?php

namespace Bh\Page;

class ObjectList
{
    // {{{ constructor
    public function __construct(array $objects, $edit = null, $add = true, $delete = true)
    {
        $this->list = '';

        foreach ($objects as $object) {
            $properties = $this->getProperties($object);

            $propertyList = '';
            foreach ($properties as $class => $property) {
                $propertyList .= HTML::span(['class' => $class], $property);
            }

            $id = $object->getId();

            if ($edit) {
                $properties = HTML::span(['class' => 'properties'],
                    HTML::a(['href' => "/edit/$edit/$id"], $propertyList)
                );
            } else {
                $properties = HTML::span(['class' => 'properties'], $propertyList);
            }

            if ($delete) {
                $deleteLink = HTML::span(['class' => 'delete'],
                    HTML::a(['href' => "/delete/$edit/$id"], 'x')
                );
            } else {
                $deleteLink = '';
            }

            $this->list .= HTML::div(['class' => 'objectRow'], $properties . $deleteLink);
        }

        if ($add && $edit) {
            $this->list .= HTML::div(
                HTML::span(
                    HTML::a(['href' => "/edit/$edit/"], 'add ' . $edit)
                )
            );
        }

        $this->list = HTML::div(['class' => 'objectList'], $this->list);
    }
    // }}}

    // {{{ getProperties
    public function getProperties($object)
    {
        return ['name' => $object];
    }
    // }}}

    // {{{ toString
    public function __toString()
    {
        return $this->list;
    }
    // }}}
}
