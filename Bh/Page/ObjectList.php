<?php

namespace Bh\Page;

use Bh\Lib\Html;

class ObjectList extends Page
{
    // {{{ renderList
    protected function renderList(array $objects, $edit = false)
    {
        $list = '';

        foreach ($objects as $object) {
            $properties = $this->loadProperties($object);

            $propertyList = '';
            foreach ($properties as $property) {
                $propertyList .= HTML::span('', $property);
            }

            if ($edit) {
               $list .= HTML::div('',
                    HTML::span('',
                        HTML::a('href=/edit/' . $edit . '/' . $object->getId(), $propertyList)
                    ) .
                    HTML::span('',
                        HTML::a('href=/delete/' . $edit . '/' . $object->getId(), 'x')
                    )
                );
            } else {
               $list .= HTML::div('',
                    HTML::span('', $propertyList)
                );
            }
        }

        if ($edit) {
            $list .= HTML::div('',
                HTML::span('',
                    HTML::a('href=/edit/' . $edit . '/', $edit . ' hinzufügen')
                )
            );
        }
        return $list;
    }
    // }}}
    // {{{ loadProperties
    protected function loadProperties($object)
    {
        return [$object->getName()];
    }
    // }}}
}
