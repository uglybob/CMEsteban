<?php

namespace Bh\Page;

use Bh\Lib\Html;

class ObjectList extends Backend
{
    // {{{ constructor
    public function __construct($controller, $path)
    {
        $this->class = $path[1];
        parent::__construct($controller);
        $this->title = $this->class . ' list';
    }
    // }}}

    // {{{ renderContent
    protected function renderContent()
    {
        $content = '';
        $objects = [];

        try {
            $objects = $this->controller->getLogic()->getProjects();
            var_dump($objects);

            foreach ($objects as $object) {
                $content .= HTML::div('',
                    HTML::span('',
                        HTML::a('href=/edit/' . $this->class . '/' . $object->getId(), $object->getName())
                    ) .
                    HTML::span('',
                        HTML::a('href=/delete/' . $this->class . '/' . $object->getId(), 'löschen')
                    )
                );
            }
        } catch (\Exception $e) {}

        $content .= HTML::div('',
            HTML::span('',
                HTML::a('href=/edit/' . $this->class . '/', $this->class . ' hinzufügen')
            )
        );

        return $content;
    }
    // }}}
}
