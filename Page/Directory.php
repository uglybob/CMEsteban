<?php

namespace Bh\Page;

use Bh\Lib\Html;

class Directory extends Backend
{
    // {{{ constructor
    public function __construct($controller, $path)
    {
        parent::__construct($controller);
        $this->class    = array_shift($path);
        $this->title    = $this->class . ' directory';
        $this->mapper   = $this->controller->getMapper($this->class);
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        $content = '';

        foreach($this->mapper->getAll() as $object) {
            $content .= HTML::div('',
                HTML::span('',
                    HTML::a('href=/Edit/' . $this->class . '/' . $object->id, $object->name)
                ) .
                HTML::span('',
                    HTML::a('href=/Delete/' . $this->class . '/' . $object->id, 'löschen')
                )
            );
        }

        $content .= HTML::div('',
            HTML::span('',
                HTML::a('href=/Edit/' . $this->class . '/', $this->class . ' hinzufügen')
            )
        );

        return $content;
    }
    // }}}
}
