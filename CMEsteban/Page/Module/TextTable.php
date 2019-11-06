<?php

namespace CMEsteban\Page\Module;

class TextTable extends EntityTable
{
    // {{{ getProperties
    public function getProperties($object)
    {
        $text = $object->getText();

        return [
            'Name' => $object->getName(),
            'Link' => $object->getPage(),
            'Text' => ((strlen($text) > 30) ? substr($text,0,27) . '...' : $text),
        ];
    }
    // }}}
}
