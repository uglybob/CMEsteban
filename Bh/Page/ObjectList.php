<?php

namespace Bh\Page;

class ObjectList
{
    // {{{ constructor
    public function __construct(array $objects, $edit = null, $add = true)
    {
        $this->list = '';

        foreach ($objects as $object) {
            $properties = $this->getProperties($object);

            $propertyList = '';
            foreach ($properties as $property) {
                $propertyList .= HTML::span($property);
            }

            if ($edit) {
               $id = $object->getId();
               $this->list .= HTML::div(
                    HTML::span(['class' => 'properties'],
                        HTML::a(['href' => "/edit/$edit/$id"], $propertyList)
                    ) .
                    HTML::span(['class' => 'delete'],
                        HTML::a(['href' => "/delete/$edit/$id"], 'x')
                    )
                );
            } else {
                $this->list .= HTML::div(
                    HTML::span(['class' => 'properties'], $propertyList)
                );
            }
        }

        if ($add && $edit) {
            $this->list .= HTML::div(
                HTML::span(
                    HTML::a(['href' => "/edit/$edit/"], $edit . ' hinzufügen')
                )
            );
        }

        $this->list = HTML::div(['class' => 'objectList'], $this->list);
    }
    // }}}

    // {{{ getProperties
    public function getProperties($object)
    {
        return [$object];
    }
    // }}}

    // {{{ toString
    public function __toString()
    {
        return $this->list;
    }
    // }}}
}
