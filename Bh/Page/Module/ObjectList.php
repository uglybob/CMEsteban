<?php

namespace Bh\Page\Module;

class ObjectList
{
    // {{{ constructor
    public function __construct(array $objects, $edit = null, $add = true, $delete = 'Delete')
    {
        $this->list = '';
        $first = true;

        foreach ($objects as $object) {
            $properties = $this->getProperties($object);
            $id = $object->getId();

            if ($first) {
                $header = '';
                foreach ($properties as $class => $property) {
                    $header .= HTML::div(['.bhthead'], $class);
                }

                if ($delete) {
                    $header .= HTML::div(['.bhthead'], $delete);
                }

                $this->list .= HTML::div(['.bhtheader'], HTML::div(['.bhtrow'], $header));
                $first = false;
            }

            $propertyList = '';
            foreach ($properties as $class => $property) {
                if ($edit) {
                    $property = HTML::a(['href' => "/edit/$edit/$id"], $property);
                }

                $propertyList .= HTML::div([".$class", '.bhtcell'], $property);
            }

            if ($delete) {
                $deleteLink = HTML::div(['.delete', '.bhtcell'],
                    HTML::a(['href' => "/delete/$edit/$id"], 'x')
                );
            } else {
                $deleteLink = '';
            }

            $this->list .= HTML::div(['.bhtrow'], $propertyList . $deleteLink);
        }

        if ($add && $edit) {
            $this->list .= HTML::div(
                HTML::div(
                    HTML::a(['href' => "/edit/$edit/"], 'add ' . $edit)
                )
            );
        }

        $this->list = HTML::div(['.bhtable'], $this->list);
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
