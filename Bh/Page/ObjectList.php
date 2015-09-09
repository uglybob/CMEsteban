<?php

namespace Bh\Page;

class ObjectList
{
    // {{{ constructor
    public function __construct(array $objects, $edit = null)
    {
        $this->list = '';

        foreach ($objects as $object) {
            $properties = $object->getRow();

            $propertyList = '';
            foreach ($properties as $property) {
                $propertyList .= HTML::span($property);
            }

            if ($edit) {
               $this->list .= HTML::div(
                    HTML::span(
                        HTML::a(['href' => '/edit/' . $edit . '/' . $object->getId()], $propertyList)
                    ) .
                    HTML::span(
                        HTML::a(['href' => '/delete/' . $edit . '/' . $object->getId()], 'x')
                    )
                );
            } else {
               $this->list .= HTML::div(
                    HTML::span($propertyList)
                );
            }
        }

        if ($edit) {
            $this->list .= HTML::div(
                HTML::span(
                    HTML::a(['href' => '/edit/' . $edit . '/'], $edit . ' hinzufügen')
                )
            );
        }
    }
    // }}}

    // {{{
    public function __toString()
    {
        return $this->list;
    }
    // }}}
}
